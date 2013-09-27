<?php
/*
	disks_init.php
	
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

$pgtitle = array(gettext("Disks"), gettext("Format"));

// Get list of all supported file systems.
$a_fst = get_fstype_list();
unset($a_fst['ntfs']); // Remove NTFS: can't format on NTFS under NAS4Free
unset($a_fst['geli']); // Remove geli
unset($a_fst['cd9660']); // Remove cd9660: can't format a CD/DVD !
$a_fst = array_slice($a_fst, 1); // Remove the first blank line 'unknown'
unset($a_fst['ufs']); // Remove old UFS type: Now NAS4Free will impose only one UFS type: GPT/EFI with softupdate
unset($a_fst['ufs_no_su']);
unset($a_fst['ufsgpt_no_su']);

// Load the /etc/cfdevice file to find out on which disk the OS is installed.
$cfdevice = trim(file_get_contents("{$g['etc_path']}/cfdevice"));
$cfdevice = "/dev/{$cfdevice}";

// Get list of all configured disks (physical and virtual).
$a_disk = get_conf_all_disks_list_filtered();

function get_fs_type($devicespecialfile) {
	global $a_disk;
	$index = array_search_ex($devicespecialfile, $a_disk, "devicespecialfile");
	if (false === $index)
		return "";
	return $a_disk[$index]['fstype'];
}

if (is_ajax()) {
	$devfile = $_GET['devfile'];
	$fstype = get_fs_type($devfile);
	render_ajax($fstype);
}

function filter_disk($array) {
	return array_filter($array, function($diskv){
		if (0 != strcmp($diskv['size'], "NA") && 1 != disks_exists($diskv['devicespecialfile'])) return $diskv;
	});
}

// Advanced Format
$pconfig['aft4k'] = $aft4k = false;

$do_format = array();
$disks = array();
$type = 'zfs';
$minspace = '';
$volumelabels = $_volumelabels= array();

if ($_POST) {
	unset($input_errors);
	unset($errormsg);
	unset($do_format);

	$disks = $_POST['disks'];
	$type = $_POST['type'];
	$minspace = $_POST['minspace'];
	$notinitmbr = isset($_POST['notinitmbr']) ? true : false;
	$aft4k = isset($_POST['aft4k']) ? true : false;
	$volumelabels = explode(" ", trim($_POST['volumelabels']));

	// Input validation.
	$reqdfields = explode(" ", "disks type");
	$reqdfieldsn = array(gettext("Disk"),gettext("Type"));
	do_input_validation($_POST, $reqdfields, $reqdfieldsn, $input_errors);

	foreach($volumelabels as $volumelabel) {
		$reqdfields = explode(" ", "volumelabel");
		$reqdfieldsn = array(gettext("Volume label"));
		$reqdfieldst = explode(" ", "alias");
		do_input_validation_type(array('volumelabel' => $volumelabel), $reqdfields, $reqdfieldsn, $reqdfieldst, $input_errors);
	}
	
	if (count($volumelabels) > 1 && count($volumelabels) > count($disks)) {
		$input_errors[] = gettext("Wrong number of argument for Volume label");
	}

	if (empty($input_errors)) {
		$do_format = array();
	
		if (count($disks)>0) {
			
			foreach ($disks as $key => $disk) {
				$do_format[$key] = true;
				// Check whether disk is mounted.
				if (disks_ismounted_ex($disk, "devicespecialfile")) {
					$errormsg = sprintf(gettext("The disk is currently mounted! <a href='%s'>Unmount</a> this disk first before proceeding."), "disks_mount_tools.php?disk={$disk}&action=umount");
					$do_format[$key] = true;
				}

				// Check if user tries to format the OS disk.
				if (preg_match("/" . preg_quote($disk, "/") . "\D+/", $cfdevice)) {
					$input_errors[] = gettext("Can't format the OS origin disk!");
					$do_format[$key] = false;
				}
				
				if ($do_format[$key]) {
					// Set new file system type attribute ('fstype') in configuration.
					set_conf_disk_fstype($disk, $type);
					
					if (count($volumelabels) == 1 && count($disks) > 1) {
						for ($i=0; $i < count($disks); $i++) {
							$_volumelabels[$i] = "${volumelabels[0]}${i}";
						}
					} 
					elseif(count($volumelabels) == 1 && count($disks) == 1) {
						$_volumelabels[0] = $volumelabels[0];
					}
					else {
						$_volumelabels = $volumelabels;
					}
					print_r($volumelabels);
					write_config();

					// Update list of configured disks.
					$a_disk = get_conf_all_disks_list_filtered();
				}
			}
		}
	}
}

if (empty($do_format)) {

}
?>
<?php include("fbegin.inc");?>
<script type="text/javascript">//<![CDATA[
$(document).ready(function(){
	var gui = new GUI;
	$('#type').change(function(){
		switch ($('#type').val()) {
		case "ufsgpt":
			$('#minspace_tr').show();
			$('#volumelabel_tr').show();
			$('#aft4k_tr').show();
			break;
		case "ext2":
		case "msdos":
			$('#minspace_tr').hide();
			$('#volumelabel_tr').show();
			$('#aft4k_tr').hide();
			break;
		default:
			$('#minspace_tr').hide();
			$('#volumelabel_tr').hide();
			$('#aft4k_tr').hide();
			break;
		}  
	});
	$('#type').change();
});
//]]>
</script>
<form action="disks_init.php" method="post" name="iform" id="iform">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
	    <td class="tabcont">
				<?php if(!empty($input_errors)) print_input_errors($input_errors);?>
				<?php if(!empty($errormsg)) print_error_box($errormsg);?>
			  <table width="100%" border="0" cellpadding="6" cellspacing="0">
			    <tr>
			      <td valign="top" class="vncellreq"><?=gettext("Disks"); ?></td>
			      <td class="vtable">
					  <?php if (count($a_disks_filter = filter_disk($a_disk))>0) :?>
					  <select name="disks[]" class="formselect" id="disks" multiple='true' size='10'>
						<?php foreach ($a_disks_filter as $diskv):?>
							<option value="<?=$diskv['devicespecialfile'];?>" <?php if (in_array($diskv['devicespecialfile'], $disks)) echo "selected=\"selected\"";?>>
							<?php $diskinfo = disks_get_diskinfo($diskv['devicespecialfile']); echo htmlspecialchars("{$diskv['name']}: {$diskinfo['mediasize_mbytes']}MB ({$diskv['desc']})");?>
							</option>
						<?php endforeach;?>
						</select>
					<?php else: ?>
						<?=sprintf(gettext("No disks available. Please add new <a href='%s'>disk</a> first."),'disks_manage.php'); ?>
					<?php endif;?>
			      </td>
					</tr>
					<tr>
				    <td valign="top" class="vncellreq"><?=gettext("File system");?></td>
				    <td class="vtable">
				      <select name="type" class="formfld" id="type">
				        <?php foreach ($a_fst as $fstval => $fstname): ?>
				        <option value="<?=$fstval;?>" <?php if($type == $fstval) echo 'selected="selected"';?>><?=htmlspecialchars($fstname);?></option>
				        <?php endforeach; ?>
				       </select>
				    </td>
					</tr>
					<tr id="volumelabel_tr">
						<td width="22%" valign="top" class="vncell"><?=gettext("Volume label");?></td>
						<td width="78%" class="vtable">
							<input name="volumelabels" type="text" class="formfld" id="volumelabels" size="100" value="<?php echo !empty($volumelabels)?htmlspecialchars(trim(implode(' ', $volumelabels))):'';?>" /><br />
							<?=gettext("Volume label of the new file system.");?><?=gettext("Use a space to separate multiple (if only one specify is autoincrement)");?>
						</td>
					</tr>
					<tr id="minspace_tr">
						<td width="22%" valign="top" class="vncell"><?=gettext("Minimum free space");?></td>
						<td width="78%" class="vtable">
							<select name="minspace" class="formfld" id="minspace">
							<?php $types = explode(",", "8,7,6,5,4,3,2,1"); $vals = explode(" ", "8 7 6 5 4 3 2 1");?>
							<?php $j = 0; for ($j = 0; $j < count($vals); $j++): ?>
								<option value="<?=$vals[$j];?>"><?=htmlspecialchars($types[$j]);?></option>
							<?php endfor; ?>
							</select>
							<br /><?=gettext("Specify the percentage of space held back from normal users. Note that lowering the threshold can adversely affect performance and auto-defragmentation.") ;?>
						</td>
					</tr>
			    <?php html_checkbox("aft4k", gettext("Advanced Format"), $pconfig['aft4k'] ? true : false, gettext("Enable Advanced Format (4KB sector)"), "", false, "");?>
			    <tr>
			      <td width="22%" valign="top" class="vncell"><?=gettext("Don't Erase MBR");?></td>
			      <td width="78%" class="vtable">
			        <input name="notinitmbr" id="notinitmbr" type="checkbox" value="yes" />
			        <?=gettext("Don't erase the MBR (useful for some RAID controller cards)");?>
						</td>
				  </tr>
				</table>
				<div id="submit">
					<input name="Submit" type="submit" class="formbtn" value="<?=gettext("Format disk");?>" onclick="return confirm('<?=gettext("Do you really want to format this disk? All data will be lost!");?>')" />
				</div>
				<?php if (count($disks)>0) {
					foreach ($disks as $key => $disk) {
						if ($do_format[$key]) {
							echo(sprintf("<div id='cmdoutput'>%s</div>", sprintf(gettext("Command output")." for disk %s :", $disk)));
							echo('<pre class="cmdoutput">');
								disks_format($disk,$type,$notinitmbr,$minspace,$_volumelabels[$key], $aft4k);
							echo('</pre><br/>');
						}
					}
				}
				?>
				<div id="remarks">
					<?php html_remark("Warning", gettext("Warning"), sprintf(gettext("UFS is the NATIVE file format for FreeBSD (the underlying OS of %s). Attempting to use other file formats such as FAT, FAT32, EXT2, EXT3, or NTFS can result in unpredictable results, file corruption, and loss of data!"), get_product_name()));?>
				</div>
			</td>
		</tr>
	</table>
	<?php include("formend.inc");?>
</form>
<?php include("fend.inc");?>
