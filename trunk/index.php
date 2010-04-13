<?php

require( 'common.php' );

// define clan name
$clan_name = 'ndy';

// check whether clan files exist yet
if( file_exists( CLAN_FILES.'/'.$clan_name ) )
{
	// add clan name to session, enabling access to later pages
	$_SESSION['clan_name'] = $clan_name;

	// force reload of $clan when visiting index
	if( isset( $_SESSION['clan'] ) )
		unset( $_SESSION['clan'] );
	// instantiate clan class
	$_SESSION['clan'] = new Clan( $_SESSION['clan_name'] );
	// rename var for easy access; NOTE THAT $clan IS A REFERENCE TO $_SESSION['clan']
	$clan = $_SESSION['clan'];

	// set up some universal smarty variables
	$smarty->assign( 'divers', $clan->divers );
	$smarty->assign( 'actions', $clan->actions );
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

// default action; show the form, can set up more later
$display = 'form.tpl';
$smarty->display( $display );

?>