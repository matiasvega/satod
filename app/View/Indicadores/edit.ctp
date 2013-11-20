<script type="text/javascript">
    $(document).ready(function() {       
        $('form').h5Validate();
    });    
</script>
<div class="indicadores form">
<?php echo $this->Form->create('Indicadore'); ?>
	<fieldset>
		<legend><?php echo __('Editar datos de Indicador de Recupero'); ?></legend>
	<?php
                $opcionesGrafica = array(
                                'BarChart' => 'Barras',
                                'PieChart' => 'Torta',
                                'GeoChart' => 'Geografico',
                                'ComboChart' => 'Combo',
                                'ColumnChart' => 'Columnas',
                                'AreaChart' => 'Areas',
                            );
        
        
		echo $this->Form->input('id');
		echo $this->Form->input('etiqueta', array(
                                            'required' => true,
                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique el indicador.',
                                            'title' => 'Campo requerido',
                                                        )
                                        );
                if ($this->request->data['Indicadore']['calculo'] == 'group') {
                    echo $this->Form->input('grafica', array(
                                                                'options' => $opcionesGrafica,
                                                                'value' => $this->request->data['Indicadore']['grafica'],
                                                            )
                                            );                    
                }

//		echo $this->Form->input('Cartera');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--
<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>

		<li><?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Indicadore.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Indicadore.id'))); ?></li>
		<li><?php // echo $this->Html->link(__('List Indicadores'), array('action' => 'index')); ?></li>
		<li><?php // echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
