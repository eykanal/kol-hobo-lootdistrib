<?php /* Smarty version 2.6.22, created on 2010-01-18 19:50:36
         compiled from header.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">

<title>Testing</title>

<?php echo '<script src="javascript/jquery.js" type="text/javascript"></script>
<script src="javascript/jquery-ui.js" type="text/javascript"></script>
<script src="javascript/custom.js" type="text/javascript"></script>
<script src="javascript/tabber.js" type="text/javascript"></script>

<link rel="stylesheet" href="styles/tabber.css" type="text/css">
<link rel="stylesheet" href="styles/styles.css" type="text/css">'; ?>


</head>
<body>
<div id='header_image'><a href='index.php'><img src='logo.gif' alt='Home page'></a></div>

<?php if (isset ( $this->_tpl_vars['error'] )): ?><div class='ui-state-error ui-state-error-text'><?php echo $this->_tpl_vars['error']; ?>
</div><?php endif; ?>
<?php if (isset ( $this->_tpl_vars['info'] )): ?><div class='ui-icon-info'><?php echo $this->_tpl_vars['info']; ?>
</div><?php endif; ?>