<?php

require( 'common.php' );

// if no clan name is set, boot back to front page
if( !$_SESSION['clan_name'] )
	header( "Location: index.php" );

$clean = array();
foreach( $_POST as $dirtyLoot->$dirtyDiver )
{
	$clean['loot']  = stripslashes( trim( htmlentities( strip_tags( $dirtyLoot  ) ) ) );
	$clean['diver'] = stripslashes( trim( htmlentities( strip_tags( $dirtyDiver ) ) ) );

	## SET TURNCOUNT TO 0 ##
}

## ADD EVERYONE ELSE'S TURNCOUNT TO SAVED TOTAL ##

## SAVE FILE WITH DISTRIB RESULTS ##

?>