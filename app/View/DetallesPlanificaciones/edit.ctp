<div class="detallesPlanificaciones form">
<?php echo $this->Form->create('DetallesPlanificacione'); ?>
	<fieldset>
		<legend><?php echo __('Edit Detalles Planificacione'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('fecha_inicio');
		echo $this->Form->input('fecha_fin');
		echo $this->Form->input('estrategias_id');
		echo $this->Form->input('carteras_indicadores_id');
		echo $this->Form->input('planificaciones_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('DetallesPlanificacione.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('DetallesPlanificacione.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Detalles Planificaciones'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras Indicadores'), array('controller' => 'carteras_indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras Indicadores'), array('controller' => 'carteras_indicadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Planificaciones'), array('controller' => 'planificaciones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Planificaciones'), array('controller' => 'planificaciones', 'action' => 'add')); ?> </li>
	</ul>
</div>
