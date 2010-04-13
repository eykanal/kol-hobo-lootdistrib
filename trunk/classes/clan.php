<?php

if( !defined( 'IN_PROG' ) )
	die( 'Not on my watch, buster.' );

// This class contains some basic clan information, as well as all the people in the clan.
class Clan extends Files
{
	public $actions;		// array (from textfile) containing rows with the following columns:
							//	0) unique numeric identifier for each entry
							//	1) action name as written on erikdev frontpage (not used, use singular instead)
							//	2) action name, singular
							//	3) action name, plural
							//	4) action value
							//	5) location in dungeon (sewer, BBB, etc)
							//	6) beyond sewer action (1 = yes, 0 = no)
							//	7) maximum number of points (only really applicable for Richard)
	public $divers;			// array (from textfile) with the following columns:
							//	0) name
							//	1) total saved turncount
							//	2) last active date
	public $distribResults;	// array (either from processDistrib.php or from textfile)
							//  0) name
							//
	
	private $actionFile;	// name of textfile storing actions
	private $diverFile;		// string containing name of diver file

	//
	// read diverFile, actionFile
	//
	function __construct( $clan_name )
	{
		// load actionFile
		$this->actionFile = CLAN_FILES.'/'.$clan_name.'/'.$clan_name.'_actions.txt';
		$this->actions = $this->LoadActions( $this->actionFile );
	
		$this->diverFile = CLAN_FILES.'/'.$clan_name.'/'.$clan_name.'_divers.txt';
		$this->LoadDivers( $this->diverFile );
	}
	
	//
	// Load the actions/items
	//
	function LoadActions( $actionFile )
	{
		return $this->read( $actionFile );
	}
	
	//
	// Load divers to array of objects
	//
	function LoadDivers( $diverFile )
	{
		$this->divers = array();
		$name = array();
		
		// create new diver object for each diver
		$temp = $this->read( $diverFile );

		foreach( $temp as $key=>$line )
		{
			$diver = new Diver;
			$diver->name = $line[0];
			$diver->oldTurns = $line[1];
			$diver->lastActiveDate = ( isset( $line[2] ) ? $line[2] : 'N/A' );
			
			$this->divers[] = $diver;
			
			// for purposes of sorting the diver array alphabetically, we make a name array
			$name[] = $line[0];
			unset( $diver );
		}
		
		// sort the names alphabetically
		natcasesort( $name );
		$temp = array();
		foreach( $name as $n )
		{
			foreach( $this->divers as $diver )
			{
				if( $diver->name == $n )
				{
					$temp[] = $diver;
					break;
				}
			}
		}
		$this->divers = $temp;
	}
	
	//
	// Input array (in a "[<unique action ID>] => <new value>" format) and change the
	// change the "action values" stored in the text file to the new values. Also input
	// richards ("[<unique action ID>] = array(<value>, <max actions>)"), which contains 
	// possible maximum values for each richard action.
	//
	function SaveActions( $newActions, $richards )
	{
		// validate input
		foreach( $newActions as $key=>$action )
			if( !is_numeric( $key ) || !is_numeric( $action ) ) return false;
		
		foreach( $richards as $key=>$action )
			if( !is_numeric( $key ) || !is_numeric( $action ) ) return false;		
		
		// make the changes
		$changed_actions = array_keys( $newActions );
		$richards_actions = array_keys( $richards );
		foreach( $this->actions as $key=>$action )
		{
			// if the current action was changed...
			if( in_array( $action[ACTION_ID], $changed_actions ) )
			{
				// update the action value.
				$this->actions[$key][ACTION_VALUE] = $newActions[$action[ACTION_ID]];
			}

			// if the current action is a richards...
			if( in_array( $action[ACTION_ID], $richards_actions ) )
			{
				// update it either way, just since it's easier.
				$this->actions[$key][ACTION_VALUE] = $richards[$action[ACTION_ID]][0];
				$this->actions[$key][ACTION_MAX] = $richards[$action[ACTION_ID]][1];
			}
		}
		
		// write the changes out
		$this->write( $this->actionFile, $this->actions );
	}
	
	//
	// save diver values to textfile
	//
	function SaveDivers()
	{
		$tmp = array();

		foreach( $this->divers as $diver )
		{
			$tmp[] = array(
						$diver->name,
						( $diver->oldTurns + $diver->turns ),
						$diver->lastActiveDate,
					);
		}

		$this->write( $this->diverFile, $tmp );
	}

	//
	// Read the dungeon log and assign points to divers. Inputs are $log_raw, the unprocessed
	// log text, and $divers, an array of diver objects (will come from $clan->divers).
	//
	function ProcessLog( $log_raw )
	{
		$log_expanded = preg_split( "/\n/", $log_raw );
		
		// Check if a line contains a dungeon action. If so, (1) split it into parts,
		// (2) determine what the value of that action is, and (3) add it to the user's
		// total turncount.
		foreach( $log_expanded as $line )
		{
			// remove slashed added by global_addslashes (or whatever)
			$line = stripslashes( $line );

			// see if the line is an action line (as opposed to newline or section title)
			preg_match( "/\s*(.*?)\s\(#\d{1,8}\)\s(.*?)\s\((\d{1,4})\sturn[s]?\)/", $line, $parsed );

			if( count( $parsed ) == 4 )
			{
				$diver =  $parsed[1];
				$action = preg_replace('/\sx\s\d{1,3}/', '', $parsed[2]);
				$turns =  $parsed[3];

				$divers_key = obj_array_search( $diver, $this->divers, 'name' );

				// if diver doesn't have stored turns...
				if( $divers_key === false )
				{
					$tempDiver = new Diver;
					$tempDiver->name = $diver;
					$this->divers[] = $tempDiver;
					unset( $tempDiver );

					$divers_key = obj_array_search( $diver, $this->divers, 'name' );
				}
				
				// set flag indicating that this diver participated in the run
				$this->divers[$divers_key]->inDungeon = true;

				// see what this action is worth... first reformat the action so it's generic
				$tmpAction = preg_replace( '/\d+/', '1', $action );
				$tmpAction = preg_replace( '/rescued\s\w*[\s\w*]*\sfrom/', 'rescued clanmate from', $tmpAction );

				// look in the actions array to find the key that corresponds to the action
				$actions_key = null;
				foreach( $this->actions as $key=>$item )
				{
					// if action matches singular or plural...
					if( ( $item[2] == $tmpAction ) || ( $item[3] == $tmpAction ) ) $actions_key = $key;
				}
				if( $actions_key === null ) $actions_key = 999;

				// add action to diver's list of actions (used later to create the 
				// "specifics" table). The little complexity on the last line says, "check
				// whether a turn maximum is defined; if yes, set turns with that limit, if
				// not, set turns as usual".
				$this->divers[$divers_key]->actions[] = array(
													$this->actions[$actions_key][ACTION_LOC],
													$action,
													$turns,
													( $this->actions[$actions_key][ACTION_MAX] > 0 ? min( $turns * $this->actions[$actions_key][ACTION_VALUE], $this->actions[$actions_key][ACTION_MAX] ) : $turns * $this->actions[$actions_key][ACTION_VALUE] ),
												);
				// add turns to total count... scale the total turns by the correct number
				// of action points
				$this->divers[$divers_key]->turns = $this->divers[$divers_key]->turns + ( $turns * $this->actions[$actions_key][ACTION_VALUE] );
				// set diver's last active date as "today"
				$this->divers[$divers_key]->lastActiveDate = time();

				// check whether this action indicates that this diver has gone through the
				// sewer... if so, flag him as having done so and therefore able to recieve
				// loot
				if( $this->actions[$actions_key][6] == 1 ) $this->divers[$divers_key]->throughSewer = true;
			}
		}
	}
	
	function ProcessWishList( $data )
	{
		// make sure each player's wish list is as long as it needs to be... compare to
		// first line which contains with all loot names
		$correct_len = count( $data[0] );
		foreach( $data as $key=>$line )
		{
			$data[$key] = array_pad( $line, $correct_len, '' );
		}
		$loot_names = $data[0];
		// the first cell says "player name"... remove that cell
		// the second cell says "dont want nuthin"... remove that cell
		array_shift( $loot_names );
		array_shift( $loot_names );
		// remove loot_names line from the $data array
		array_shift( $data );
		
		// get outfit ids, remove first two cells, pop off outfit line from $data array
		$outfit_ids = $data[0];
		array_shift( $outfit_ids );
		array_shift( $outfit_ids );
		array_shift( $data );

		// make arrays with outfit names... trim, unique gets names, filter removes blank 
		// entry
		
		$outfit_names = array_filter( array_unique( $outfit_ids ) );
		// initialize an array for each outfit
		foreach( $outfit_names as $outfit_name )
		{
			${$outfit_name.'_outfit'} = array();
		}

		// fill the outfit arrays made above
		foreach( $loot_names as $key=>$loot_name )
		{
			if( in_array( $outfit_ids[$key], $outfit_names ) )
			{
				array_push( ${$outfit_ids[$key].'_outfit'}, $loot_name );
			}
		}		

		// read through the different people's loot lists
		foreach( $data as $line )
		{
			// diver name is first entry
			preg_match( "/(.*?)(\s?\(#\d{1,8}\))?$/", trim($line[0]), $parsed );
			$diver_name = $parsed[1];
			$no_loot = $line[1];

			// if this diver didn't participate in this run, save speed and skip the whole line
			if( ( $divers_key = obj_array_search( $diver_name, $this->divers, 'name', false ) ) && strlen( $no_loot ) == 0 )
			{
				// removes name and empty "don't want nuthin'" boxes
				array_shift( $line );
				array_shift( $line );
				
				$want_loot = array();
				$want_loot_ranked = array();
				$have_loot = array();

				// go through the line; if 'H', has that item, if 'W', wants that item
				foreach( $line as $key=>$entry )
				{
					// set up a single-entry array with the loot name... use an array
					// here so that we can later use "array_merge" to add the loot to
					// the want_loot or want_loot_ranked arrays no matter whether its
					// a single loot piece or a whole outfit.
					$current_loot_piece = $loot_names[$key];
					
					if( trim( strtolower( $entry ) ) == 'h' )
					{
						$have_loot[] = $current_loot_piece;
					
					// if there's a 'W' in the string, its a want
					} elseif( strstr( trim( strtolower( $entry ) ), 'w' ) )
					{
						// if the item is part of an outfit, add the whole thing to the list
						// first check if $item_on_wish_list is part of an outfit
						$loot_key = array_search( $loot_names[$key], $loot_names );
						$part_of_outfit = $outfit_ids[$loot_key];
						// if it is, change the "curent_loot_piece" to being an array 
						// instead of a string
						if( strlen( $part_of_outfit ) > 0 )	$current_loot_piece = ${$part_of_outfit.'_outfit'};

						// check for ranking
						preg_match( '/w?(\d*)w?/', trim( strtolower( $entry ) ), $entry_parsed );

						if( strlen( $entry_parsed[1] ) > 0 )
						{
							$want_loot_ranked[$entry_parsed[1]] = @array_merge( (array)$want_loot_ranked[$entry_parsed[1]], (array)$current_loot_piece );

						// if no ranking, just stick it on the end of the array
						} else
						{
							$want_loot = array_merge( (array)$want_loot, (array)$current_loot_piece );
						}
					}
				}

				// the $want_loot_ranked array is keyed according to preference, but we 
				// need to actually sort it by the keys...
				ksort( $want_loot_ranked );
	
				// just for fun, lets shuffle the unranked loot
				shuffle( $want_loot );
				
				// put cool hodgman stuff at front of want list
				$hodgman_stuff = array(
					"Hodgman's imaginary hamster",
					"Hodgman's disgusting technicolor overcoat",
					"Hodgman's whackin' stick",
					"Hodgman's almanac",
					"Hodgman's cane",
					"Hodgman's garbage sticker",
					"Hodgman's harmonica",
					"Hodgman's lucky sock",
					"Hodgman's metal detector",
					"Hodgman's varcolac paw",
					"Hodgman's porkpie hat",
					"Hodgman's bow tie",
					"Hodgman's lobsterskin pants",
				);
				
				$hodgman_stuff_tier2 = array_slice( $hodgman_stuff, 3, 7 );
				$hodgman_stuff_tier3 = array_slice( $hodgman_stuff, 10 );

				shuffle( $hodgman_stuff_tier2 );
				shuffle( $hodgman_stuff_tier3 );

				// put outfit at front
				foreach( $hodgman_stuff_tier3 as $item )
				{
					if( in_array( $item, $want_loot ) )
					{
						$want_loot = move_array_item_to_front( $want_loot, $item );
					}
				}

				// put neat items at front
				foreach( $hodgman_stuff_tier2 as $item )
				{
					if( $key = array_search( $item, $want_loot ) )
					{
						$want_loot = move_array_item_to_front( $want_loot, $item );
					}
				}

				// put really neat hodgman stuff at the front
				$want_loot = move_array_item_to_front( $want_loot, 'Hodgman\'s whackin\' stick' );
				$want_loot = move_array_item_to_front( $want_loot, 'Hodgman\'s disgusting technicolor overcoat' );
				$want_loot = move_array_item_to_front( $want_loot, 'Hodgman\'s imaginary hamster' );

				$want_loot_ranked_final = array();
				// turn the want_loot_ranked arrays into one big array
				foreach( $want_loot_ranked as $want_rank )
				{
					shuffle($want_rank);
					$want_loot_ranked_final = array_merge( $want_loot_ranked_final, $want_rank );
				}

				$want_loot = array_merge( $want_loot_ranked_final, $want_loot );

				// all the "array_merges" with the outfit stuff can make lots of
				// duplicates. Lets get rid of those.
				$want_loot = array_unique( $want_loot );

				// for the time being, we just discard the 'have_loot' list... don't need 
				// it
				$this->divers[$divers_key]->wishList = $want_loot;

			} elseif( ( $divers_key = obj_array_search( $diver_name, $this->divers, 'name', false ) ) && strlen( $no_loot ) > 0 )
			{
				// by setting as string, we tell the parser that this person DOES have a
				// wish list, but just doesn't want loot.
				$this->divers[$divers_key]->wishList = 'Doesn\'t want loot.';
			}
		}
	}
}

?>