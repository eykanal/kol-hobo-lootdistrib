<?php

if( !IN_PROG )
	die( 'Not on my watch, buster.' );

//
// This is the general class used to read and write CVS files.
//
class Files
{
	// Take a file (named $filename), read contents, return them in tab-delimited format
	function read( $filename )
	{
		$filt = array();

		$raw = file( $filename );
		foreach( $raw as $line )
		{
			$tmp = explode( "\t", $line );
			foreach( $tmp as $key=>$item ) $tmp[$key] = trim( $item );
			$filt[] = $tmp;
		}
		
		return $filt;
	}
	
	// Take a 2-dimensional array and write it to a file. Each entry in first dimension is
	// an entry (i.e., a single line), each in second dimension is an element in that line.
	function write( $filename, $content )
	{
			$file_contents = '';
			
			// process each line...
			foreach( $content as $key=>$line )
			{
				// remove extra spaces, newlines
				foreach( $line as $key2=>$entry ) $line[$key2] = trim( $entry );

				// combine all entries with a tab between them
				$file_contents .= implode( $line, "\t" );

				// add newline at end of line
				$file_contents .= "\n";
			}

			// write it out
			$handle = fopen( $filename, 'w' );
			fwrite( $handle, $file_contents );
			fclose( $handle );
	}
}

?>