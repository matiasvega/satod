<script type="text/javascript">
    
    $(document).ready(function() {        
        $('form').h5Validate();
    });
    
    
</script>
<div class="costos form">
<?php echo $this->Form->create('Costo'); ?>
	<fieldset>
		<legend><?php echo __('Editar datos de Costo'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('nombre', array(
                                                            'required' => true,
                                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique el costo.',
                                                            'title' => 'Campo requerido',
                                                        )
                                        );
		echo $this->Form->input('valor', array(
                                                            'placeholder' => 'Ingresa solo el valor unitario de costo, cuando utilices el costo en una estrategia podras asignarle un valor multiplicador para costos variables.',
                                                            'type' => 'number',
                                                        )
                                        );
                
		$tipo = $this->Form->radio('tipo', array(
                                                            'F' => 'Fijo', 
                                                            'V' => 'Variable'
                                                            ), 
                                                    array(
                                                            'value' => (!empty($this->request->data['Costo']['tipo']))?$this->request->data['Costo']['tipo']:'F',
                                                            'title' => 'Selecciona el tipo costo.'
                                                         )
                                            );                                
                
                echo $this->Html->tag('div', $this->Html->tag('span', $tipo), array(
                                                        'id' => 'contenedorRadio'
                                                        )
                                );        
                
                
                
		echo $this->Form->input('parent_id', array(
                    'label' => 'Grupo',
                    'options' => $listaCostos,
                    'empty' => '-',
                    'title' => 'Selecciona el grupo al que pertenece el costo.',
                ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Costo.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Costo.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Costos'), array('action' => 'index')); ?></li>
	</ul>
</div>-->
