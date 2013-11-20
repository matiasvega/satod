<div class="indicadoresValores form">
<?php echo $this->Form->create('IndicadoresValore'); ?>
	<fieldset>
		<legend><?php echo __('Add Indicadores Valore'); ?></legend>
	<?php
		echo $this->Form->input('valor');
		echo $this->Form->input('valor_ponderado');
		echo $this->Form->input('valor_calculo');
		echo $this->Form->input('indicadores_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Indicadores Valores'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
	</ul>
</div>
