<script type="text/javascript">
    
    $(document).ready(function() {
        $('form').h5Validate();
    });
</script>

<div class="estrategias form">
<?php echo $this->Form->create('Estrategia'); ?>
	<fieldset>
		<legend><?php echo __('Editar datos de Estrategia'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre', array(
                                            'required' => true,
                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique la estrategia.',
                                            'title' => 'Campo requerido',
                                                        )
                                        );
		echo $this->Form->input('descripcion');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Estrategia.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Estrategia.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Estrategias'), array('action' => 'index')); ?></li>
	</ul>
</div>-->
