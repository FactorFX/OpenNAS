<?php
/*
	access_kerberos.php

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

$pgtitle = array(gettext("Access"), gettext("Kerberos"));

if (!isset($config['kerberos']) || !is_array($config['kerberos']))
	$config['kerberos'] = array();

$type = array('ldap' => 'ldap', 'sss' => 'sss');

$pconfig['kdc'] = !empty($config['kerberos']['kdc']) ? $config['kerberos']['kdc'] : "";
$pconfig['realms']= !empty($config['kerberos']['realms']) ? $config['kerberos']['realms'] : "";
$pconfig['ldaphostname']= !empty($config['kerberos']['ldaphostname']) ? $config['kerberos']['ldaphostname'] : "";
$pconfig['ldapbase']= !empty($config['kerberos']['ldapbase']) ? $config['kerberos']['ldapbase'] : "";
if (isset($config['kerberos']['ldapauxparam']) && is_array($config['kerberos']['ldapauxparam']))
	$pconfig['ldapauxparam'] = implode("\n", $config['kerberos']['ldapauxparam']);
if (isset($config['kerberos']['sssdauxparam']) && is_array($config['kerberos']['sssdauxparam']))
	$pconfig['sssdauxparam'] = implode("\n", $config['kerberos']['sssdauxparam']);
$pconfig['type']= !empty($config['kerberos']['type']) ? $config['kerberos']['type'] : $type[0];
$pconfig['enable'] = isset($config['kerberos']['enable']);

if ($_POST) {
	unset($input_errors);
	$pconfig = $_POST;

	if (isset($_POST['enable']) && $_POST['enable']) {

		if (!in_array($_POST['type'], array_values($type))) {
			$input_errors[] = gettext('Type must be') . ' ' . implode(', ', $type);
		}

		if (!empty($_FILES['krb5']['tmp_name'])) {
			if (is_uploaded_file($_FILES['krb5']['tmp_name'])) {
				$fn = "/etc/krb5.keytab";
				move_uploaded_file($_FILES['krb5']['tmp_name'], $fn);
				chmod ($fn, 0600);
			} else {
				$errormsg = sprintf("%s %s", gettext("Failed to upload file."),
					$g_file_upload_error[$_FILES['krb5']['error']]);
			}
		}

	}

	if (empty($input_errors)) {

		$config['kerberos']['kdc'] = $_POST['kdc'];
		$config['kerberos']['realms']= $_POST['realms'];
		$config['kerberos']['ldaphostname']= $_POST['ldaphostname'];
		$config['kerberos']['ldapbase']= $_POST['ldapbase'];
		$config['kerberos']['type']= $_POST['type'];

		unset($config['kerberos']['ldapauxparam']);
		foreach (explode("\n", $_POST['ldapauxparam']) as $auxparam) {
			$auxparam = trim($auxparam, "\t\n\r");
			if (!empty($auxparam))
				$config['kerberos']['ldapauxparam'][] = $auxparam;
		}

		unset($config['kerberos']['sssdauxparam']);
		foreach (explode("\n", $_POST['sssdauxparam']) as $auxparam) {
			$auxparam = trim($auxparam, "\t\n\r");
			if (!empty($auxparam))
				$config['kerberos']['sssdauxparam'][] = $auxparam;
		}

		$config['kerberos']['enable'] = isset($_POST['enable']) ? true : false;

		write_config();

		$retval = 0;
		if (!file_exists($d_sysrebootreqd_path)) {
			config_lock();
			rc_exec_service("kerberos");
			$retval |= rc_update_service("sssd");
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
	document.iform.kdc.disabled = endis;
	document.iform.realms.disabled = endis;
	document.iform.ldaphostname.disabled = endis;
	document.iform.ldapbase.disabled = endis;
	document.iform.type.disabled = endis;
	document.iform.ldapauxparam.disabled = endis;
	document.iform.sssdauxparam.disabled = endis;

	toggle_ldap_sssd();
}

function toggle_ldap_sssd() {
	if ($('#type').val() == 'ldap') {
		$('[id^="ldap"]').closest('tr').show();
		$('[id^="sss"]').closest('tr').hide();
	}
	else if($('#type').val() == 'sss') {
		$('[id^="ldap"]').closest('tr').hide();
		$('[id^="sss"]').closest('tr').show();
	}
}
//-->
</script>
<form action="access_kerberos.php" method="post" name="iform" id="iform" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td class="tabcont">
				<?php if (!empty($input_errors)) print_input_errors($input_errors);?>
				<?php if (!empty($savemsg)) print_info_box($savemsg);?>
				<table width="100%" border="0" cellpadding="6" cellspacing="0">
					<?php html_titleline_checkbox("enable", gettext("Kerberos Protocol"), !empty($pconfig['enable']) ? true : false, gettext("Enable"), "enable_change(false)");?>
					<?php html_inputbox("kdc", "KDC", $pconfig['kdc'],"", true, 60);?>
					<?php html_inputbox("realms","Realms", $pconfig['realms'],"",  true, 60);?>
				<tr id="krb5_keytabid" style="display: visible">
						<td width="22%" valign="top" class="vncellreq"><?=htmlspecialchars("Krb5.keytab");?></td>
						<td width="78%" class="vtable">
							<input name="krb5" type="file" class="formfld" size="40" /><br />
						</td>
					</tr>
				<?php html_combobox("type", gettext("Type"), $pconfig['type'], $type, '', true, false, 'toggle_ldap_sssd()');?>
				<?php html_inputbox("ldaphostname", gettext("URI"), $pconfig['ldaphostname'], gettext("The space-separated list of URIs for the LDAP server."), true, 60);?>
				<?php html_inputbox("ldapbase", gettext("Base DN"), $pconfig['ldapbase'], sprintf(gettext("The default base distinguished name (DN) to use for searches, e.g. %s"), "dc=test,dc=org"), true, 40);?>
				<?php html_textarea("ldapauxparam", gettext("Ldap auxiliary parameters"), $pconfig['ldapauxparam'], sprintf(gettext("These parameters are added to %s."), "ldap.conf"), false, 65, 5, false, false);?>
				<?php html_textarea("sssdauxparam", gettext("Sss auxiliary parameters"), $pconfig['sssdauxparam'], sprintf(gettext("These parameters are added to %s."), "sssd.conf"), false, 65, 5, false, false);?>
				</table>
				<div id="submit">
					<input name="Submit" type="submit" class="formbtn" value="<?=gettext("Save");?>" onclick="enable_change(true)" />
				</div>
			</td>
		</tr>
	</table>
	<?php include("formend.inc");?>
</form>
<script type="text/javascript">
<!--
enable_change(false);
//-->
</script>
<?php include("fend.inc");?>