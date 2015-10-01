#!/usr/local/bin/php-cgi

<?php

require_once("config.inc");
require_once("util.inc");
require_once("disks.inc");
require_once("email.inc");
require_once("rc.inc");

$emails = [
	'chgmtEtat' => "Le @@now \nUn changement d'état à été détecté sur l'OpenNAS @@hostname à l'adresse @@adresses",
	'snapEchoue' => "Le @@now \nUn snapshop à échoué sur le serveur @@hostname à l'adresse @@adresses @@test\n - Il est possible que la synchronisation des snapshots ne se fait plus\n - Il se peut que les membres ne se voient pas\n - Une réplication complète peut être requise, mais une analyse manuelle est recommandée pour éviter cette première solution",
	'snapNotequal' => "Le @@now \nUn snapshop à échoué sur le serveur @@hostname à l'adresse @@adresses @@test\n - Les snapshots ne sont pas égaux, analyser sur les deux machines avec : \n # zfs list -t snapshot",
	'firstSnapmissing' => "Le @@now \nUn snapshop à échoué sur le serveur @@hostname à l'adresse @@adresses @@test\n - Le premier snapshot semble manquant. Un snapshot complet est requis",
	'zfsRunning' => "Le @@now \nUn snapshop à échoué sur le serveur @@hostname à l'adresse @@adresses @@test\n - Une commande zfs est lancée. Il n'est pas possible de démarrer un snapshot",
	'carpSamestate' => "Le @@now \nUn snapshop à échoué sur le serveur @@hostname à l'adresse @@adresses @@test\n - Les interfaces carp des serveurs sont dans le même état",
	'oldSnapmissing' => "Le @@now \nUn snapshop à échoué sur le serveur @@hostname à l'adresse @@adresses @@test\n - Le snapshot de base niveau incrémentiel semble manquant. Un snapshot complet est requis"
];
/*
 *  Options are
 *  e => for email destination, if specify override all previous (from web config)
 *  c => email index
 *  f => extra parameters to parse email string is optional
 *
 */

function getOptions() {
	global $emails, $mailTo;

	$shortopts = "e:c:f::";
	$options = getopt($shortopts);

	$mailTo = $options['e'];
	if (!$mailTo or !filter_var($mailTo, FILTER_VALIDATE_EMAIL)) {
		echo "Please enter a valid email address (-e option)";
		exit(1);
	}

	$emailIndex = $options['c'];
	if (!isset($emails[$emailIndex]))
	{
		echo "Please specify a existing email index (-c option)";
		exit(1);
	}

	$vars = [
		'mailTo' => $mailTo,
		'email' => $emails[$emailIndex]
	];

	if ($options['f'])
	{
		$keys = $values = [];

		foreach (explode(' ', $options['f']) as $index => $param)
		{
			if ($index % 2 == 0)
			{
				$keys[] = $param;
			}
			else
			{
				$values[] = $param;
			}
		}
		$vars['params'] = array_combine($keys, $values);
	}

	return $vars;
}

function parseEmail($content, $extra = false) {
	$now = date("j/m/Y à H:i:s");
	$xml = simplexml_load_file('/conf/config.xml');
	$res = $xml->xpath('/opennas/interfaces');

	$adresses = '';
	foreach ($res[0] as $key => $value) {
		$adresses .= "\n $key  :  " . $value->ipaddr . "";
	}

	$hostname = $xml->xpath('/opennas/system/hostname');
	$hostname = $hostname['0'];

	if ($extra)
	{
		extract($extra);
	}

	if (preg_match_all('#@@([a-zA-Z0-9]+)#', $content, $matches, PREG_SET_ORDER));
	{
		foreach ($matches as $m)
		{
			 $content = preg_replace("#$m[0]#", $$m[1], $content);
		}
	}
	return $content;
}

function sendErrorReport() {

	$options = getOptions();

	$extra_vars = (isset($options['params'])) ? $options['params']: false;

	$content = parseEmail($options['email'], $extra_vars);

	email_send($options['mailTo'], "Une erreur s'est produite sur OpenNAS", $content, $outError);
	exit($outError);
}

sendErrorReport()

?>
