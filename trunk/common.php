<?php

define( 'CLAN_FILES', 'clan_files' );
define( 'CLAN_FILES_ARCHIVE', 'clan_files_archive' );
define( 'IN_PROG', true );

// columns in the <clan>_action.txt file
define( 'ACTION_ID', 0 );			//	0) unique numeric identifier for each entry
define( 'ACTION_DISPNAME', 1 );		//	1) action name as written on erikdev frontpage (not used, use singular instead)
define( 'ACTION_SINGULAR', 2 );		//	2) action name, singular
define( 'ACTION_PLURAL', 3 );		//	3) action name, plural
define( 'ACTION_VALUE', 4 );		//	4) action value
define( 'ACTION_LOC', 5 );			//	5) location in dungeon (sewer, BBB, etc)
define( 'ACTION_THROUGH_SEWER', 6 );//	6) beyond sewer action (1 = yes, 0 = no)
define( 'ACTION_MAX', 7 );			//	7) maximum number of points (only really applicable for Richard)


require( 'includes/functions.php' );
require( 'classes/files.php' );
require( 'classes/diver.php' );
require( 'classes/clan.php' );

session_start();

// Smarty stuff
require( 'includes/smarty/Smarty.class.php');
$smarty = new Smarty();

$smarty->template_dir = dirname( __FILE__ ).'/templates';
$smarty->compile_dir = dirname( __FILE__ ).'/includes/smarty/templates_c';
$smarty->cache_dir = dirname( __FILE__ ).'/includes/smarty/cache';
$smarty->config_dir = dirname( __FILE__ ).'/includes/smarty/config';
$smarty->caching = 0;

?>