<?php

if( !defined( 'IN_PROG' ) )
	die( 'Not on my watch, buster.' );

class Diver
{
	public $name;			// diver name
	public $turns;			// number of turns in current dungeon
	public $oldTurns;		// number of turns saved from previous dungeons
	public $inDungeon;		// whether this diver participated in this clan dungeon
	public $actions;		// actions done in current dungeon (array( <location>, <action>, 
							//	 <turns>, <weighted turns> ) )
	public $throughSewer;	// whether through sewer this run
	public $lastActiveDate;	// date last active in dungeon
	public $wishList;		// wish list, in form of array(<array of want>, <array of have>)
	public $lootResults;	// EITHER: array of loot received by this diver this run (starts out
							//   empty) OR array of strings detailing reason(s) why didn't receive loot
	public $gotSomething;	// whether received loot or not (used in smarty template)
	
	function __construct()
	{
		$this->name 		= '';
		$this->turns 		= 0;
		$this->oldTurns 	= 0;
		$this->inDungeon 	= false;
		$this->actions 		= array();
		$this->throughSewer = false;
		$this->lastActiveDate = '00/00/0000';
		$this->wishList 	= array(
								array(),
								array(),
							);
		$this->lootResults 	= array();
		$this->gotSomething = false;
	}
}

?>