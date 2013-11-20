<div class="planificaciones form">
<?php echo $this->Form->create('Planificacione'); ?>
	<fieldset>
		<legend><?php echo __('Edit Planificacione'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('fecha_inicio');
		echo $this->Form->input('fecha_fin');
		echo $this->Form->input('carteras_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Planificacione.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Planificacione.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Planificaciones'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
