#!/usr/local/bin/php-cgi

<?php

require_once("config.inc");
require_once("util.inc");
require_once("disks.inc");
require_once("email.inc");
require_once("rc.inc");

function validEmailTo() {
	$shortopts = 'd:'; // Destinataire des emails d'alerte
	$opt = getopt($shortopts);
	if (!$opt) {
		return false;
	}
	
	// Si les options ont bien été récuperées
	$mailto = $opt['d'];
	if (!$mailto or !filter_var($mailto, FILTER_VALIDATE_EMAIL)) {
		echo "Please enter a valid email address (-d option)";
		exit(1);
	}
	return $mailto;
}

function getMailTo() {
	
	if ($mailto = validEmailTo()) {
		return $mailto;
	}
	else {
		exit(1);
	} 
	
}

function hasPreviousError() {
	$filename = 'prev_error.ini';
	
	if (file_exists($filename)) {
		$ini = parse_ini_file($filename);
		return $ini['error'];
	}
	
	return false;
}

function saveErrorState($error) {
	$filename = 'prev_error.ini';
	
	if (file_exists($filename)) {
		unlink($filename);
	}
	
	$file = fopen($filename, 'w');
	fwrite($file, 'error='.($error ? '1' : '0')."\n");
}

function execCmd($cmd) {
	mwexec2("{$cmd} 2>&1", $output, $status);
	
	return implode("\n", $output);
}

function runTests() {
	$errors = array();
	
	if (get_hast_role() == "primary") {
		$errors = array_merge($errors, testZPoolList());
		$errors = array_merge($errors, testZPoolStatus());
	}
	
	$errors = array_merge($errors, testHastCtlStatus());
	
	return $errors;
}

function testZPoolList() {
	$output = execCmd("/sbin/zpool list -H -o name,health");
	$res = explode("\t", $output, 2);
	
	if (Trim($res[1]) == 'ONLINE') {
		// OK
		return array();
	} else {
		// ERROR
		$output = execCmd("/sbin/zpool list");
		return array("zpool list : \n$output");
	}
}

function testZPoolStatus() {
	$output = execCmd("/sbin/zpool status -v");
	$res = explode("\n", $output);
	
	if (Trim($res[1]) == 'state: ONLINE') {
		// OK
		return array();
	} else {
		// ERROR
		return array("zpool status : \n$output");
	}
}

function testHastCtlStatus() {
	$disks = get_hast_disks_list();
	$errors = array();
	
	foreach ($disks as $i => $disk) {
		$replication = false;
		$dirty = false;
		
		$output = execCmd("/sbin/hastctl status ".$disk['name']);
		
		if ($disk['status'] != 'complete') {
			$errors []= "Disque ".$disk['name']." : mauvais statut (".$disk['status'].")";
		}
		
		$res = explode("\n", $output);
		
		foreach ($res as $row) {
			$pos = strpos(Trim($row), 'dirty');

			if ($pos === 0) {
				$dirty = true;
				$end = substr(Trim($row), $pos + 7);
				
				if (strlen($end) > 6) {
					$errors []= "Disque ".$disk['name']." : dirty ($end)";
				}
			}
			
			$pos = strpos(Trim($row), 'replication');
			if ($pos === 0) {
				$replication = true;
				$end = substr(Trim($row), $pos + 13);
				
				if ($end != 'fullsync') {
					$errors []= "Disque ".$disk['name']." : replication ($end)";
				}
			}
			
			if ($dirty and $replication) {
				break;
			}
		}
	}
	
	return $errors;
}

function sendErrorReport($errors) {
	$now = date("j/m/Y à H:i:s");
	$xml = simplexml_load_file('/conf/config.xml');
	$res = $xml->xpath('/opennas/interfaces');
	
	foreach ($res[0] as $key => $value) {
		$tmp .= "\n $key  :  " . $value->ipaddr . "";
	}
	
	$name = $xml->xpath('/opennas/system/hostname');
	
	$content = "Le " . $now . "\nUn échec est survenu sur le Nas \"" . $name['0'] . "\" ( " . get_hast_role() . " ) à l'adresse " . $tmp;
	$content .= "\nLes erreurs suivantes ont été détectées :\n";
	$content .= " - ".implode("\n - ", $errors);
	$content .= "\n\n Vous ne recevrez plus de message d'erreurs jusqu'au retour à la normale";
	
	email_send(getMailTo(), "Une erreur s'est produite sur OpenNAS", $content, $outError);
	return !$outError;
}

function sendSuccessReport() {
	$xml = simplexml_load_file('/conf/config.xml');
	$name = $xml->xpath('/opennas/system/hostname');
	email_send(getMailTo(), "Plus d'erreur détectées sur OpenNAS", "Aucune erreur n'a été détectée sur l'OpenNAS \"" . $name['0'] . "\" ( " . get_hast_role() . " ).", $outError);
	return !$outError;
}


if (!validEmailTo()) {
	echo "Please enter a valid email address (-d option)";
	exit(1);
}

$errors = runTests();

if (count($errors)) {
	if (!hasPreviousError()) {
		if (sendErrorReport($errors)) {
			saveErrorState(true);
		}
	}
} else {
	if (hasPreviousError()) {
		if (sendSuccessReport()) {
			saveErrorState(false);
		}
	}
}

?>
