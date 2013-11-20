<div class="carterasIndicadores form">
<?php echo $this->Form->create('CarterasIndicadore'); ?>
	<fieldset>
		<legend><?php echo __('Add Carteras Indicadore'); ?></legend>
	<?php
		echo $this->Form->input('indicadores_id');
		echo $this->Form->input('carteras_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Carteras Indicadores'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
