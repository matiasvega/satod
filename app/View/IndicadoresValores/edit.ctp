<script type="text/javascript">
    $(document).ready(function() {       
        $('form').h5Validate();
    });    
</script>


<div class="indicadoresValores form">
<?php echo $this->Form->create('IndicadoresValore'); ?>
	<fieldset>
		<legend><?php echo __('Editar valor de Indicador'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('valor', array(
                                            'required' => true,
                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique el valor del indicador.',
                                            'title' => 'Campo requerido',                                
                                                    )
                                        );
		echo $this->Form->input('valor_ponderado', array(
                                            'required' => true,
                                            'placeholder' => 'Ingresa un valor numerico que cuantifique el valor del indicador.',
                                            'title' => 'Campo requerido',
                                            'type' => 'number',
                                                                )
                                        );
//		echo $this->Form->input('valor_calculo');
//		echo $this->Form->input('indicadores_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('IndicadoresValore.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('IndicadoresValore.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Indicadores Valores'), array('action' => 'index')); ?></li>
		<li><?php // echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
