<?php /* Smarty version 2.6.22, created on 2010-01-18 19:55:18
         compiled from form.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div id="tab_container" style="margin: 0 0 10px 0;">
<div class="tabber">
	<div class="tabbertab" title="Current Points">
<?php if (count ( $this->_tpl_vars['divers'] ) == 0): ?>There are no points allocated as of yet.<?php else: ?>
		<div class='diver header'><div class='name'>Diver Name</div><div class='points'>Saved Points</div><div class='activeDate'>Date of Last Activity</div></div>
<?php $_from = $this->_tpl_vars['divers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['divers'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['divers']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['m']):
        $this->_foreach['divers']['iteration']++;
?>		<div class='diver<?php if (($this->_foreach['divers']['iteration']-1)%2 == 1): ?> shaded<?php endif; ?><?php if (($this->_foreach['divers']['iteration'] == $this->_foreach['divers']['total'])): ?> last<?php endif; ?>'><div class='name'><?php echo $this->_tpl_vars['m']->name; ?>
</div><div class='points'><?php echo $this->_tpl_vars['m']->oldTurns; ?>
</div><div class='activeDate'><?php echo $this->_tpl_vars['m']->lastActiveDate; ?>
</div></div>
<?php endforeach; endif; unset($_from); ?>
<?php endif; ?>
	</div>
	<div class="tabbertab" title="Settings">
		The settings are not yet set up.
<!--<?php echo $this->_tpl_vars['settings']; ?>
-->
	</div>
	<div class="tabbertab" title="Archive">
		The archive is not yet set up.
<!--<?php echo $this->_tpl_vars['archive']; ?>
-->
	</div>
</div>
</div>

<div id='distrib_form'>
	<form action='showResults.php' method='post' enctype='multipart/form-data'>
	<h3>Dungeon log:</h3>
	<textarea name='log_raw'></textarea>
	<h3>Loot list:</h3>
	<textarea name='loot_raw'></textarea>
	<h3>Wish list:</h3>
	<input type="file" name="wish_list" size="35">
	<div id='mySubmit'>
		<input type='submit' name='submit' value='Show me the loot!'>
	</div>
	</form>
</div>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>