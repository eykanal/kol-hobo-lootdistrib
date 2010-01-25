<?php

require( 'common.php' );

$files = new Files;

//$myFile = $files->read( 'clan_files/test/test_divers.txt' );

$clan_name = 'test';
$clan_file_prefix = CLAN_FILES.'/'.$clan_name.'/'.$clan_name;
$clan = new Clan( $clan_file_prefix.'_actions.txt', $clan_file_prefix.'_divers.txt' );

$output = '';

$output .= "\n\n<hr>\n\n";

$output .= obj_array_search( 'Roert', $clan->divers, 'name' );

$output .= "\n\n<hr>\n\n";

$output .= "<table>";
foreach( $clan->actions as $i )
{
	$output .= "<tr>";
	foreach( $i as $j )
	{
		$output .= "<td>".$j."</td>";
	}
	$output .= "</tr>";
}
$output .= "</table>";

?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<title>Testing</title>

<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/jquery-ui.js" type="text/javascript"></script>
<script src="javascript/custom.js" type="text/javascript"></script>
<script src="javascript/tabber.js" type="text/javascript"></script>

<link rel="stylesheet" href="styles/tabber.css" type="text/css">
<link rel="stylesheet" href="styles/styles.css" type="text/css">

<script type='text/javascript'>
$(function() {
	// put a copy of the drop-down in each cell
	$('.selector').clone().insertAfter('.bob');
	$('.selector:last').remove();
	$('.selector').hide();
	
	// insert " (suggested)" next to original suggestions within the clones
	$('.selector').each( function () {
		var origDiver = $(this).siblings('.bob').text();
		var ddDiver = $(this).find('option[value='+origDiver+']');
		ddDiver.append(" (suggested)");
		console.log('ddDiver', ddDiver);
	});

	// replace value with drop-down
	$('.bob').click( function () {
		var dd = $(this).siblings('.selector');

		$(this).hide();

		var currVal = jQuery.trim( $(this).text() );
		
		dd.children('select').val( currVal );
		dd.show();
		dd.children('select').focus();
	});
	
	// update hidden value and replace dropdown with text
	$('.selector > select').blur( function() {
		var selector = 	$(this).parent('.selector');
		var bob	=		selector.siblings('.bob');
		var selValue = 	$(this).val();
		
		selector.siblings('input').attr('type', 'hidden').val(selValue);
		bob.text( selValue );
		
		selector.hide();
		bob.show();
	});
});
</script>

</head>
<body>
<form>
<div>
	<div class='bob'>1 <input name='bob1' type='hidden' value='1'></div>
</div>
<div>
	<div class='bob'>2 <input name='bob2' type='hidden' value='2'></div>
</div>
<div class='selector'>
	<select name='choice'>
		<option value='1'>1</option>
		<option value='2'>2</option>
	</select>
</div>
</form>
</body>
</html>