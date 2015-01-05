<?php
/*
	services_nfs_share_edit.php

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

if (isset($_GET['uuid']))
	$uuid = $_GET['uuid'];
if (isset($_POST['uuid']))
	$uuid = $_POST['uuid'];

$pgtitle = array(gettext("Services"), gettext("NFS"), isset($uuid) ? gettext("Edit") : gettext("Add"));

if (!isset($config['nfsd']['share']) || !is_array($config['nfsd']['share']))
	$config['nfsd']['share'] = array();

array_sort_key($config['nfsd']['share'], "path");
$a_share = &$config['nfsd']['share'];

function ismounted_or_dataset($path)
{
	if (disks_ismounted_ex($path, "mp"))
		return true;

	mwexec2("/sbin/zfs list -H -o mountpoint", $rawdata);
	foreach ($rawdata as $line) {
		$mp = trim($line);
		if ($mp == "-")
			conitnue;
		if ($path == $mp)
			return true;
	}

	return false;
}

if (isset($uuid) && (FALSE !== ($cnid = array_search_ex($uuid, $a_share, "uuid")))) {
	$pconfig['uuid'] = $a_share[$cnid]['uuid'];
	$pconfig['path'] = $a_share[$cnid]['path'];
	$pconfig['mapall'] = $a_share[$cnid]['mapall'];
	foreach($a_share[$cnid]['network'] as $network){
		list($pconfig['network'][], $pconfig['mask'][]) = explode('/', $network);
	}
	$pconfig['comment'] = $a_share[$cnid]['comment'];
	$pconfig['alldirs'] = isset($a_share[$cnid]['options']['alldirs']);
	$pconfig['readonly'] = isset($a_share[$cnid]['options']['ro']);
	$pconfig['quiet'] = isset($a_share[$cnid]['options']['quiet']);
} else {
	$pconfig['uuid'] = uuid();
	$pconfig['path'] = "";
	$pconfig['mapall'] = "yes";
	$pconfig['network'][] = "";
	$pconfig['mask'][] = "24";
	$pconfig['comment'] = "";
	$pconfig['alldirs'] = false;
	$pconfig['readonly'] = false;
	$pconfig['quiet'] = false;
}
$nb_network = count($pconfig['network']);
if ($_POST) {
	unset($input_errors);
	$pconfig = $_POST;

	if (isset($_POST['Cancel']) && $_POST['Cancel']) {
		header("Location: services_nfs_share.php");
		exit;
	}

	// Input validation.
	$reqdfields = explode(" ", "path");
	$reqdfieldsn = array(gettext("Path"));
	do_input_validation($_POST, $reqdfields, $reqdfieldsn, $input_errors);

	foreach ($_POST['network'] as $id => $network) {
		$post_en = array('network' => $network, 'mask' => $_POST['mask'][$id]);
		$reqdfields = explode(" ", "network mask");
		$reqdfieldsn = array(gettext("Authorised network"), gettext("Network mask"));
		do_input_validation($post_en, $reqdfields, $reqdfieldsn, $input_errors);
	}

	// remove last slash and check alldirs option
	$path = $_POST['path'];
	if (strlen($path) > 1 && $path[strlen($path)-1] == "/") {
		$path = substr($path, 0, strlen($path)-1);
	}
	if ($path == "/") {
		// allow alldirs
	} else if (isset($_POST['quiet'])) {
		// might be delayed mount
	} else if (isset($_POST['alldirs']) && !ismounted_or_dataset($path)) {
	   $input_errors[] = sprintf(gettext("All dirs requires mounted path, but Path %s is not mounted."), $path);
	}

	if (empty($input_errors)) {
		$share = array();
		$share['uuid'] = $_POST['uuid'];
		$share['path'] = $path;
		$share['mapall'] = $_POST['mapall'];
		foreach ($_POST['network'] as $id => $network) {
			$share['network'][$id] = gen_subnet($network, $_POST['mask'][$id]) . "/" . $_POST['mask'][$id];
		}
		$share['comment'] = $_POST['comment'];
		$share['options']['alldirs'] = isset($_POST['alldirs']) ? true : false;
		$share['options']['ro'] = isset($_POST['readonly']) ? true : false;
		$share['options']['quiet'] = isset($_POST['quiet']) ? true : false;

		if (isset($uuid) && (FALSE !== $cnid)) {
			$a_share[$cnid] = $share;
			$mode = UPDATENOTIFY_MODE_MODIFIED;
		} else {
			$a_share[] = $share;
			$mode = UPDATENOTIFY_MODE_NEW;
		}

		updatenotify_set("nfsshare", $mode, $share['uuid']);
		write_config();

		header("Location: services_nfs_share.php");
		exit;
	}
}
?>
<?php include("fbegin.inc");?>
<script type="text/javascript">
<!--
$(function() {
	$("a#add_network").click(function(){
		$("#list_network_0").clone().insertAfter(".list_network:last").each(function(){
			var network = $(this).find("input#network");
			var mask = $(this).find("select#mask");
			var remove = $(this).find("a#remove_network");
			network.val('');
			mask.val('24');
			remove.show().on('click', aClickFunction);
		});
	});
	$("a#remove_network").click(aClickFunction);

	function aClickFunction(){
		$(this).closest("div.list_network").remove();
	};
});
//-->
</script>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
		<td class="tabnavtbl">
			<ul id="tabnav">
				<li class="tabinact"><a href="services_nfs.php"><span><?=gettext("Settings");?></span></a></li>
				<li class="tabact"><a href="services_nfs_share.php" title="<?=gettext("Reload page");?>"><span><?=gettext("Shares");?></span></a></li>
			</ul>
		</td>
	</tr>
	<tr>
		<td class="tabcont">
			<form action="services_nfs_share_edit.php" method="post" name="iform" id="iform">
				<?php if ($input_errors) print_input_errors($input_errors);?>
			  <table width="100%" border="0" cellpadding="6" cellspacing="0">
			    <tr>
  				  <td width="22%" valign="top" class="vncellreq"><?=gettext("Path");?></td>
  				  <td width="78%" class="vtable">
  				  	<input name="path" type="text" class="formfld" id="path" size="60" value="<?=htmlspecialchars($pconfig['path']);?>" />
  				  	<input name="browse" type="button" class="formbtn" id="Browse" onclick='ifield = form.path; filechooser = window.open("filechooser.php?p="+encodeURIComponent(ifield.value)+"&amp;sd=<?=$g['media_path'];?>", "filechooser", "scrollbars=yes,toolbar=no,menubar=no,statusbar=no,width=550,height=300"); filechooser.ifield = ifield; window.ifield = ifield;' value="..." /><br />
  				  	<span class="vexpl"><?=gettext("Path to be shared.");?> <?=gettext("Please note that blanks in path names are not allowed.");?></span>
  				  </td>
  				</tr>
			    <tr>
			      <td width="22%" valign="top" class="vncellreq"><?=gettext("Map all users to root"); ?></td>
			      <td width="78%" class="vtable">
			        <select name="mapall" class="formfld" id="mapall">
			        <?php $types = array(gettext("Yes"),gettext("No"));?>
			        <?php $vals = explode(" ", "yes no");?>
			        <?php $j = 0; for ($j = 0; $j < count($vals); $j++): ?>
			          <option value="<?=$vals[$j];?>" <?php if ($vals[$j] == $pconfig['mapall']) echo "selected=\"selected\"";?>>
			          <?=htmlspecialchars($types[$j]);?>
			          </option>
			        <?php endfor; ?>
			        </select><br />
			        <span class="vexpl"><?=gettext("All users will have the root privilege.");?></span>
			      </td>
			    </tr>
			    <tr>
			      <td width="22%" valign="top" class="vncellreq"><?=gettext("Authorised network");?></td>
			      <td width="78%" class="vtable">
					<?php foreach($pconfig['network'] as $d => $network) : ?>
						<div class="list_network" id="list_network_<?php echo $d; ?>">
							<input name="network[]" type="text" class="formfld" id="network" size="20" value="<?=htmlspecialchars($pconfig['network'][$d]);?>" /> /
							<select name="mask[]" class="formfld" id="mask">
							  <?php for ($i = 32; $i >= 1; $i--):?>
							  <option value="<?=$i;?>" <?php if ($i == $pconfig['mask'][$d]) echo "selected=\"selected\"";?>><?=$i;?></option>
							  <?php endfor;?>
							</select>
							<a href="#" id="remove_network" <?php echo ($d == 0) ? 'style="display:none"': "" ?>>
								<img src="del.gif" title="<?=gettext("Add network");?>" border="0" alt="<?=gettext("Remove network");?>" />
							</a><br />
						</div>
			        <?php endforeach; ?>
			        <a href="#" id="add_network">
						<img src="plus.gif" title="<?=gettext("Add network");?>" border="0" alt="<?=gettext("Add network");?>" />
					</a><br />
			        <span class="vexpl"><?=gettext("Network that is authorised to access the NFS share.");?></span><br/>
			      </td>
			    </tr>
			    <tr>
			      <td width="22%" valign="top" class="vncell"><?=gettext("Comment");?></td>
			      <td width="78%" class="vtable">
			        <input name="comment" type="text" class="formfld" id="comment" size="30" value="<?=htmlspecialchars($pconfig['comment']);?>" />
			      </td>
			    </tr>
			    <tr>
			      <td width="22%" valign="top" class="vncell"><?=gettext("All dirs");?></td>
			      <td width="78%" class="vtable">
			      	<input name="alldirs" type="checkbox" id="alldirs" value="yes" <?php if (!empty($pconfig['alldirs'])) echo "checked=\"checked\"";?> />
			      	<span class="vexpl"><?=gettext("Export all the directories in the specified path.");?></span><br />
				<?=sprintf(gettext("To use subdirectories, you must mount each directories. (e.g. %s)"), "mount -t nfs host:/mnt/path/subdir /path/to/mount");?>
			      </td>
			    </tr>
			    <tr>
			      <td width="22%" valign="top" class="vncell"><?=gettext("Read only");?></td>
			      <td width="78%" class="vtable">
			      	<input name="readonly" type="checkbox" id="readonly" value="yes" <?php if (!empty($pconfig['readonly'])) echo "checked=\"checked\"";?> />
			        <span class="vexpl"><?=gettext("Specifies that the file system should be exported read-only.");?></span>
			      </td>
			    </tr>
			    <tr>
			      <td width="22%" valign="top" class="vncell"><?=gettext("Quiet");?></td>
			      <td width="78%" class="vtable">
			      	<input name="quiet" type="checkbox" id="quiet" value="yes" <?php if (!empty($pconfig['quiet'])) echo "checked=\"checked\"";?> />
			        <span class="vexpl"><?=gettext("Inhibit some of the syslog diagnostics for bad lines in /etc/exports.");?></span>
			      </td>
			    </tr>
			  </table>
				<div id="submit">
					<input name="Submit" type="submit" class="formbtn" value="<?=(isset($uuid) && (FALSE !== $cnid)) ? gettext("Save") : gettext("Add")?>" />
					<input name="Cancel" type="submit" class="formbtn" value="<?=gettext("Cancel");?>" />
					<input name="uuid" type="hidden" value="<?=$pconfig['uuid'];?>" />
				</div>
				<?php include("formend.inc");?>
			</form>
		</td>
	</tr>
</table>
<?php include("fend.inc");?>
