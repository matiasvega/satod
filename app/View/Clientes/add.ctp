<script type="text/javascript">
    
    $(document).ready(function() {        
        $('form').h5Validate();        
        $('.combo_estado_cliente').bind('click', function() {
            if ($(this).val() == 'E') {
                // Si el estado es efectivo, entonces habilito el campo de IdLogisis y lo controlo como requerido
                $('#idLogisis').prop('disabled', false);
            } else {
                $('#idLogisis').prop('disabled', true);
            }
        });
    });
    
    
</script>

<div class="clientes form">
<?php echo $this->Form->create('Cliente'); ?>
	<fieldset>
		<legend><?php echo __('Registrar Cliente'); ?></legend>
	<?php
		echo $this->Form->input('nombre', array(
                                                            'required' => true,
                                                            'placeholder' => 'Ingresa el nombre del cliente',
                                                            'title' => 'Ingresa el nombre del cliente',
                                                        )
                                        );
		echo $this->Form->input('direccion');
		echo $this->Form->input('telefono');
		echo $this->Form->input('email');
                
                $estado = $this->Form->radio('estado', array(
                                                        'P' => 'Potencial', 
                                                        'E'=> 'Efectivo',
                                                        ), 
                                                  array(
                                                            'value' => 'P',
                                                            'class' => 'combo_estado_cliente',
                                                            'legend' => 'Estado',
                                                      )
                                        );
                
                echo $this->Html->tag('div', $this->Html->tag('span', $estado), array(
                                                        'id' => 'contenedorRadio'
                                                        )
                                );                                
		
		echo $this->Form->input('idLogisis', array(
                                                            'disabled' => true,
                                                            'required' => true,
                                                            'id' => 'idLogisis',
                                                            'placeholder' => 'Ingresa el identificador del cliente en Logisis',
                                                            )
                                        );
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>

		<li><?php //echo $this->Html->link(__('List Clientes'), array('action' => 'index')); ?></li>
	</ul>
</div>
-->