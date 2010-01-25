<?php /* Smarty version 2.6.22, created on 2010-01-24 19:13:07
         compiled from distrib.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'regex_replace', 'distrib.tpl', 9, false),array('modifier', 'lower', 'distrib.tpl', 9, false),array('function', 'math', 'distrib.tpl', 21, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<form action='process.php' method='post'>
<div id='floater'>
	<p>Please review the suggestions below and click the "Looks good" button when ready.</p>
	<table>
<?php unset($this->_sections['n']);
$this->_sections['n']['name'] = 'n';
$this->_sections['n']['loop'] = is_array($_loop=$this->_tpl_vars['loot_results']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<tr>
			<td class='loot'><img src='lootImages/<?php echo ((is_array($_tmp=((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['loot_results'][$this->_sections['n']['index']]['loot'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/\'/", "") : smarty_modifier_regex_replace($_tmp, "/\'/", "")))) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/ /", '_') : smarty_modifier_regex_replace($_tmp, "/ /", '_')))) ? $this->_run_mod_handler('lower', true, $_tmp) : smarty_modifier_lower($_tmp)); ?>
.gif' alt="<?php echo $this->_tpl_vars['loot_results'][$this->_sections['n']['index']]['loot']; ?>
" title="<?php echo $this->_tpl_vars['loot_results'][$this->_sections['n']['index']]['loot']; ?>
" class='loot_item'></td>
			<td class='name'><select name="<?php echo $this->_tpl_vars['loot_results'][$this->_sections['n']['index']]['loot']; ?>
"><?php unset($this->_sections['m']);
$this->_sections['m']['name'] = 'm';
$this->_sections['m']['loop'] = is_array($_loop=$this->_tpl_vars['loot']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['m']['show'] = true;
$this->_sections['m']['max'] = $this->_sections['m']['loop'];
$this->_sections['m']['step'] = 1;
$this->_sections['m']['start'] = $this->_sections['m']['step'] > 0 ? 0 : $this->_sections['m']['loop']-1;
if ($this->_sections['m']['show']) {
    $this->_sections['m']['total'] = $this->_sections['m']['loop'];
    if ($this->_sections['m']['total'] == 0)
        $this->_sections['m']['show'] = false;
} else
    $this->_sections['m']['total'] = 0;
if ($this->_sections['m']['show']):

            for ($this->_sections['m']['index'] = $this->_sections['m']['start'], $this->_sections['m']['iteration'] = 1;
                 $this->_sections['m']['iteration'] <= $this->_sections['m']['total'];
                 $this->_sections['m']['index'] += $this->_sections['m']['step'], $this->_sections['m']['iteration']++):
$this->_sections['m']['rownum'] = $this->_sections['m']['iteration'];
$this->_sections['m']['index_prev'] = $this->_sections['m']['index'] - $this->_sections['m']['step'];
$this->_sections['m']['index_next'] = $this->_sections['m']['index'] + $this->_sections['m']['step'];
$this->_sections['m']['first']      = ($this->_sections['m']['iteration'] == 1);
$this->_sections['m']['last']       = ($this->_sections['m']['iteration'] == $this->_sections['m']['total']);
?><?php if ($this->_tpl_vars['loot'][$this->_sections['m']['index']]->throughSewer): ?><option value='<?php echo $this->_tpl_vars['loot'][$this->_sections['m']['index']]->name; ?>
'<?php if ($this->_tpl_vars['loot'][$this->_sections['m']['index']]->name == $this->_tpl_vars['loot_results'][$this->_sections['n']['index']]['name']): ?> selected<?php endif; ?>><?php echo $this->_tpl_vars['loot'][$this->_sections['m']['index']]->name; ?>
<?php if ($this->_tpl_vars['loot'][$this->_sections['m']['index']]->name == $this->_tpl_vars['loot_results'][$this->_sections['n']['index']]['name']): ?> (suggested)<?php endif; ?></option><?php endif; ?><?php endfor; endif; ?></select></td>
		</tr>
<?php endfor; endif; ?>
	</table>
	<div id='filler'><input type='submit' name='submit' value='Looks good!'></div>
</div>

<table id='loot_results' cellpadding='0' cellspacing='0'>
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
	<tr class='loot_entry<?php if ($this->_sections['n']['index']%2 == 1): ?> shaded<?php endif; ?><?php if ($this->_sections['n']['first']): ?> top<?php endif; ?><?php if (! $this->_tpl_vars['loot'][$this->_sections['n']['index']]->throughSewer): ?> ineligible<?php endif; ?>'>
		<td class='name'><?php echo $this->_tpl_vars['loot'][$this->_sections['n']['index']]->name; ?>
</td>
		<td class='rank'><?php echo smarty_function_math(array('x' => $this->_tpl_vars['loot'][$this->_sections['n']['index']]->turns,'y' => $this->_tpl_vars['loot'][$this->_sections['n']['index']]->oldTurns,'equation' => "x+y"), $this);?>
 <span class='fade'>(<?php echo $this->_tpl_vars['loot'][$this->_sections['n']['index']]->turns; ?>
)</span></td>
		<td class='text'><?php if (! $this->_tpl_vars['loot'][$this->_sections['n']['index']]->gotSomething): ?><ul><?php $_from = $this->_tpl_vars['loot'][$this->_sections['n']['index']]->lootResults; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['i']):
?><li><?php echo $this->_tpl_vars['i']; ?>
</li><?php endforeach; endif; unset($_from); ?></ul><?php else: ?>&nbsp;<?php endif; ?></td>
	</tr>
<?php endfor; endif; ?>
</table>
</form>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>