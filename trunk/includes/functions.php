<?php

if( !defined( 'IN_PROG' ) )
	die( 'Not on my watch, buster.' );

// search through an array of objects
function obj_array_search( $needle, $haystack, $obj_property, $case_sensitive = true )
{
	if( $case_sensitive )
	{
		foreach( $haystack as $key=>$item )
		{
			if( $item->$obj_property == $needle ) return $key;
		}
	} else
	{
		$ci_needle = strtolower( $needle );
		foreach( $haystack as $key=>$item )
		{
			if( strtolower( $item->$obj_property ) == $ci_needle ) return $key;
		}
	}
	
	// if $needle not found, return false
	return false;
}

// print array, with nice typesetting
function debug_array( $var_name )
{
	global ${$var_name};
	echo $var_name.":\n";
	print_r( ${$var_name} );
	echo "\n";
}

// Input $array, see if $item is in the array, move it to the front of the array, return the
// array
function move_array_item_to_front( $array, $item )
{
	$key = -1;
	
	$key = array_search( $item, $array );
	
	if( is_numeric( $key ) && $key >= 0 )
	{
		$holder = $array[$key];
		$array[$key] = false;
		$array = array_filter( $array );
		array_unshift( $array, $holder );
	}
	
	return $array;
}

// function to remove apostrophes and spaces from names, to format for images
function img_name_format($name)
{
	$name = preg_replace( "/'/", "", $name );
	$name = preg_replace( "/\s/", "_", $name );
	$name = strtolower( $name );
	return $name;
}

// a case-insensitive 
function in_array_caseInsensitive( $needle, $haystack )
{
	$needle = trim( $needle );
	for( $n = 0; $n < count( $haystack ); $n++ )
	{
		if( strlen ( strpos( strtolower( trim( $haystack[$n] ) ), strtolower( $needle ) ) ) > 0 ) return true;			
	}
}

// sort function for arrays of objects
function sort_divers_by_turns( $a, $b )
{
	if( ( $a->turns + $a->oldTurns ) == ( $b->turns + $b->oldTurns ) ) return 0;
	return ( $a->turns + $a->oldTurns ) > ( $b->turns + $b->oldTurns );
}

// parse loot list
function process_loot( $loot_raw )
{
	$loot_expanded = preg_split( "/\n/", $loot_raw );
	foreach( $loot_expanded as $line )
	{
		preg_match( '/((Frosty|Hodgman|Oscus|Chester|Zombo|Ol|Wand).*?)(\s*Ac|\sto)/', $line, $loot_parsed );
	
		count( $loot_parsed ) > 0 ? $loot[] = trim( stripslashes( $loot_parsed[1] ) ) : '';
	}
	
	return $loot;
}

// Suggest stuff
/*
We want to suggest loot for divers based on (1) how many turns they spent diving, and (2) what is
available. This is accomplished by going down a list of divers, sorted by time spent in dungeon, and
checking whether something they wanted dropped. If so, give it to them and move on. If we get to the
end of the list and there's still loot available, loop throught the diver list again until all loot
is handed out. If no one wants a particular piece of loot, we suggest that it be pulverized and the
wad can be sold in a clan mall store for cash.
*/

function suggest_loot( $divers, $loot )
{
	// sort divers by turns
	usort( $divers, "sort_divers_by_turns" );
	$divers = array_reverse( $divers );

	// initialize some useful vars for the program
	$pieces_of_loot = count( $loot );
	$first_run = true;		// used to determine whether first run through diver list		
	$all_loot = $loot;
	if( !isset( $min_adv_requirement ) ) $min_adv_requirement = 0;
	
	// loop through this until either all loot is gone or until the loot list looks the same (i.e.,
	// no one wants the remaining loot).
	do
	{
		// count the current amount of loot for use in the do loop
		$loot_count_now = count( $loot );

		// For each diver, starting with the guy with the most turns...
		foreach( $divers as $key=>$diver )
		{
			// ...if this diver participated in the current run...
			if( $diver->inDungeon )
			{
				// ...if he meets the minimum turncount for the clan dungeon requirement...
				// (currently unimplemented)
				$turncount_check = ( $diver->turns + $diver->oldTurns ) > $min_adv_requirement;
				// ...if he has a wishlist...
				$wishlist_check = is_array( $diver->wishList );
				// ...if he wants loot at all...
				$nolootthanks_check = is_string( $diver->wishList );			
				// ...if he is has gotten through the sewer...
				$through_sewer_check = ( $diver->throughSewer == true );
	
				if( $turncount_check && $wishlist_check && $through_sewer_check )
				{
					$what_i_want_dropped_array = array();
					
					foreach( $diver->wishList as $item_on_wish_list )
					{
						// ...if something on their wish list matches what dropped...
						// ...or is part of an outfit the guy wants, and he can zap it...
						$what_i_want_dropped = in_array( $item_on_wish_list, $loot );
						// ...if the guy hasn't gotten anything else already...
						$havent_been_awarded_yet = count( $diver->lootResults ) == 0;
						
						$what_i_want_dropped_array[] = in_array( $item_on_wish_list, $loot );
	
						if( $what_i_want_dropped && $havent_been_awarded_yet )
						{
							// This is the spot where I could implement a distrib mechanism to avoid
							// giving away stuff someone else wants later. There are probably a few
							// items this guy wants, and almost for sure someone else wants one of them.
							// I should make a list of all the things this guy wants, then go through
							// and see which ones are wanted by others. Give him the one that he wants
							// that is least popular by other folks.
	
							// suggest the item for the diver
							$diver->lootResults[] = $item_on_wish_list;
							$diver->gotSomething = true;
	
							// remove the item from the loot array
							$loot_key = array_search( $item_on_wish_list, $loot );
							unset( $loot[$loot_key] );
							sort( $loot );
						}
					}
					// give some reasons for why they didnt get anything
	
					// if no wanted items dropped, mention that in the rejects array
					if( !in_array( 1, $what_i_want_dropped_array ) && $first_run == true )
					{
						// $all_loot contains all loot that dropped... if its in there but
						// not in $loot, it was given to a higher-ranking person.
						if( count( $loot ) == 0 )
						{
							$diver->lootResults[] = 'All items distributed to higher-ranking dungeoneers.';
						} elseif( in_array( $item_on_wish_list, $all_loot ) )
						{
							$diver->lootResults[] = 'All wanted items were given to higher-ranking dungeoneers.';
						} else
						{
							$diver->lootResults[] = 'No wanted items dropped.';
						}
					}
	
				// The rejection reason assignment only occurs on first run, because if 
				// didn't get then, won't want anything on second passes, either
				} elseif( $first_run == true )
				{
					// rejected because didn't get through sewer?
					if( !$through_sewer_check )
						$diver->lootResults[] = 'Never made it through sewer; unable to receive loot.';
					// rejected because of turncount?
					if( $through_sewer_check && !$turncount_check )
						$diver->lootResults[] = 'Too few turns in dungeon.';
					// rejected because of no wishlist?
					if( !$wishlist_check && !$nolootthanks_check ) 
						$diver->lootResults[] = '<span class=\'error\'>No wish list provided.</span>';
					// rejected because doesn't want loot?
					if( $nolootthanks_check )
						// note: in this case, we only report this, and nothing else.
						$diver->lootResults = array( 'Doesn\'t want to receive loot.' );
				}
				
				$divers[$key] = $diver;
			}
		}
		
		// once we're here, we're done with the first run:
		$first_run = false;
	
	} while ( !( ( count( $loot ) == $loot_count_now ) || ( count( $loot ) == 0 ) ) );

	// return the $diver array and the $loot array; the loot array will only contain
	// anything if there were undistributed items.
	return array( $divers,  $loot );
}

// transfer files over to new parser, change to new format
function updateClanFiles( $clanName )
{
	if( !is_dir( CLAN_FILES.'/'.$clanName ) )
		$mkdir = mkdir( CLAN_FILES.'/'.$clanName );

	if( !$mkdir )
		trigger_error( 'Error transferring clan folder from old site', E_USER_ERROR );

	$file = new Files;
	
	$oldActions = $file->read( '../KoL/'.CLAN_FILES.'/'.$clanName.'/'.$clanName.'_actions.txt' );
	$oldDivers =  $file->read( '../KoL/'.CLAN_FILES.'/'.$clanName.'/'.$clanName.'_divers.txt' );

	$newActions = $file->read( CLAN_FILES.'/actions_template.txt' );
	
	// divers file is the same, just copy over
	$file->write( CLAN_FILES.'/'.$clanName.'/'.$clanName.'_divers.txt', $oldDivers );
	
	// read through old stuff, match up points to new one
	foreach( $newActions as $newKey=>$newAction )
	{
		foreach( $oldActions as $oldKey=>$oldAction )
		{
			if( $newAction[2] === $oldAction[0] )
			{
				$newActions[$newKey][4] = $oldAction[1];
			}
		}
	}

	$file->write( CLAN_FILES.'/'.$clanName.'/'.$clanName.'_actions.txt', $newActions );
}

?>