<script type="text/javascript">
    
    $(document).ready(function() {        
        $('form').h5Validate();
    });
    
    
    
</script>
<div class="costos form">
<?php echo $this->Form->create('Costo'); ?>
	<fieldset>
		<legend><?php echo __('Registrar Costo de Gestion'); ?></legend>
	<?php
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
                                                            'value' => 'F',
                                                            'title' => 'Selecciona el tipo costo.',
                                                            'id' => 'tipoCosto',
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
                    'id' => 'grupo',
                ));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>

		<li><?php //echo $this->Html->link(__('List Costos'), array('action' => 'index')); ?></li>
	</ul>
</div>
-->