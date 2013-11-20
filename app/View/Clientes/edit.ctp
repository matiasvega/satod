<script type="text/javascript">
    
    $(document).ready(function() {               
        $('form').h5Validate();
        $('.combo_estado_cliente').bind('click', function() {
            if ($(this).val() == 'E') {
                $('#idLogisis').prop('disabled', false);
            } else {
                $('#idLogisis').val(" ");
                $('#idLogisis').prop('disabled', true);                
            }
        });
    });

    
</script>

<div class="clientes form">
<?php echo $this->Form->create('Cliente'); ?>
	<fieldset>
		<legend><?php echo __('Editar datos de Cliente'); ?></legend>
	<?php
		echo $this->Form->input('id');
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
                                                            'value' => (!empty($this->request->data['Cliente']['estado']))?$this->request->data['Cliente']['estado']:'P',
                                                            'class' => 'combo_estado_cliente',
                                                            'legend' => 'Estado',
                                                      )
                                        );
                
                echo $this->Html->tag('div', $this->Html->tag('span', $estado), array(
                                                        'id' => 'contenedorRadio'
                                                        )
                                );
                                
                echo $this->Form->input('idLogisis', array(
                                            'disabled' => (($this->request->data['Cliente']['estado'] == 'E'))?false:true,
                                            'required' => true,
                                            'id' => 'idLogisis',
                                            'placeholder' => 'Ingresa el identificador de asignacion en Logisis',
                                            )
                        );
                
                
                
                
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>

<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cliente.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Cliente.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Clientes'), array('action' => 'index')); ?></li>
	</ul>
</div>-->
