<?php
/*
	services_bacula.php

	Part of NAS4Free (http://www.nas4free.org).
	Copyright (c) 2012-2013 The NAS4Free Project <info@nas4free.org>.
	All rights reserved.

	Portions of freenas (http://www.freenas.org).
	Copyright (c) 2005-2011 by Olivier Cochard <olivier@freenas.org>.
	All rights reserved.

	Redistribution and use in source and binary forms, with or without
	modification, are permitted provided that the following conditions are met:

	1. Redistributions of source code must retain the above copyright notice, this
	   list of conditions and the following disclaimer.
	2. Redistributions in binary form must reproduce the above copyright notice,
	   this list of conditions and the following disclaimer in the documentation
	   and/or other materials provided with the distribution.

	THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
	ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
	WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
	DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
	ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
	(INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
	LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
	ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
	(INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
	SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

	The views and conclusions contained in the software and documentation are those
	of the authors and should not be interpreted as representing official policies,
	either expressed or implied, of the NAS4Free Project.
*/
require("auth.inc");
require("guiconfig.inc");

$pgtitle = array(gettext("Services"), gettext("Bacula"), gettext("Storage Daemon"));

if (!isset($config['bacula_sd']) || !is_array($config['bacula_sd']))
	$config['bacula_sd'] = array();

$bacula_port_range = array( '9101', '9102', '9103');
$bacula_type = array('File', 'tape', 'Fifo', 'DVD');

$pconfig['storagename'] = !empty($config['bacula_sd']['storagename']) ? $config['bacula_sd']['storagename'] : "OPENNAS-STORAGE-bacula";
$pconfig['storageport'] = !empty($config['bacula_sd']['storageport']) ? $config['bacula_sd']['storageport'] : $bacula_port_range[1];
$pconfig['storagemaxjobs'] = !empty($config['bacula_sd']['storagemaxjobs']) ? $config['bacula_sd']['storagemaxjobs'] : "20";
$pconfig['directorname'] = !empty($config['bacula_sd']['directorname']) ? $config['bacula_sd']['directorname'] : "OPENNAS-DIRECTOR-bacula";
$pconfig['directorpassword'] = !empty($config['bacula_sd']['directorpassword']) ? $config['bacula_sd']['directorpassword'] : "";
$pconfig['enable'] = isset($config['bacula_sd']['enable']);

if (!isset($config['bacula_sd']['device'])) {
	$pconfig['device'][0] = array();
}
elseif(!isset($_POST['add_device']) && !isset($_POST['remove_device'])) {
	$pconfig['device'] = $config['bacula_sd']['device'];
}elseif (isset($_POST['add_device'])) {echo 'add';
	$pconfig['device'] = $_POST['device'];
	$pconfig['device'][] = array();
}elseif(isset($_POST['remove_device'])){echo 'remove';
	$pconfig['device'] = $_POST['device'];
	unset($pconfig['device'][$_POST['remove_device']]);
}

foreach ($pconfig['device'] as $nb_device => $device) {
	$pconfig['device'][$nb_device]['name'] = !empty($device['name']) ? $device['name'] : "OPENNAS-DEVICE-default";
	$pconfig['device'][$nb_device]['mediatype'] = !empty($device['mediatype']) ? $device['mediatype'] : $bacula_type[0];
	$pconfig['device'][$nb_device]['archivepath'] = !empty($device['archivepath']) ? $device['archivepath'] : "";
	$pconfig['device'][$nb_device]['labelmedia'] = isset($device['labelmedia']);
	$pconfig['device'][$nb_device]['randomaccess'] = isset($device['randomaccess']);
	$pconfig['device'][$nb_device]['removablemedia'] = isset($device['removablemedia']);
	$pconfig['device'][$nb_device]['alwaysopen'] = isset($device['alwaysopen']);
}

if (isset($_POST['Submit']) && $_POST['Submit']) {
	unset($input_errors);
	$pconfig = $_POST;

	/* input validation */
	$reqdfields = array();
	$reqdfieldsn = array();

	if (isset($_POST['enable']) && $_POST['enable']) {

		$reqdfields = array_merge($reqdfields, explode(" ", "storagename"));
		$reqdfieldsn = array_merge($reqdfieldsn, array(gettext("Storage Name")));
		$reqdfieldst = explode(" ", "string");

		$reqdfields = array_merge($reqdfields, array("directorname"));
		$reqdfieldsn = array_merge($reqdfieldsn, array(gettext("Director Name")));
		$reqdfieldst = array_merge($reqdfieldst, array("string"));

		$reqdfields = array_merge($reqdfields, array("directorpassword"));
		$reqdfieldsn = array_merge($reqdfieldsn, array(gettext("Director Password")));
		$reqdfieldst = array_merge($reqdfieldst, array("password"));

		if (!in_array($_POST['storageport'], $bacula_port_range)) {
			$input_errors[] = gettext("The port number must be ".implode(', ', $bacula_port_range));
		}

		foreach ($_POST['device'] as $id => $device) {
			$sub = gettext("Device") . ' n° ' . ($id+1) . ' : ';
			if (!in_array($device['mediatype'], $bacula_type)) {
				$input_errors[] = $sub. gettext("The media type must be ".implode(', ', $bacula_type));
			}
			if (empty($device['archivepath'])) {
				$input_errors[] = $sub . gettext("Archive path cannot be empty");
			}
		}
	}

	do_input_validation($_POST, $reqdfields, $reqdfieldsn, $input_errors);
	do_input_validation_type($_POST, $reqdfields, $reqdfieldsn, $reqdfieldst, $input_errors);

	if (empty($input_errors)) {
		$config['bacula_sd']['storagename'] = $_POST['storagename'];
		$config['bacula_sd']['storageport'] = $_POST['storageport'];
		$config['bacula_sd']['storagemaxjobs'] = $_POST['storagemaxjobs'];
		$config['bacula_sd']['directorname'] = $_POST['directorname'];
		$config['bacula_sd']['directorpassword'] = $_POST['directorpassword'];

		unset($config['bacula_sd']['device']);
		foreach ($_POST['device'] as $device_nb => $device) {
			$config['bacula_sd']['device'][$device_nb]['name'] = $_POST['device'][$device_nb]['name'];
			$config['bacula_sd']['device'][$device_nb]['mediatype'] = $_POST['device'][$device_nb]['mediatype'];
			$config['bacula_sd']['device'][$device_nb]['archivepath'] = $_POST['device'][$device_nb]['archivepath'];
			$config['bacula_sd']['device'][$device_nb]['labelmedia'] = isset($_POST['device'][$device_nb]['labelmedia']) ? true : false;
			$config['bacula_sd']['device'][$device_nb]['randomaccess'] = isset($_POST['device'][$device_nb]['randomaccess']) ? true : false;
			$config['bacula_sd']['device'][$device_nb]['removablemedia'] = isset($_POST['device'][$device_nb]['removablemedia']) ? true : false;
			$config['bacula_sd']['device'][$device_nb]['alwaysopen'] = isset($_POST['device'][$device_nb]['alwaysopen']) ? true : false;
		}

		$config['bacula_sd']['enable'] = isset($_POST['enable']) ? true : false;

		write_config();

		$retval = 0;
		if (!file_exists($d_sysrebootreqd_path)) {
		config_lock();
		$retval |= rc_update_service("bacula_sd");
		config_unlock();
		}
		$savemsg = get_std_save_message($retval);
	}
}
?>
<?php include("fbegin.inc");?>
<script type="text/javascript">
<!--
function enable_change(enable_change) {
	var endis = !(document.iform.enable.checked || enable_change),
	device_length = <?= count($pconfig['device'])?>;
	document.iform.storagename.disabled = endis;
	document.iform.storageport.disabled = endis;
	document.iform.storagemaxjobs.disabled = endis;
	document.iform.directorname.disabled = endis;
	document.iform.directorpassword.disabled = endis;

	for (var i = 0; i < device_length; i++) {
		document.getElementById("device["+i+"][name]").disabled = endis;
		document.getElementById("device["+i+"][mediatype]").disabled = endis;
		document.getElementById("device_"+i+"_archivepath").disabled = endis;
		document.getElementById("device["+i+"][labelmedia]").disabled = endis;
		document.getElementById("device["+i+"][randomaccess]").disabled = endis;
		document.getElementById("device["+i+"][alwaysopen]").disabled = endis;
	}

	$('a#add_device').click(function(){
		$('#iform').append('<input type="hidden" name="add_device" value="1">').submit();
	});
	$('a[id^=remove_device]').click(function(){
		if (confirm('<?=gettext("Do you really want to delete this device?");?>')) {
			var id = /_(\d+)+$/.exec(this.id)[1];
			$('#iform').append('<input type="hidden" name="remove_device" value="'+id+'">').submit();
		}
	});
	$('#iform').submit(function(e){
		$('input[id$="_archivepath"]').attr('name', function(){
			console.log(this.name.replace(/device_/, 'device[').replace(/_archivepath/, '][archivepath]'));
			return this.name.replace(/device_/, 'device[').replace(/_archivepath/, '][archivepath]');
		});
	});
}
//-->
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tabnavtbl">
			<ul id="tabnav">
				<li class="tabinact"><a href="services_bacula_file_daemon.php"><span><?=gettext("File daemon");?></span></a></li>
				<li class="tabact"><a href="services_bacula_storage_daemon.php" title="<?=gettext("Reload page");?>"><span><?=gettext("Storage daemon");?></span></a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td class="tabcont">
			<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" name="iform" id="iform">
				<?php if (!empty($input_errors)) print_input_errors($input_errors);?>
				<?php if (!empty($savemsg)) print_info_box($savemsg);?>
				<table width="100%" border="0" cellpadding="6" cellspacing="0">
					<?php html_titleline_checkbox("enable", gettext("Bacula"), !empty($pconfig['enable']) ? true : false, gettext("Enable"), "enable_change(false)");?>
					<?php html_separator()?>
					<?php html_titleline("Storage");?>
					<?php html_inputbox("storagename", gettext("Name"), $pconfig['storagename'], sprintf(gettext("Default is %s."), "OPENNAS-STORAGE-bacula"), true, 40);?>
					<?php html_combobox("storageport", gettext("Port"), $pconfig['storageport'], array_combine($bacula_port_range, $bacula_port_range), sprintf(gettext("Default is %s."), "9103"), true)?>
					<?php html_inputbox("storagemaxjobs", gettext("Maximum Concurrent Jobs"), $pconfig['storagemaxjobs'], sprintf(gettext("Default is %s."), "20"), true, 4)?>

					<?php html_separator()?>
					<?php html_titleline("Director");?>
					<?php html_inputbox("directorname", gettext("Name"), $pconfig['directorname'], sprintf(gettext("Default is %s."), "OPENNAS-DIRECTOR-bacula"), true, 40);?>
					<?php html_passwordbox("directorpassword", gettext("Password"), $pconfig['directorpassword'], '', true, 40);?>

					<?php html_separator()?>
					<?php foreach ($pconfig['device'] as $id => $device):?>
						<?php $device_nb = $id+1;?>
						<?php html_titleline("Device $device_nb");?>
						<?php html_inputbox("device[$id][name]", gettext("Name"), $pconfig['device'][$id]['name'], sprintf(gettext("Default is %s."), "OPENNAS-DEVICE-default"), true, 40);?>
						<?php html_combobox("device[$id][mediatype]", gettext("Media type"), $pconfig['device'][$id]['mediatype'], array_combine($bacula_type, $bacula_type), sprintf(gettext("Default is %s."), "File"), true)?>
						<?php html_filechooser("device_".$id."_archivepath", gettext("Archive device"), $pconfig['device'][$id]['archivepath'], '', '/mnt', true); ?>
						<?php html_checkbox("device[$id][labelmedia]", gettext("Label media"), !empty($pconfig['device'][$id]['labelmedia']), gettext("Labeled the media")); ?>
						<?php html_checkbox("device[$id][randomaccess]", gettext("Random access"), !empty($pconfig['device'][$id]['randomaccess']), gettext("The Storage daemon will submit a Mount Command before attempting to open the device")); ?>
						<?php html_checkbox("device[$id][removablemedia]", gettext("Removable media"), !empty($pconfig['device'][$id]['removablemedia']), gettext("This device supports removable media")); ?>
						<?php html_checkbox("device[$id][alwaysopen]", gettext("Always open"), !empty($pconfig['device'][$id]['alwaysopen']), gettext("Keep the device open")); ?>
						<?php if($id !== 0):?>
						<tr>
							<td class="list"><a href="#" id="remove_device_<?=$id?>"><img src="del.gif" title="<?=gettext("Add device");?>" border="0" alt="<?=gettext("Add device");?>" /></a></td>
						</tr>
						<?php endif;?>
						<?php html_separator()?>
					<?php endforeach;?>
					<tr>
						<td class="list" colspan="3"></td>
						<td class="list"><a href="#" id="add_device"><img src="plus.gif" title="<?=gettext("Add device");?>" border="0" alt="<?=gettext("Add device");?>" /></a></td>
					</tr>

				</table>
				<div id="submit">
					<input name="Submit" type="submit" class="formbtn" value="<?=gettext("Save and Restart");?>" onclick="enable_change(true)" />
				</div>
				<?php include("formend.inc");?>
			</form>
		</td>
	</tr>
</table>
<script type="text/javascript">
<!--
enable_change(false);
//-->
</script>
<?php include("fend.inc");?>
