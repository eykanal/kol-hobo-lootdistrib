<?php /* Smarty version 2.6.22, created on 2009-12-23 09:13:01
         compiled from index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'regex_replace', 'index.tpl', 46, false),array('modifier', 'lower', 'index.tpl', 46, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php if (isset ( $this->_tpl_vars['error'] )): ?><div class='ui-state-error ui-state-error-text'><?php echo $this->_tpl_vars['error']; ?>
</div><?php endif; ?>
<?php if (isset ( $this->_tpl_vars['info'] )): ?><div class='ui-icon-info'><?php echo $this->_tpl_vars['info']; ?>
</div><?php endif; ?>

<?php if (isset ( $this->_tpl_vars['round_one'] )): ?>
<div id="tab_container">
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
	<form action='<?php echo $this->_tpl_vars['form_action_self']; ?>
' method='post' enctype='multipart/form-data'>
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
<?php else: ?>
<a href='#' title='show all results' id='toggle_loot_disp'>Show all results</a>
<table id='loot_results'>
<?php unset($this->_sections['n']);
$this->_sections['n']['name'] = 'n';
$this->_sections['n']['loop'] = is_array($_loop=$this->_tpl_vars['loot']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['n']['show'] = true;
$this->_sections['n']['max'] = $this->_sections['n']['loop'];
$this->_sections['n']['step'] = 1;
$this->_sections['n']['start'] = $this->_sections['n']['step'] > 0 ? 0 : $this->_sections['n']['loop']-1;
if ($this->_sections['n']['show']) {
    $this->_sections['n']['total'] = $this->_sections['n']['loop'];
    if ($this->_sections['n']['total'] == 0)
        $this->_sections['n']['show'] = false;
} else
    $this->_sections['n']['total'] = 0;
if ($this->_sections['n']['show']):

            for ($this->_sections['n']['index'] = $this->_sections['n']['start'], $this->_sections['n']['iteration'] = 1;
                 $this->_sections['n']['iteration'] <= $this->_sections['n']['total'];
                 $this->_sections['n']['index'] += $this->_sections['n']['step'], $this->_sections['n']['iteration']++):
$this->_sections['n']['rownum'] = $this->_sections['n']['iteration'];
$this->_sections['n']['index_prev'] = $this->_sections['n']['index'] - $this->_sections['n']['step'];
$this->_sections['n']['index_next'] = $this->_sections['n']['index'] + $this->_sections['n']['step'];
$this->_sections['n']['first']      = ($this->_sections['n']['iteration'] == 1);
$this->_sections['n']['last']       = ($this->_sections['n']['iteration'] == $this->_sections['n']['total']);
?>
	<tr class='loot_entry<?php if ($this->_sections['n']['last']): ?> bottom<?php endif; ?><?php if (! $this->_tpl_vars['loot'][$this->_sections['n']['index']]->gotSomething): ?> noloot noloot_hide<?php endif; ?>'>
		<td class='loot_name'><?php echo $this->_tpl_vars['loot'][$this->_sections['n']['index']]->name; ?>
</td>
		<td class='loot_items<?php if (! $this->_tpl_vars['loot'][$this->_sections['n']['index']]->gotSomething): ?> text<?php endif; ?>'><?php if (isset ( $this->_tpl_vars['loot'][$this->_sections['n']['index']]->lootResults )): ?><?php $_from = $this->_tpl_vars['loot'][$this->_sections['n']['index']]->lootResults; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?><?php if ($this->_tpl_vars['loot'][$this->_sections['n']['index']]->gotSomething): ?><img src='lootImages/<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['i'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/\'/", "") : smarty_modifier_regex_replace($_tmp, "/\'/", "")))) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/ /", '_') : smarty_modifier_regex_replace($_tmp, "/ /", '_')))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
.gif' alt='<?php echo $this->_tpl_vars['i']; ?>
' title='<?php echo $this->_tpl_vars['i']; ?>
' class='loot_item'><?php else: ?><?php echo $this->_tpl_vars['i']; ?>
<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php endif; ?></td>
	</tr>
<?php endfor; endif; ?>
</table>
<?php unset($this->_sections['n']);
$this->_sections['n']['name'] = 'n';
$this->_sections['n']['loop'] = is_array($_loop=$this->_tpl_vars['loot']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['n']['show'] = true;
$this->_sections['n']['max'] = $this->_sections['n']['loop'];
$this->_sections['n']['step'] = 1;
$this->_sections['n']['start'] = $this->_sections['n']['step'] > 0 ? 0 : $this->_sections['n']['loop']-1;
if ($this->_sections['n']['show']) {
    $this->_sections['n']['total'] = $this->_sections['n']['loop'];
    if ($this->_sections['n']['total'] == 0)
        $this->_sections['n']['show'] = false;
} else
    $this->_sections['n']['total'] = 0;
if ($this->_sections['n']['show']):

            for ($this->_sections['n']['index'] = $this->_sections['n']['start'], $this->_sections['n']['iteration'] = 1;
                 $this->_sections['n']['iteration'] <= $this->_sections['n']['total'];
                 $this->_sections['n']['index'] += $this->_sections['n']['step'], $this->_sections['n']['iteration']++):
$this->_sections['n']['rownum'] = $this->_sections['n']['iteration'];
$this->_sections['n']['index_prev'] = $this->_sections['n']['index'] - $this->_sections['n']['step'];
$this->_sections['n']['index_next'] = $this->_sections['n']['index'] + $this->_sections['n']['step'];
$this->_sections['n']['first']      = ($this->_sections['n']['iteration'] == 1);
$this->_sections['n']['last']       = ($this->_sections['n']['iteration'] == $this->_sections['n']['total']);
?>
<?php if (isset ( $this->_tpl_vars['loot'][$this->_sections['n']['index']]->lootResults )): ?><?php $_from = $this->_tpl_vars['loot'][$this->_sections['n']['index']]->lootResults; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?><?php if ($this->_tpl_vars['loot'][$this->_sections['n']['index']]->gotSomething): ?><input type='hidden' name='loot[<?php echo $this->_sections['n']['index']; ?>
]' value="'<?php echo $this->_tpl_vars['i']; ?>
'">
<?php endif; ?><?php endforeach; endif; unset($_from); ?><?php endif; ?>
<?php endfor; endif; ?>
<?php endif; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>