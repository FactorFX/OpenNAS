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

$pconfig = &$config['kerberos'];

if (!isset($pconfig) || !is_array($pconfig))
    $pconfig = array();

if ($_POST) {

	unset($_POST['authtoken'], $_POST['Submit']);
	$pconfig = $_POST;

	if (isset($_POST['enable']) && $_POST['enable']) {
		
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
		unset($pconfig['ldapauxparam']);
		foreach (explode("\n", $_POST['ldapauxparam']) as $auxparam) {
			$auxparam = trim($auxparam, "\t\n\r");
			if (!empty($auxparam))
				$pconfig['ldapauxparam'][] = $auxparam;
		}
	 }		
	 
	write_config();

	$retval = 0;
	if (!file_exists($d_sysrebootreqd_path)) {
		config_lock();
		rc_exec_service("kerberos");
		config_unlock();
	}
	
	$savemsg = get_std_save_message($retval);
	
}

if (isset($pconfig['ldapauxparam']) && is_array($pconfig['ldapauxparam']))
	$pconfig['ldapauxparam'] = implode("\n", $pconfig['ldapauxparam']);
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
	document.iform.ldapauxparam.disabled = endis;
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
					<?php html_titleline_checkbox("enable", gettext("Kerberos Protocol"), isset($pconfig['enable']) ? true : false, gettext("Enable"), "enable_change(false)");?>
					<?php html_inputbox("kdc", "KDC", $pconfig['kdc'],"", true, 60);?>
					<?php html_inputbox("realms","Realms", $pconfig['realms'],"",  true, 60);?>
				<tr id="krb5_keytabid" style="display: visible">
						<td width="22%" valign="top" class="vncellreq"><?=htmlspecialchars("Krb5.keytab");?></td>
						<td width="78%" class="vtable">
							<input name="krb5" type="file" class="formfld" size="40" /><br />
						</td>
					</tr>
				<?php html_inputbox("ldaphostname", gettext("URI"), $pconfig['ldaphostname'], gettext("The space-separated list of URIs for the LDAP server."), true, 60);?>
				<?php html_inputbox("ldapbase", gettext("Base DN"), $pconfig['ldapbase'], sprintf(gettext("The default base distinguished name (DN) to use for searches, e.g. %s"), "dc=test,dc=org"), true, 40);?>
				<?php html_textarea("ldapauxparam", gettext("Auxiliary parameters"), $pconfig['ldapauxparam'], sprintf(gettext("These parameters are added to %s."), "ldap.conf"), false, 65, 5, false, false);?>				
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
