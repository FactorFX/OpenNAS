<?php
/*
	system_backup.php

	Part of NAS4Free (http://www.nas4free.org).
	Copyright (c) 2012-2015 The NAS4Free Project <info@nas4free.org>.
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

$pgtitle = array(gettext("System"), gettext("Backup/Restore"));

/* omit no-cache headers because it confuses IE with file downloads */
$omit_nocacheheaders = true;

// default is enable encryption
//$pconfig['encryption'] = "yes";

$old_default_password = "freenas";
$current_password = $config['system']['password'];
if (strcmp($current_password, $g['default_passwd']) === 0
   || strcmp($current_password, $old_default_password) === 0) {
	$errormsg = gettext("Current password is default password. You should use your own password.");
}

if ($_POST) {
	unset($errormsg);
	unset($input_errors);
	$pconfig['encryption'] = $_POST['encryption'];

	$encryption = 0;
	if (!empty($_POST['encryption']))
		$encryption = 1;
	if (0 == strcmp($_POST['Submit'], gettext("Restore configuration"))) {
		$mode = "restore";
	} else if (0 == strcmp($_POST['Submit'], gettext("Download configuration"))) {
		$mode = "download";
	}

	if ($encryption) {
		$reqdfields = explode(" ", "encrypt_password encrypt_password_confirm");
		$reqdfieldsn = array(gettext("Encrypt password"), gettext("Encrypt password (confirmed)"));
		$reqdfieldst = explode(" ", "password password");

		do_input_validation($_POST, $reqdfields, $reqdfieldsn, $input_errors);
		do_input_validation_type($_POST, $reqdfields, $reqdfieldsn, $reqdfieldst, $input_errors);

		if ($_POST['encrypt_password'] !== $_POST['encrypt_password_confirm']) {
			$input_errors[] = gettext("The confirmed password does not match. Please ensure the passwords match exactly.");
		}
	}

	if (empty($input_errors) && $mode) {
		if ($mode === "download") {
			config_lock();

			if(function_exists("date_default_timezone_set") and function_exists("date_default_timezone_get"))
			@date_default_timezone_set(@date_default_timezone_get());
			if ($encryption) {
				$fn = "config-{$config['system']['hostname']}.{$config['system']['domain']}-" . date("YmdHis") . ".gz";
				$password = $_POST['encrypt_password'];
				//$password = $config['system']['password'];
				$data = config_encrypt($password);
				$fs = strlen($data);
			} else {
				$fn = "config-{$config['system']['hostname']}.{$config['system']['domain']}-" . date("YmdHis") . ".xml";
				$data = file_get_contents("{$g['conf_path']}/config.xml");
				$fs = get_filesize("{$g['conf_path']}/config.xml");
			}

			header("Content-Type: application/octet-stream");
			header("Content-Disposition: attachment; filename={$fn}");
			header("Content-Length: {$fs}");
			header("Pragma: hack");
			echo $data;
			config_unlock();

			exit;
		} else if ($mode === "restore") {
			$encrypted = 0;
			if (is_uploaded_file($_FILES['conffile']['tmp_name'])) {
				// Validate configuration backup
				$validate = 0;
				if (pathinfo($_FILES['conffile']['name'], PATHINFO_EXTENSION) == 'gz') {
					$encrypted = 1;
					$gz_config = file_get_contents($_FILES['conffile']['tmp_name']);
					$password = $_POST['decrypt_password'];
					//$password = $config['system']['password'];
					$data = config_decrypt($password, $gz_config);
					if ($data !== FALSE) {
						$tempfile = tempnam(sys_get_temp_dir(), 'cnf');
						file_put_contents($tempfile, $data);
						$validate = validate_xml_config($tempfile, $g['xml_rootobj']);
						if (!$validate) {
							unlink($tempfile);
						}
					}
				} else {
					$validate = validate_xml_config($_FILES['conffile']['tmp_name'], $g['xml_rootobj']);
				}
				if (!$validate) {
					$errormsg = sprintf(gettext("The configuration could not be restored. %s"),
						$encrypted ? gettext("Invalid file format or incorrect password.") : gettext("Invalid file format."));
				} else {
					// Install configuration backup
					if ($encrypted) {
						$ret = config_install($tempfile);
						unlink($tempfile);
					} else {
						$ret = config_install($_FILES['conffile']['tmp_name']);
					}
					if ($ret == 0) {
						system_reboot();
						$savemsg = sprintf(gettext("The configuration has been restored. The server is now rebooting."));
					} else {
						$errormsg = gettext("The configuration could not be restored.");
					}
				}
			} else {
				$errormsg = sprintf(gettext("The configuration could not be restored. No file was uploaded!"),
					$g_file_upload_error[$_FILES['conffile']['error']]);
			}
		}
	}
}
?>
<?php include("fbegin.inc");?>
<script type="text/javascript">//<![CDATA[
$(document).ready(function(){
	function encrypt_change(encrypt_change) {
		var val = !($('#encryption').prop('checked') || encrypt_change);
		$('#encrypt_password').prop('disabled', val);
		$('#encrypt_password_confirm').prop('disabled', val);
		if (!encrypt_change) {
			if (val) {
				// disabled
				$('#encrypt_password_tr td:first').removeClass('vncellreq').addClass('vncell');
			} else {
				// enabled
				$('#encrypt_password_tr td:first').removeClass('vncell').addClass('vncellreq');
			}
		}
	}
	$('#encryption').click(function(){
		encrypt_change(false);
	});
	$('input:submit').click(function(){
		encrypt_change(true);
	});
	encrypt_change(false);
});
//]]>
</script>
<form action="system_backup.php" method="post" enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td class="tabcont">
				<?php if (!empty($input_errors)) print_input_errors($input_errors);?>
				<?php if (!empty($errormsg)) print_error_box($errormsg);?>
				<?php if (!empty($savemsg)) print_info_box($savemsg);?>
			  <table width="100%" border="0" cellspacing="0" cellpadding="6">
			    <tr>
			      <td colspan="2" class="listtopic"><?=gettext("Backup configuration");?></td>
			    </tr>
			    <tr>
					<td width="22%" valign="top" class="vncell"><?=gettext("Encryption");?></td>
					<td width="78%" class="vtable">
						<input name="encryption" type="checkbox" id="encryption" value="yes" <?php if (!empty($pconfig['encryption'])) echo "checked=\"checked\""; ?> />
					<?=gettext("Enable encryption.");?></td>
			    </tr>
			    <tr id="encrypt_password_tr">
					<td width="22%" valign="top" class="vncell"><label for="encrypt_password"><?=gettext("Encrypt password");?></label></td>
					<td width="78%" class="vtable">
						<input name="encrypt_password" type="password" class="formfld" id="encrypt_password" size="25" value="" /><br />
						<input name="encrypt_password_confirm" type="password" class="formfld" id="encrypt_password_confirm" size="25" value="" />&nbsp;(<?=gettext("Confirmation");?>)
					</td>
			    </tr>
			    <tr>
					<td width="22%" valign="baseline" class="vncell">&nbsp;</td>
					<td width="78%" class="vtable">
						<?=gettext("Click this button to download the server configuration in encrypted GZIP file or XML format.");?><br />
						<div id="remarks">
							<?php html_remark("note", gettext("Note"), sprintf("%s", /*gettext("Current administrator password is used for encryption.")*/ gettext("Encrypted configuration is automatically gzipped.")));?>
						</div>
						<div id="submit">
							<input name="Submit" type="submit" class="formbtn" id="download" value="<?=gettext("Download configuration");?>" />
						</div>
					</td>
			    </tr>
			    <tr>
			      <td colspan="2" class="list" height="12"></td>
			    </tr>
			    <tr>
			      <td colspan="2" class="listtopic"><?=gettext("Restore configuration");?></td>
			    </tr>
			    <tr id="decrypt_password_tr">
				<td width="22%" valign="top" class="vncell"><label for="decrypt_password"><?=gettext("Decrypt password");?></label></td>
				<td width="78%" class="vtable">
					<input name="decrypt_password" type="password" class="formfld" id="decrypt_password" size="25" value="" />
				</td>
			    </tr>
			    <tr>
					<td width="22%" valign="baseline" class="vncell">&nbsp;</td>
					<td width="78%" class="vtable">
						<?php echo sprintf(gettext("Select the server configuration encrypted GZIP file or XML file and click the button below to restore the configuration."));?><br />
						<div id="remarks">
							<?php html_remark("note", gettext("Note"), sprintf("%s", /*gettext("Current administrator password is used for decryption.")*/ gettext("The server will reboot after restoring the configuration.")));?>
						</div>
						<div id="submit">
						<input name="conffile" type="file" class="formfld" id="conffile" size="40" />
						</div>
						<div id="submit">
						<input name="Submit" type="submit" class="formbtn" id="restore" value="<?=gettext("Restore configuration");?>" />
						</div>
					</td>
			    </tr>
			  </table>
			</td>
		</tr>
	</table>
	<?php include("formend.inc");?>
</form>
<?php include("fend.inc");?>
