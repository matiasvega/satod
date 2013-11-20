<div class="costosEstrategias form">
<?php echo $this->Form->create('CostosEstrategia'); ?>
	<fieldset>
		<legend><?php echo __('Add Costos Estrategia'); ?></legend>
	<?php
		echo $this->Form->input('costos_id');
		echo $this->Form->input('estrategias_id');
		echo $this->Form->input('multiplicador');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Costos Estrategias'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Costos'), array('controller' => 'costos', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Costos'), array('controller' => 'costos', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
	</ul>
</div>
