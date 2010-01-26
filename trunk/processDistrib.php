<?php

require( 'common.php' );

// if no clan name is set, boot back to front page
if( !$_SESSION['clan_name'] )
	header( "Location: index.php" );

$clean = array();

foreach( $_POST as $dirtyLoot=>$dirtyDiver )
{
	$clean[] = array( 'loot'  => stripslashes( trim( htmlentities( strip_tags( $dirtyLoot  ) ) ) ),
					  'diver' => stripslashes( trim( htmlentities( strip_tags( $dirtyDiver ) ) ) ),
				);
}

$clan = new Clan( CLAN_FILES.'/'.$_SESSION['clan_name'].'/'.$_SESSION['clan_name'].'_actions.txt', CLAN_FILES.'/'.$_SESSION['clan_name'].'/'.$_SESSION['clan_name'].'_divers.txt' );

foreach( $clan->divers as $diver )
{
	## REDUCE RECIPIENTS TURNCOUNT TO 0 ##
	
	## ADD EVERYONE ELSE'S TURNCOUNT TO SAVED TOTAL ##
	
	## SAVE FILE WITH DISTRIB RESULTS ##
	
	## SAVE FILENAME OF DISTRIB RESULTS TO $_SESSION SO index.php CAN ACCESS AND DISPLAY IT ##
}

?>