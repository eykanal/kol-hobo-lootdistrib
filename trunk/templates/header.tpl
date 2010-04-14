<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<title>Testing</title>

{literal}<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.0/jquery-ui.min.js" type="text/javascript"></script>
<script src="javascript/custom.js" type="text/javascript"></script>
<script src="javascript/tabber.js" type="text/javascript"></script>

<link rel="stylesheet" href="styles/tabber.css" type="text/css">
<link rel="stylesheet" href="styles/styles.css" type="text/css">{/literal}

</head>
<body>
<div id='header_image'><a href='index.php'><img src='logo.gif' alt='Home page'></a></div>

{if isset($error)}<div class='ui-state-error ui-state-error-text'>{$error}</div>{/if}
{if isset($info)}<div class='ui-icon-info'>{$info}</div>{/if}