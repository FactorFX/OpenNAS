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

$pgtitle = array(gettext("Services"), gettext("Ocs Inventory agent"));

if (!isset($config['ocsinventory_agent']) || !is_array($config['ocsinventory_agent']))
	$config['ocsinventory_agent'] = array();

$pconfig['server'] = !empty($config['ocsinventory_agent']['server']) ? $config['ocsinventory_agent']['server'] : "";
$pconfig['realm'] = !empty($config['ocsinventory_agent']['realm']) ? $config['ocsinventory_agent']['realm'] : "";
$pconfig['ocs_user'] = !empty($config['ocsinventory_agent']['ocs_user']) ? $config['ocsinventory_agent']['ocs_user'] : "";
$pconfig['password'] = !empty($config['ocsinventory_agent']['password']) ? $config['ocsinventory_agent']['password'] : "";
$pconfig['proxy'] = !empty($config['ocsinventory_agent']['proxy']) ? $config['ocsinventory_agent']['proxy'] : "";
$pconfig['ssl'] = isset($config['ocsinventory_agent']['ssl']);
$pconfig['ocs_cacert'] = !empty($config['ocsinventory_agent']['ocs_cacert']) ? $config['ocsinventory_agent']['ocs_cacert'] : "";
$pconfig['tag'] = !empty($config['ocsinventory_agent']['tag']) ? $config['ocsinventory_agent']['tag'] : "";
$pconfig['nosoftware'] = isset($config['ocsinventory_agent']['nosoftware']);
$pconfig['enable'] = isset($config['ocsinventory_agent']['enable']);

if ($_POST) {
	unset($input_errors);
	$pconfig = $_POST;
	$fn = "/usr/local/etc/ocsinventory/cacert.pem";

	if (isset($_POST['enable']) && $_POST['enable']) {

		$reqdfields = explode(" ", "realm ocs_user password tag");
		$reqdfieldsn = array(gettext("Realm"), gettext("User"), gettext("Password"), gettext("Tag"));
		$reqdfieldst = explode(" ", "string string password string");

		do_input_validation($_POST, $reqdfields, $reqdfieldsn, $input_errors);
		do_input_validation_type($_POST, $reqdfields, $reqdfieldsn, $reqdfieldst, $input_errors);

		if (!empty($_POST['server']) && !preg_match('#^https?://#', $_POST['server'])) {
			$prefix = gettext('must begin with http ot https');
			$input_errors[] = gettext("Server") . ' ' . $prefix;
		}

		if (!empty($_POST['proxy']) && !preg_match('#^https?://#', $_POST['proxy'])) {
			$prefix = gettext('must begin with http ot https');
			$input_errors[] = gettext("Proxy") . ' ' . $prefix;
		}
	}

	if (empty($input_errors)) {
		$config['ocsinventory_agent']['server'] = $_POST['server'];
		$config['ocsinventory_agent']['realm'] = $_POST['realm'];
		$config['ocsinventory_agent']['ocs_user'] = $_POST['ocs_user'];
		$config['ocsinventory_agent']['password'] = $_POST['password'];
		$config['ocsinventory_agent']['proxy'] = $_POST['proxy'];
		$config['ocsinventory_agent']['ssl'] = isset($_POST['ssl']) ? true : false;
		$config['ocsinventory_agent']['ocs_cacert'] = $_POST['ocs_cacert'];
		$config['ocsinventory_agent']['tag'] = $_POST['tag'];
		$config['ocsinventory_agent']['nosoftware'] = isset($_POST['nosoftware']) ? true : false;

		if ($_POST['delete_cacert']) {
			@unlink($pconfig['ocs_cacert']);
			unset($pconfig['ocs_cacert'], $config['ocsinventory_agent']['ocs_cacert']);
		}
		elseif (!empty($_FILES['ocs_cacert']['tmp_name'])) {
			if (is_uploaded_file($_FILES['ocs_cacert']['tmp_name'])) {
				move_uploaded_file($_FILES['ocs_cacert']['tmp_name'], $fn);
				$config['ocsinventory_agent']['ocs_cacert'] = $fn;
				chmod ($fn, 0600);
			} else {
				$input_errors[] = sprintf("%s %s", gettext("Failed to upload file."), $g_file_upload_error[$_FILES['ocs_cacert']['error']]);
			}
		}

		$config['ocsinventory_agent']['enable'] = isset($_POST['enable']) ? true : false;

		write_config();

		$retval = 0;
		if (!file_exists($d_sysrebootreqd_path)) {
			config_lock();
			$retval |= rc_update_service("ocsinventory_agent");
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
	document.iform.server.disabled = endis;
	document.iform.realm.disabled = endis;
	document.iform.ocs_user.disabled = endis;
	document.iform.password.disabled = endis;
	document.iform.proxy.disabled = endis;
	document.iform.ssl.disabled = endis;
	document.iform.ocs_cacert.disabled = endis;
	if (document.iform.delete_cacert != undefined) {
		document.iform.delete_cacert.disabled = endis;
	 }
	document.iform.tag.disabled = endis;
	document.iform.nosoftware.disabled = endis;
}
//-->
</script>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tabnavtbl">
			<ul id="tabnav">
				<li class="tabact"><a href="service_ocs_inventory.php" title="<?=gettext("Reload page");?>"><span><?=gettext("Ocs Inventory");?></span></a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td class="tabcont">
			<form action="<?php $_SERVER['PHP_SELF'];?>" method="post" name="iform" id="iform" enctype="multipart/form-data">
				<?php if (!empty($input_errors)) print_input_errors($input_errors);?>
				<?php if (!empty($savemsg)) print_info_box($savemsg);?>
				<table width="100%" border="0" cellpadding="6" cellspacing="0">
					<?php html_titleline_checkbox("enable", gettext("Ocs Inventory"), !empty($pconfig['enable']) ? true : false, gettext("Enable"), "enable_change(false)");?>
					<?php html_separator()?>
					<?php html_inputbox("server", gettext("Server"), $pconfig['server'], gettext("The uri of the server, http[s]://servername/ocsinventory"), true, 40);?>
					<?php html_inputbox("realm", gettext("Realm"), $pconfig['realm'], gettext("Use REALM for an HTTP identification with the server"), true, 40);?>
					<?php html_inputbox("ocs_user", gettext("User"), $pconfig['ocs_user'], gettext("Use USER for the server authentication"), true, 40);?>
					<?php html_passwordbox("password", gettext("Password"), $pconfig['password'], gettext('Use PASSWORD for an HTTP identification with the server'), true, 40);?>
					<?php html_inputbox("proxy", gettext("Proxy"), $pconfig['proxy'], gettext('Use PROXY to specify a proxy HTTP server, http[s]://serverproxy:port'), true, 40);?>
					<?php html_separator()?>
					<?php html_checkbox("ssl", gettext("Ssl Check"), !empty($pconfig['ssl']) ? true : false, gettext("Check SSL communications using a certificate"),"" , true);?>
					<tr id="cacert">
						<?php if(!file_exists($config['ocsinventory_agent']['ocs_cacert'])): ?>
						<td width="22%" valign="top" class="vncellreq"><?=htmlspecialchars("CA Certificate");?></td>
						<td width="78%" class="vtable">
							<input name="ocs_cacert" type="file" class="formfld" size="40" /><br />
							<?php gettext("CA certificate chain file in PEM format") ?><br/>
						<?php else: ?>
								<input name="ocs_cacert" type="hidden" value="<?= $config['ocsinventory_agent']['ocs_cacert'];?>" /><br />
								<?php html_checkbox("delete_cacert", gettext("Delete previous CA Certificate"), false, "","" , true);?>
						<?php endif; ?>
						</td>
					</tr>
					<?php html_inputbox("tag", gettext("Tag"), $pconfig['tag'], gettext("Mark the machine with the TAG"), false, 40)?>
					<?php html_checkbox("nosoftware", gettext("No software"), !empty($pconfig['nosoftware']) ? true : false, gettext("Do not inventory the software installed on the machine"), false);?>
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
