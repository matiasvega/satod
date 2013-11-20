<?php
//    dd($this->request->data);
?>
<script>
    $(document).ready(function() {
        $('form').h5Validate();
        
        $( "#comision" ).spinner({
            step: 0.01,
            numberFormat: "n"
        });
               
        $('.combo_estado_cartera').bind('click', function() {
            if ($(this).val() == 'A') {
                $('#idAsignacionLogisis').prop('disabled', false);
            } else {
                $('#idAsignacionLogisis').val(" ");
                $('#idAsignacionLogisis').prop('disabled', true);                
            }
        });
        
        
    });
</script>
<div class="carteras form">
<?php echo $this->Form->create('Cartera'); ?>
	<fieldset>
		<legend><?php echo __('Editar Cartera de Deudores'); ?></legend>
	<?php
		echo $this->Form->input('id');
                echo $this->Form->input('nombre', array(
                                    'required' => true,
                                    'placeholder' => 'Ingresa un nombre descriptivo que identifique la cartera.',
                                    'title' => 'Campo requerido',
                                                )
                                );
                
                
//		echo $this->Form->input('estado');
                if ($this->request->data['Cartera']['estado'] == 'P') {
                    $estado = $this->Form->radio('estado', array(
                                                            'P' => 'Potencial', 
                                                            'A'=> 'Asignada',
                                                            ), 
                                                      array(
                                                                'value' => (!empty($this->request->data['Cartera']['estado']))?$this->request->data['Cartera']['estado']:'P',
                                                                'class' => 'combo_estado_cartera',
                                                                'legend' => 'Estado',
                                                          )
                                            );                    
                

                
                    echo $this->Html->tag('div', $this->Html->tag('span', $estado), array(
                                                            'id' => 'contenedorRadio'
                                                            )
                                    );
                    
                    echo $this->Form->input('idAsignacionLogisis', array(
                                        'disabled' => (($this->request->data['Cartera']['estado'] == 'A'))?false:true,
                                        'required' => true,
                                        'id' => 'idAsignacionLogisis',
                                        'placeholder' => 'Ingresa el identificador de asignacion en Logisis',
                                                )
                            );
                    
                }
                
                
                
		echo $this->Form->input('comision', array(                                        
                                                    'id' => 'comision',
                                                    'label' => 'Comision %',
                                                    'required' => true,
                                                    'placeholder' => 'Ingresa el porcentaje de comision que se cobrara al cliente.',
                                                            )
                                        );
//		echo $this->Form->input('Indicadore');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Cartera.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Cartera.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Carteras'), array('action' => 'index')); ?></li>
		<li><?php // echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Clientes'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php // echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
