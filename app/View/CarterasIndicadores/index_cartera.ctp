<?php
//    d($carterasIndicadores);

    $opcionesGrafica = array(
                                    'BarChart' => 'Barras',
                                    'PieChart' => 'Torta',
                                    'GeoChart' => 'Geografico',
                                    'ComboChart' => 'Combo',
                                    'ColumnChart' => 'Columnas',
                                    'AreaChart' => 'Areas',
                                );
    $opcionesColumna = array(
                                'sum' => 'SUMA',
                                'avg' => 'PROMEDIO',
                                'group' => 'GRUPO'
                            );
?>
<div class="carterasIndicadores index">
	<h2><?php echo sprintf('Indicadores de recupero de la cartera: %s.', $carterasIndicadores[0]['Cartera']['nombre']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('indicadores_id', 'Indicador'); ?></th>
                        <th><?php echo $this->Paginator->sort('tipo', 'Tipo'); ?></th>
                        <th><?php echo $this->Paginator->sort('calculo', 'Calculo'); ?></th>
			<!--<th><?php // echo $this->Paginator->sort('carteras_id'); ?></th>-->
			<!--<th><?php // echo $this->Paginator->sort('created'); ?></th>-->
			<!--<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($carterasIndicadores as $carterasIndicadore): ?>
	<tr>
		<td><?php echo h($carterasIndicadore['CarterasIndicadore']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($carterasIndicadore['Indicadore']['etiqueta'], array('controller' => 'indicadores_valores', 'action' => 'indexIndicador', $carterasIndicadore['Indicadore']['id'])); ?>
		</td>
                <td><?php echo $tipoIndicadores[h($carterasIndicadore['Indicadore']['tipo'])]; ?>&nbsp;</td>
                
                <td><?php (!empty($carterasIndicadore['Indicadore']['calculo']))?$calculo = $opcionesColumna[h($carterasIndicadore['Indicadore']['calculo'])]:$calculo = '-'; echo $calculo; ?>&nbsp;</td>
                
<!--		<td>
			<?php // echo $this->Html->link($carterasIndicadore['Cartera']['nombre'], array('controller' => 'carteras', 'action' => 'view', $carterasIndicadore['Cartera']['id'])); ?>
		</td>-->
		<!--<td><?php // echo h($carterasIndicadore['CarterasIndicadore']['created']); ?>&nbsp;</td>-->
		<!--<td><?php // echo h($carterasIndicadore['CarterasIndicadore']['modified']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php // echo $this->Html->link(__('View'), array('action' => 'view', $carterasIndicadore['CarterasIndicadore']['id'])); ?>
			<?php // echo $this->Html->link(__('EDITAR'), array('action' => 'edit', $carterasIndicadore['CarterasIndicadore']['id'])); ?>
			<?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), sprintf('delete/%s', $carterasIndicadore['CarterasIndicadore']['id']), array('escape' => false), __('Confirma que desea eliminar el indicador de recupero "%s" de la cartera de deudores "%s"?', $carterasIndicadore['Indicadore']['etiqueta'], $carterasIndicadore['Cartera']['nombre'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Pagina {:page} de {:pages}, mostrando {:current} registros de un total de {:count}.')
	));
	?>	</p>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>
		<li><?php // echo $this->Html->link(__('New Carteras Indicadore'), array('action' => 'add')); ?></li>
		<li><?php // echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
		<li><?php // echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
