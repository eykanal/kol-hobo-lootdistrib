<?php

require( 'common.php' );

// if no clan name is set, boot back to front page
if( !$_SESSION['clan_name'] )
	header( "Location: index.php" );

// process loot submission
if( $_POST['submit'] == 'Show me the loot!' )
{
	$log_raw =  trim( htmlspecialchars( strip_tags( $_POST['log_raw'] ) ) );
	$loot_raw = trim( htmlspecialchars( strip_tags( $_POST['loot_raw'] ) ) );
	if( isset( $_FILES['wish_list'] ) )
	{
		$file = file($_FILES['wish_list']['tmp_name'], FILE_IGNORE_NEW_LINES );
		foreach( $file as $key=>$line )
		{
			$file[$key] = trim( $line );
			$wish_list_raw[] 	= explode( ',', $line );
		}
	}
	
	// verify all went well
	$proceed = false;
	$proceed = strlen( $_POST['loot_raw'] ) > 0 && strlen( $_POST['log_raw'] ) > 0 && count( $wish_list_raw ) > 0;
	
	// if anything failed...
	if( !$proceed )
	{
		$_SESSION['error'] = true;
		header( "location: index.php" );
		
	// if all input valides properly...
	} else
	{
		// preprocess input
		$log_raw =  trim( htmlspecialchars( strip_tags( $_POST['log_raw'] ) ) );
		$loot_raw = trim( htmlspecialchars( strip_tags( $_POST['loot_raw'] ) ) );
		if( isset( $_FILES['wish_list'] ) )
		{
			$file = file($_FILES['wish_list']['tmp_name'], FILE_IGNORE_NEW_LINES );
			foreach( $file as $key=>$line )
			{
				$file[$key] = trim( $line );
				$wish_list_raw[] 	= explode( ',', $line );
			}
		}
		
		// load clan, parse log, wish list, & loot
		// rename session var for easy access; NOTE THAT $clan IS A REFERENCE TO $_SESSION['clan']
		$clan = $_SESSION['clan'];
		
		$clan->ProcessLog( $log_raw );
		$clan->ProcessWishList( $wish_list_raw );
		$loot = process_loot( $loot_raw );
		$results = suggest_loot( $clan->divers, $loot );

		$clan->divers = $results[0];
		$loot = $results[1];

		// format loot so it's loot-centric rather than diver-centric
		$loot_results = array();
		foreach( $clan->divers as $diver )
			if( $diver->gotSomething )
				foreach( $diver->lootResults as $piece_of_loot )
					$loot_results[] = array( 'loot_raw'	  => $piece_of_loot,
											 'loot_clean' => strtolower( str_replace( "'", "", str_replace( " ", "_", $piece_of_loot ) ) ),
											 'name'		  => $diver->name,
									  );

		$template_divers = array();
		foreach( $clan->divers as $diver )
			if( $diver->inDungeon )
				$template_divers[] = $diver;

		$smarty->assign( 'loot', $template_divers );
		$smarty->assign( 'loot_results', $loot_results );
		$smarty->display( 'distrib.tpl' );
	}
} else
{
	// if got here, not during a submit, send back to front page
	header( 'location: index.php' );
}

?>