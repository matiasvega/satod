<div class="pagos form">
<?php echo $this->Form->create('Pago'); ?>
	<fieldset>
		<legend><?php echo __('Add Pago'); ?></legend>
	<?php
		echo $this->Form->input('carteras_id');
		echo $this->Form->input('monto');
		echo $this->Form->input('fecha');
		echo $this->Form->input('idImportacion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Pagos'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
