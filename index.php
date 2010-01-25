<?php

require( 'common.php' );

// define clan name
$clan_name = 'ndy';

// check whether clan files exist yet
if( file_exists( CLAN_FILES.'/'.$clan_name ) )
{
	// add clan name to session, enabling access to later pages
	$_SESSION['clan_name'] = $clan_name;

	// instantiate clan class
	$_SESSION['clan'] = new Clan( CLAN_FILES.'/'.$_SESSION['clan_name'].'/'.$_SESSION['clan_name'].'_actions.txt', CLAN_FILES.'/'.$_SESSION['clan_name'].'/'.$_SESSION['clan_name'].'_divers.txt' );

	// set up some universal smarty variables
	$smarty->assign( 'divers', $_SESSION['clan']->divers );
	$smarty->assign( 'actions', $_SESSION['clan']->actions );
	$smarty->assign( 'form_action_self', $_SERVER['PHP_SELF'] );

// if no files, check in old spot
} elseif( file_exists( '../KoL/'.CLAN_FILES.'/'.$_SESSION['clan_name'] ) )
{
	updateClanFiles( $clan_name );
	header( 'Location: index.php' );

// if no files there, recommend to talk to AlphaCow to get set up
} else
{	
	
	//## SET UP ##
	
	echo "talk to AlphaCow";
}


switch( $_POST['submit'] )
{
	//
	// SET ACTION VALUES
	//
	case 'Save changes':
		break;
	
	//
	// FIRST VISIT:
	//
	default:

		$smarty->display( 'form.tpl' );
		break;
}

?>