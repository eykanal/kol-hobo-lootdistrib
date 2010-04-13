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

// rename session var for easy access; NOTE THAT $clan IS A REFERENCE TO $_SESSION['clan']
$clan = $_SESSION['clan'];

foreach( $clan->divers as $key=>$diver )
{
	// reduce recipient's turncount to 0
	if( in_nested_array( $diver->name, $clean, 'diver' ) )
	{
		$clan->divers[$key]->turns 		= 0;
		$clan->divers[$key]->oldTurns 	= 0;

	// for everyone else, add turns dives to saved total 
	} else
	{
		$clan->divers[$key]->oldTurns 	= $diver->oldTurns + $diver->turns;
		$clan->divers[$key]->turns 		= 0;
	}
}

// save turncounts
$clan->SaveDivers();	

// make results accessible
$_SESSION['distrib_results'] = $clean;

// send back to front page to display results or whatever
header( 'Location: index.php' );

?>