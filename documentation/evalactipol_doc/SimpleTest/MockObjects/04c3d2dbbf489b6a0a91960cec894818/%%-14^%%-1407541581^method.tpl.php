<?php /* Smarty version 2.6.0, created on 2009-05-26 19:20:45
         compiled from method.tpl */ ?>
<?php require_once(SMARTY_DIR . 'core' . DIRECTORY_SEPARATOR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', 'method.tpl', 33, false),)), $this); ?>
<?php if (isset($this->_sections['methods'])) unset($this->_sections['methods']);
$this->_sections['methods']['name'] = 'methods';
$this->_sections['methods']['loop'] = is_array($_loop=$this->_tpl_vars['methods']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['methods']['show'] = true;
$this->_sections['methods']['max'] = $this->_sections['methods']['loop'];
$this->_sections['methods']['step'] = 1;
$this->_sections['methods']['start'] = $this->_sections['methods']['step'] > 0 ? 0 : $this->_sections['methods']['loop']-1;
if ($this->_sections['methods']['show']) {
    $this->_sections['methods']['total'] = $this->_sections['methods']['loop'];
    if ($this->_sections['methods']['total'] == 0)
        $this->_sections['methods']['show'] = false;
} else
    $this->_sections['methods']['total'] = 0;
if ($this->_sections['methods']['show']):

            for ($this->_sections['methods']['index'] = $this->_sections['methods']['start'], $this->_sections['methods']['iteration'] = 1;
                 $this->_sections['methods']['iteration'] <= $this->_sections['methods']['total'];
                 $this->_sections['methods']['index'] += $this->_sections['methods']['step'], $this->_sections['methods']['iteration']++):
$this->_sections['methods']['rownum'] = $this->_sections['methods']['iteration'];
$this->_sections['methods']['index_prev'] = $this->_sections['methods']['index'] - $this->_sections['methods']['step'];
$this->_sections['methods']['index_next'] = $this->_sections['methods']['index'] + $this->_sections['methods']['step'];
$this->_sections['methods']['first']      = ($this->_sections['methods']['iteration'] == 1);
$this->_sections['methods']['last']       = ($this->_sections['methods']['iteration'] == $this->_sections['methods']['total']);
 if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['static']):  if ($this->_tpl_vars['show'] == 'summary'): ?>
	<p>static method <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_call']; ?>
, <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['sdesc']; ?>
</p>
<?php else: ?>
	<a name="<?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_dest']; ?>
"></a>
	<p></p>
	<h3>static <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_name']; ?>
</h3>
	<div class="indent">
		<p>
		<code>static <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_return']; ?>
 <?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['returnsref']): ?>&amp;<?php endif;  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_name']; ?>
(
<?php if (count ( $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'] )):  if (isset($this->_sections['params'])) unset($this->_sections['params']);
$this->_sections['params']['name'] = 'params';
$this->_sections['params']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['params']['show'] = true;
$this->_sections['params']['max'] = $this->_sections['params']['loop'];
$this->_sections['params']['step'] = 1;
$this->_sections['params']['start'] = $this->_sections['params']['step'] > 0 ? 0 : $this->_sections['params']['loop']-1;
if ($this->_sections['params']['show']) {
    $this->_sections['params']['total'] = $this->_sections['params']['loop'];
    if ($this->_sections['params']['total'] == 0)
        $this->_sections['params']['show'] = false;
} else
    $this->_sections['params']['total'] = 0;
if ($this->_sections['params']['show']):

            for ($this->_sections['params']['index'] = $this->_sections['params']['start'], $this->_sections['params']['iteration'] = 1;
                 $this->_sections['params']['iteration'] <= $this->_sections['params']['total'];
                 $this->_sections['params']['index'] += $this->_sections['params']['step'], $this->_sections['params']['iteration']++):
$this->_sections['params']['rownum'] = $this->_sections['params']['iteration'];
$this->_sections['params']['index_prev'] = $this->_sections['params']['index'] - $this->_sections['params']['step'];
$this->_sections['params']['index_next'] = $this->_sections['params']['index'] + $this->_sections['params']['step'];
$this->_sections['params']['first']      = ($this->_sections['params']['iteration'] == 1);
$this->_sections['params']['last']       = ($this->_sections['params']['iteration'] == $this->_sections['params']['total']);
 if ($this->_sections['params']['iteration'] != 1): ?>, <?php endif;  if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['hasdefault']): ?>[<?php endif;  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['type']; ?>

<?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['name'];  if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['hasdefault']): ?> = <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['default']; ?>
]<?php endif;  endfor; endif;  endif; ?>)</code>
		</p>
	
		<p class="linenumber">[line <?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['slink']):  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['slink'];  else:  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['line_number'];  endif; ?>]</p>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "docblock.tpl", 'smarty_include_vars' => array('sdesc' => $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['sdesc'],'desc' => $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['desc'],'tags' => $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['tags'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		
<?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod']): ?>
	<p>Overridden in child classes as:<br />
	<?php if (isset($this->_sections['dm'])) unset($this->_sections['dm']);
$this->_sections['dm']['name'] = 'dm';
$this->_sections['dm']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['dm']['show'] = true;
$this->_sections['dm']['max'] = $this->_sections['dm']['loop'];
$this->_sections['dm']['step'] = 1;
$this->_sections['dm']['start'] = $this->_sections['dm']['step'] > 0 ? 0 : $this->_sections['dm']['loop']-1;
if ($this->_sections['dm']['show']) {
    $this->_sections['dm']['total'] = $this->_sections['dm']['loop'];
    if ($this->_sections['dm']['total'] == 0)
        $this->_sections['dm']['show'] = false;
} else
    $this->_sections['dm']['total'] = 0;
if ($this->_sections['dm']['show']):

            for ($this->_sections['dm']['index'] = $this->_sections['dm']['start'], $this->_sections['dm']['iteration'] = 1;
                 $this->_sections['dm']['iteration'] <= $this->_sections['dm']['total'];
                 $this->_sections['dm']['index'] += $this->_sections['dm']['step'], $this->_sections['dm']['iteration']++):
$this->_sections['dm']['rownum'] = $this->_sections['dm']['iteration'];
$this->_sections['dm']['index_prev'] = $this->_sections['dm']['index'] - $this->_sections['dm']['step'];
$this->_sections['dm']['index_next'] = $this->_sections['dm']['index'] + $this->_sections['dm']['step'];
$this->_sections['dm']['first']      = ($this->_sections['dm']['iteration'] == 1);
$this->_sections['dm']['last']       = ($this->_sections['dm']['iteration'] == $this->_sections['dm']['total']);
?>
	<dl>
	<dt><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod'][$this->_sections['dm']['index']]['link']; ?>
</dt>
		<dd><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod'][$this->_sections['dm']['index']]['sdesc']; ?>
</dd>
	</dl>
	<?php endfor; endif; ?></p>
<?php endif;  if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_overrides']): ?><p>Overrides <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_overrides']['link']; ?>
 (<?php echo ((is_array($_tmp=@$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_overrides']['sdesc'])) ? $this->_run_mod_handler('default', true, $_tmp, 'parent method not documented') : smarty_modifier_default($_tmp, 'parent method not documented')); ?>
)</p><?php endif; ?>
	<?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements']): ?>
		<hr class="separator" />
		<div class="notes">Implementation of:</div>
	<?php if (isset($this->_sections['imp'])) unset($this->_sections['imp']);
$this->_sections['imp']['name'] = 'imp';
$this->_sections['imp']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['imp']['show'] = true;
$this->_sections['imp']['max'] = $this->_sections['imp']['loop'];
$this->_sections['imp']['step'] = 1;
$this->_sections['imp']['start'] = $this->_sections['imp']['step'] > 0 ? 0 : $this->_sections['imp']['loop']-1;
if ($this->_sections['imp']['show']) {
    $this->_sections['imp']['total'] = $this->_sections['imp']['loop'];
    if ($this->_sections['imp']['total'] == 0)
        $this->_sections['imp']['show'] = false;
} else
    $this->_sections['imp']['total'] = 0;
if ($this->_sections['imp']['show']):

            for ($this->_sections['imp']['index'] = $this->_sections['imp']['start'], $this->_sections['imp']['iteration'] = 1;
                 $this->_sections['imp']['iteration'] <= $this->_sections['imp']['total'];
                 $this->_sections['imp']['index'] += $this->_sections['imp']['step'], $this->_sections['imp']['iteration']++):
$this->_sections['imp']['rownum'] = $this->_sections['imp']['iteration'];
$this->_sections['imp']['index_prev'] = $this->_sections['imp']['index'] - $this->_sections['imp']['step'];
$this->_sections['imp']['index_next'] = $this->_sections['imp']['index'] + $this->_sections['imp']['step'];
$this->_sections['imp']['first']      = ($this->_sections['imp']['iteration'] == 1);
$this->_sections['imp']['last']       = ($this->_sections['imp']['iteration'] == $this->_sections['imp']['total']);
?>
		<dl>
			<dt><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements'][$this->_sections['imp']['index']]['link']; ?>
</dt>
			<?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements'][$this->_sections['imp']['index']]['sdesc']): ?>
			<dd><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements'][$this->_sections['imp']['index']]['sdesc']; ?>
</dd>
			<?php endif; ?>
		</dl>
	<?php endfor; endif; ?>
	<?php endif; ?>

	<h4>Parameters:</h4>
	<ul>
	<?php if (isset($this->_sections['params'])) unset($this->_sections['params']);
$this->_sections['params']['name'] = 'params';
$this->_sections['params']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['params']['show'] = true;
$this->_sections['params']['max'] = $this->_sections['params']['loop'];
$this->_sections['params']['step'] = 1;
$this->_sections['params']['start'] = $this->_sections['params']['step'] > 0 ? 0 : $this->_sections['params']['loop']-1;
if ($this->_sections['params']['show']) {
    $this->_sections['params']['total'] = $this->_sections['params']['loop'];
    if ($this->_sections['params']['total'] == 0)
        $this->_sections['params']['show'] = false;
} else
    $this->_sections['params']['total'] = 0;
if ($this->_sections['params']['show']):

            for ($this->_sections['params']['index'] = $this->_sections['params']['start'], $this->_sections['params']['iteration'] = 1;
                 $this->_sections['params']['iteration'] <= $this->_sections['params']['total'];
                 $this->_sections['params']['index'] += $this->_sections['params']['step'], $this->_sections['params']['iteration']++):
$this->_sections['params']['rownum'] = $this->_sections['params']['iteration'];
$this->_sections['params']['index_prev'] = $this->_sections['params']['index'] - $this->_sections['params']['step'];
$this->_sections['params']['index_next'] = $this->_sections['params']['index'] + $this->_sections['params']['step'];
$this->_sections['params']['first']      = ($this->_sections['params']['iteration'] == 1);
$this->_sections['params']['last']       = ($this->_sections['params']['iteration'] == $this->_sections['params']['total']);
?>
		<li>
		<span class="type"><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params'][$this->_sections['params']['index']]['datatype']; ?>
</span>
		<b><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params'][$this->_sections['params']['index']]['var']; ?>
</b> 
		- 
		<?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params'][$this->_sections['params']['index']]['data']; ?>
</li>
	<?php endfor; endif; ?>
	</ul>
	</div>
	<p class="top">[ <a href="#top">Top</a> ]</p>
<?php endif;  endif;  endfor; endif; ?>

<?php if (isset($this->_sections['methods'])) unset($this->_sections['methods']);
$this->_sections['methods']['name'] = 'methods';
$this->_sections['methods']['loop'] = is_array($_loop=$this->_tpl_vars['methods']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['methods']['show'] = true;
$this->_sections['methods']['max'] = $this->_sections['methods']['loop'];
$this->_sections['methods']['step'] = 1;
$this->_sections['methods']['start'] = $this->_sections['methods']['step'] > 0 ? 0 : $this->_sections['methods']['loop']-1;
if ($this->_sections['methods']['show']) {
    $this->_sections['methods']['total'] = $this->_sections['methods']['loop'];
    if ($this->_sections['methods']['total'] == 0)
        $this->_sections['methods']['show'] = false;
} else
    $this->_sections['methods']['total'] = 0;
if ($this->_sections['methods']['show']):

            for ($this->_sections['methods']['index'] = $this->_sections['methods']['start'], $this->_sections['methods']['iteration'] = 1;
                 $this->_sections['methods']['iteration'] <= $this->_sections['methods']['total'];
                 $this->_sections['methods']['index'] += $this->_sections['methods']['step'], $this->_sections['methods']['iteration']++):
$this->_sections['methods']['rownum'] = $this->_sections['methods']['iteration'];
$this->_sections['methods']['index_prev'] = $this->_sections['methods']['index'] - $this->_sections['methods']['step'];
$this->_sections['methods']['index_next'] = $this->_sections['methods']['index'] + $this->_sections['methods']['step'];
$this->_sections['methods']['first']      = ($this->_sections['methods']['iteration'] == 1);
$this->_sections['methods']['last']       = ($this->_sections['methods']['iteration'] == $this->_sections['methods']['total']);
 if (! $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['static']):  if ($this->_tpl_vars['show'] == 'summary'): ?>
	<p><?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['constructor']): ?>constructor <?php elseif ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['destructor']): ?>destructor <?php else: ?>method <?php endif;  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_call']; ?>
, <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['sdesc']; ?>
</p>
<?php else: ?>
	<a name="<?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_dest']; ?>
"></a>
	<p></p>
	<h3><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_name']; ?>
</h3>
	<div class="indent">
		<p>
		<code><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_return']; ?>
 <?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['returnsref']): ?>&amp;<?php endif;  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['function_name']; ?>
(
<?php if (count ( $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'] )):  if (isset($this->_sections['params'])) unset($this->_sections['params']);
$this->_sections['params']['name'] = 'params';
$this->_sections['params']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['params']['show'] = true;
$this->_sections['params']['max'] = $this->_sections['params']['loop'];
$this->_sections['params']['step'] = 1;
$this->_sections['params']['start'] = $this->_sections['params']['step'] > 0 ? 0 : $this->_sections['params']['loop']-1;
if ($this->_sections['params']['show']) {
    $this->_sections['params']['total'] = $this->_sections['params']['loop'];
    if ($this->_sections['params']['total'] == 0)
        $this->_sections['params']['show'] = false;
} else
    $this->_sections['params']['total'] = 0;
if ($this->_sections['params']['show']):

            for ($this->_sections['params']['index'] = $this->_sections['params']['start'], $this->_sections['params']['iteration'] = 1;
                 $this->_sections['params']['iteration'] <= $this->_sections['params']['total'];
                 $this->_sections['params']['index'] += $this->_sections['params']['step'], $this->_sections['params']['iteration']++):
$this->_sections['params']['rownum'] = $this->_sections['params']['iteration'];
$this->_sections['params']['index_prev'] = $this->_sections['params']['index'] - $this->_sections['params']['step'];
$this->_sections['params']['index_next'] = $this->_sections['params']['index'] + $this->_sections['params']['step'];
$this->_sections['params']['first']      = ($this->_sections['params']['iteration'] == 1);
$this->_sections['params']['last']       = ($this->_sections['params']['iteration'] == $this->_sections['params']['total']);
 if ($this->_sections['params']['iteration'] != 1): ?>, <?php endif;  if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['hasdefault']): ?>[<?php endif;  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['type']; ?>

<?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['name'];  if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['hasdefault']): ?> = <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['ifunction_call']['params'][$this->_sections['params']['index']]['default']; ?>
]<?php endif;  endfor; endif;  endif; ?>)</code>
		</p>
	
		<p class="linenumber">[line <?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['slink']):  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['slink'];  else:  echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['line_number'];  endif; ?>]</p>
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "docblock.tpl", 'smarty_include_vars' => array('sdesc' => $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['sdesc'],'desc' => $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['desc'],'tags' => $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['tags'])));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		
<?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod']): ?>
	<p>Overridden in child classes as:<br />
	<?php if (isset($this->_sections['dm'])) unset($this->_sections['dm']);
$this->_sections['dm']['name'] = 'dm';
$this->_sections['dm']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['dm']['show'] = true;
$this->_sections['dm']['max'] = $this->_sections['dm']['loop'];
$this->_sections['dm']['step'] = 1;
$this->_sections['dm']['start'] = $this->_sections['dm']['step'] > 0 ? 0 : $this->_sections['dm']['loop']-1;
if ($this->_sections['dm']['show']) {
    $this->_sections['dm']['total'] = $this->_sections['dm']['loop'];
    if ($this->_sections['dm']['total'] == 0)
        $this->_sections['dm']['show'] = false;
} else
    $this->_sections['dm']['total'] = 0;
if ($this->_sections['dm']['show']):

            for ($this->_sections['dm']['index'] = $this->_sections['dm']['start'], $this->_sections['dm']['iteration'] = 1;
                 $this->_sections['dm']['iteration'] <= $this->_sections['dm']['total'];
                 $this->_sections['dm']['index'] += $this->_sections['dm']['step'], $this->_sections['dm']['iteration']++):
$this->_sections['dm']['rownum'] = $this->_sections['dm']['iteration'];
$this->_sections['dm']['index_prev'] = $this->_sections['dm']['index'] - $this->_sections['dm']['step'];
$this->_sections['dm']['index_next'] = $this->_sections['dm']['index'] + $this->_sections['dm']['step'];
$this->_sections['dm']['first']      = ($this->_sections['dm']['iteration'] == 1);
$this->_sections['dm']['last']       = ($this->_sections['dm']['iteration'] == $this->_sections['dm']['total']);
?>
	<dl>
	<dt><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod'][$this->_sections['dm']['index']]['link']; ?>
</dt>
		<dd><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['descmethod'][$this->_sections['dm']['index']]['sdesc']; ?>
</dd>
	</dl>
	<?php endfor; endif; ?></p>
<?php endif;  if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_overrides']): ?><p>Overrides <?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_overrides']['link']; ?>
 (<?php echo ((is_array($_tmp=@$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_overrides']['sdesc'])) ? $this->_run_mod_handler('default', true, $_tmp, 'parent method not documented') : smarty_modifier_default($_tmp, 'parent method not documented')); ?>
)</p><?php endif; ?>
	<?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements']): ?>
		<hr class="separator" />
		<div class="notes">Implementation of:</div>
	<?php if (isset($this->_sections['imp'])) unset($this->_sections['imp']);
$this->_sections['imp']['name'] = 'imp';
$this->_sections['imp']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['imp']['show'] = true;
$this->_sections['imp']['max'] = $this->_sections['imp']['loop'];
$this->_sections['imp']['step'] = 1;
$this->_sections['imp']['start'] = $this->_sections['imp']['step'] > 0 ? 0 : $this->_sections['imp']['loop']-1;
if ($this->_sections['imp']['show']) {
    $this->_sections['imp']['total'] = $this->_sections['imp']['loop'];
    if ($this->_sections['imp']['total'] == 0)
        $this->_sections['imp']['show'] = false;
} else
    $this->_sections['imp']['total'] = 0;
if ($this->_sections['imp']['show']):

            for ($this->_sections['imp']['index'] = $this->_sections['imp']['start'], $this->_sections['imp']['iteration'] = 1;
                 $this->_sections['imp']['iteration'] <= $this->_sections['imp']['total'];
                 $this->_sections['imp']['index'] += $this->_sections['imp']['step'], $this->_sections['imp']['iteration']++):
$this->_sections['imp']['rownum'] = $this->_sections['imp']['iteration'];
$this->_sections['imp']['index_prev'] = $this->_sections['imp']['index'] - $this->_sections['imp']['step'];
$this->_sections['imp']['index_next'] = $this->_sections['imp']['index'] + $this->_sections['imp']['step'];
$this->_sections['imp']['first']      = ($this->_sections['imp']['iteration'] == 1);
$this->_sections['imp']['last']       = ($this->_sections['imp']['iteration'] == $this->_sections['imp']['total']);
?>
		<dl>
			<dt><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements'][$this->_sections['imp']['index']]['link']; ?>
</dt>
			<?php if ($this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements'][$this->_sections['imp']['index']]['sdesc']): ?>
			<dd><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['method_implements'][$this->_sections['imp']['index']]['sdesc']; ?>
</dd>
			<?php endif; ?>
		</dl>
	<?php endfor; endif; ?>
	<?php endif; ?>

	<h4>Parameters:</h4>
	<ul>
	<?php if (isset($this->_sections['params'])) unset($this->_sections['params']);
$this->_sections['params']['name'] = 'params';
$this->_sections['params']['loop'] = is_array($_loop=$this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['params']['show'] = true;
$this->_sections['params']['max'] = $this->_sections['params']['loop'];
$this->_sections['params']['step'] = 1;
$this->_sections['params']['start'] = $this->_sections['params']['step'] > 0 ? 0 : $this->_sections['params']['loop']-1;
if ($this->_sections['params']['show']) {
    $this->_sections['params']['total'] = $this->_sections['params']['loop'];
    if ($this->_sections['params']['total'] == 0)
        $this->_sections['params']['show'] = false;
} else
    $this->_sections['params']['total'] = 0;
if ($this->_sections['params']['show']):

            for ($this->_sections['params']['index'] = $this->_sections['params']['start'], $this->_sections['params']['iteration'] = 1;
                 $this->_sections['params']['iteration'] <= $this->_sections['params']['total'];
                 $this->_sections['params']['index'] += $this->_sections['params']['step'], $this->_sections['params']['iteration']++):
$this->_sections['params']['rownum'] = $this->_sections['params']['iteration'];
$this->_sections['params']['index_prev'] = $this->_sections['params']['index'] - $this->_sections['params']['step'];
$this->_sections['params']['index_next'] = $this->_sections['params']['index'] + $this->_sections['params']['step'];
$this->_sections['params']['first']      = ($this->_sections['params']['iteration'] == 1);
$this->_sections['params']['last']       = ($this->_sections['params']['iteration'] == $this->_sections['params']['total']);
?>
		<li>
		<span class="type"><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params'][$this->_sections['params']['index']]['datatype']; ?>
</span>
		<b><?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params'][$this->_sections['params']['index']]['var']; ?>
</b> 
		- 
		<?php echo $this->_tpl_vars['methods'][$this->_sections['methods']['index']]['params'][$this->_sections['params']['index']]['data']; ?>
</li>
	<?php endfor; endif; ?>
	</ul>
	</div>
	<p class="top">[ <a href="#top">Top</a> ]</p>
<?php endif;  endif;  endfor; endif; ?>