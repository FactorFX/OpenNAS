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

$pconfig = &$config['bacula_sd'];

if (!isset($pconfig) || !is_array($pconfig))
    $pconfig = array();

$bacula_port_range = array( '9101', '9102', '9103');
$bacula_type = array('File', 'tape', 'Fifo', 'DVD');

if ($_POST) {
	unset($_POST['Submit'], $_POST['authtoken']);

	$pconfig = $_POST;
	if (isset($_POST['enable']) && $_POST['enable']) {
        $pconfig['devicelabelmedia'] = isset($pconfig['devicealwaysopen']) ? 'yes' : 'no';
		$pconfig['devicerandomaccess'] = isset($pconfig['devicerandomaccess']) ? 'yes' : 'no';
		$pconfig['deviceremovablemedia'] = isset($pconfig['deviceremovablemedia']) ? 'yes' : 'no';
		$pconfig['devicealwaysopen'] = isset($pconfig['devicealwaysopen']) ? 'yes' : 'no';
	}    
	
	write_config();

	$retval = 0;
	if (!file_exists($d_sysrebootreqd_path)) {
		config_lock();
		$retval |= rc_update_service("bacula_sd");
		config_unlock();
	}
	$savemsg = get_std_save_message($retval);
}
?>
<?php include("fbegin.inc");?>
<script type="text/javascript">
<!--
function enable_change(enable_change) {
	var endis = !(document.iform.enable.checked || enable_change);
	document.iform.storagename.disabled = endis;
	document.iform.storageport.disabled = endis;
	document.iform.storagemaxjobs.disabled = endis;
	document.iform.directorname.disabled = endis;
	document.iform.directorpassword.disabled = endis;	
	document.iform.devicename.disabled = endis;
	document.iform.devicemediatype.disabled = endis;
	document.iform.devicearchivepath.disabled = endis;
	document.iform.devicerandomaccess.disabled = endis;
	document.iform.devicealwaysopen.disabled = endis;	
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
					<?php html_titleline("Device");?>
					<?php html_inputbox("devicename", gettext("Name"), $pconfig['devicename'], sprintf(gettext("Default is %s."), "OPENNAS-DEVICE-default"), true, 40);?>											
					<?php html_combobox("devicemediatype", gettext("Media type"), $pconfig['devicemediatype'], array_combine($bacula_type, $bacula_type), sprintf(gettext("Default is %s."), "File"), true)?>
					<?php html_filechooser("devicearchivepath", gettext("Archive device"), $pconfig['devicearchivepath'], '', '/mnt', true); ?>
					<?php html_checkbox("devicelabelmedia", gettext("Label media"), ($pconfig['devicelabelmedia']) == 'yes' ? true : false, gettext("Labeled the media")); ?>
					<?php html_checkbox("devicerandomaccess", gettext("Random access"), ($pconfig['devicerandomaccess']) == 'yes' ? true : false, gettext("The Storage daemon will submit a Mount Command before attempting to open the device")); ?>
					<?php html_checkbox("deviceremovablemedia", gettext("Removable media"), ($pconfig['deviceremovablemedia']) == 'yes' ? true : false, gettext("This device supports removable media")); ?>
					<?php html_checkbox("devicealwaysopen", gettext("Always open"), ($pconfig['devicealwaysopen']) == 'yes' ? true : false, gettext("Keep the device open")); ?>
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
