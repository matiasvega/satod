<script type="text/javascript">    
    $(document).ready(function() {
        $('form').h5Validate();
    });
</script>

<div class="costosEstrategias form">
<?php echo $this->Form->create('CostosEstrategia'); ?>
	<fieldset>
		<legend><?php echo __('Editar Costos Estrategia'); ?></legend>
	<?php
		echo $this->Form->input('id');
//		echo $this->Form->input('costos_id');
//		echo $this->Form->input('estrategias_id');
		echo $this->Form->input('multiplicador', array(
                                        'required' => true,
                                        'placeholder' => 'Ingresa un valor multiplicador del costo unitario acorde a la estrategia.',
                                        'title' => 'Campo requerido',
                                                        )
                                        );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('CostosEstrategia.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('CostosEstrategia.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Costos Estrategias'), array('action' => 'index')); ?></li>
		<li><?php // echo $this->Html->link(__('List Costos'), array('controller' => 'costos', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Costos'), array('controller' => 'costos', 'action' => 'add')); ?> </li>
		<li><?php // echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
