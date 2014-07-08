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

$pgtitle = array(gettext("Services"), gettext("Bacula"), gettext("File daemon"));

if (!isset($config['bacula_fd']) || !is_array($config['bacula_fd']))
	$config['bacula_fd'] = array();

$bacula_port_range = array( '9101', '9102', '9103');

$pconfig['directorname'] = !empty($config['bacula_fd']['directorname']) ? $config['bacula_fd']['directorname'] : "OPENNAS-DIRECTOR-bacula";
$pconfig['directorpassword'] = !empty($config['bacula_fd']['directorpassword']) ? $config['bacula_fd']['directorpassword'] : "";
$pconfig['filedaemonname'] = !empty($config['bacula_fd']['filedaemonname']) ? $config['bacula_fd']['filedaemonname'] : "OPENNAS-CLIENT-bacula";
$pconfig['filedaemonport'] = !empty($config['bacula_fd']['filedaemonport']) ? $config['bacula_fd']['filedaemonport'] : $bacula_port_range[0];
$pconfig['filedaemonmaxjobs'] = !empty($config['bacula_fd']['filedaemonmaxjobs']) ? $config['bacula_fd']['filedaemonmaxjobs'] : "20";
$pconfig['enable'] = isset($config['bacula_fd']['enable']);

if ($_POST) {
	unset($input_errors);
	$pconfig = $_POST;

	/* input validation */
	$reqdfields = array();
	$reqdfieldsn = array();

	if (isset($_POST['enable']) && $_POST['enable']) {

		$reqdfields = array_merge($reqdfields, explode(" ", "directorname"));
		$reqdfieldsn = array_merge($reqdfieldsn, array(gettext("Director Name")));
		$reqdfieldst = explode(" ", "string");

		$reqdfields = array_merge($reqdfields, array("directorpassword"));
		$reqdfieldsn = array_merge($reqdfieldsn, array(gettext("Director Password")));
		$reqdfieldst = array_merge($reqdfieldst, array("password"));

		$reqdfields = array_merge($reqdfields, array("filedaemonname"));
		$reqdfieldsn = array_merge($reqdfieldsn, array(gettext("File Daemon Name")));
		$reqdfieldst = array_merge($reqdfieldst, array("string"));

		if ((1 > $_POST['filedaemonmaxjobs']) || (50 < $_POST['filedaemonmaxjobs'])) {
			$input_errors[] = gettext("The number of maximum concurent jobs must be between 1 and 50.");
		}

		if (!in_array($_POST['filedaemonport'], $bacula_port_range)) {
			$input_errors[] = gettext("The port number must be ".implode(', ', $bacula_port_range));
		}
	}

	do_input_validation($_POST, $reqdfields, $reqdfieldsn, $input_errors);
	do_input_validation_type($_POST, $reqdfields, $reqdfieldsn, $reqdfieldst, $input_errors);

	if (empty($input_errors)) {
		$config['bacula_fd']['directorname'] = $_POST['directorname'];
		$config['bacula_fd']['directorpassword'] = $_POST['directorpassword'];
		$config['bacula_fd']['filedaemonname'] = $_POST['filedaemonname'];
		$config['bacula_fd']['filedaemonport'] = $_POST['filedaemonport'];
		$config['bacula_fd']['filedaemonmaxjobs'] = $_POST['filedaemonmaxjobs'];
		$config['bacula_fd']['enable'] = isset($_POST['enable']) ? true : false;

		write_config();

		$retval = 0;
		if (!file_exists($d_sysrebootreqd_path)) {
			config_lock();
			$retval |= rc_update_service("bacula_fd");
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
	var endis = !(document.iform.enable.checked || enable_change);
	document.iform.directorname.disabled = endis;
	document.iform.directorpassword.disabled = endis;
	document.iform.filedaemonname.disabled = endis;
	document.iform.filedaemonport.disabled = endis;
	document.iform.filedaemonmaxjobs.disabled = endis;
}
//-->
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tabnavtbl">
			<ul id="tabnav">
				<li class="tabact"><a href="services_bacula_file_daemon.php" title="<?=gettext("Reload page");?>"><span><?=gettext("File daemon");?></span></a></li>
				<li class="tabinact"><a href="services_bacula_storage_daemon.php"><span><?=gettext("Storage daemon");?></span></a></li>
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
					<?php html_titleline("Director");?>
					<?php html_inputbox("directorname", gettext("Name"), $pconfig['directorname'], sprintf(gettext("Default is %s."), "OPENNAS-DIRECTOR-bacula"), true, 40);?>
					<?php html_passwordbox("directorpassword", gettext("Password"), $pconfig['directorpassword'], '', true, 40);?>
					<?php html_separator()?>
					<?php html_titleline("File daemon");?>
					<?php html_inputbox("filedaemonname", gettext("Name"), $pconfig['filedaemonname'], sprintf(gettext("Default is %s."), "OPENNAS-CLIENT-bacula"), true, 40);?>
					<?php html_combobox("filedaemonport", gettext("Port"), $pconfig['filedaemonport'], array_combine($bacula_port_range, $bacula_port_range), sprintf(gettext("Default is %s."), "9102"), true)?>
					<?php html_inputbox("filedaemonmaxjobs", gettext("Maximum Concurrent Jobs"), $pconfig['filedaemonmaxjobs'], sprintf(gettext("Default is %s."), "20"), true, 4)?>
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
