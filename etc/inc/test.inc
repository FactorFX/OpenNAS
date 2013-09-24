#!/usr/local/bin/php-cgi -f
<?php

require_once("config.inc");
require_once("functions.inc");
require_once("install.inc");
require_once("util.inc");
require_once("tui.inc");

require_once("xmlparse.inc");

test();

function test(){
	global $g;
	$raw_config = parse_xml_config_raw("{$g['conf_path']}/config.xml", "");
}

?>
