<?php
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
<?php // dd($indicadores); ?>
<div class="indicadores index">
	<h2><?php echo __('Indicadores de Recupero'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('etiqueta'); ?></th>
                        <th><?php echo $this->Paginator->sort('tipo'); ?></th>
                        <th><?php echo $this->Paginator->sort('calculo'); ?></th>
                        <th><?php echo $this->Paginator->sort('grafica'); ?></th>
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($indicadores as $indicadore): ?>
	<tr>
		<td><?php echo h($indicadore['Indicadore']['id']); ?>&nbsp;</td>
		<td><?php echo h($indicadore['Indicadore']['etiqueta']); ?>&nbsp;</td>
                <td><?php echo $tipoIndicadores[h($indicadore['Indicadore']['tipo'])]; ?>&nbsp;</td>
                <td><?php (!empty($indicadore['Indicadore']['calculo']))?$calculo = $opcionesColumna[h($indicadore['Indicadore']['calculo'])]:$calculo = '-'; echo $calculo; ?>&nbsp;</td>
                <td><?php (!empty($indicadore['Indicadore']['grafica']))?$grafica = $opcionesGrafica[h($indicadore['Indicadore']['grafica'])]:$grafica = '-'; echo $grafica; ?>&nbsp;</td>
<!--		<td><?php // echo h($indicadore['Indicadore']['created']); ?>&nbsp;</td>
		<td><?php // echo h($indicadore['Indicadore']['modified']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('valores.png', array('alt' => 'Valores', 'title' => 'Valores')), array('controller' => 'indicadores_valores' ,'action' => 'indexIndicador', $indicadore['Indicadore']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $indicadore['Indicadore']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), array('action' => 'delete', $indicadore['Indicadore']['id']), array('escape' => false), __('Confirma que desea eliminar los datos del indicador %s?', $indicadore['Indicadore']['etiqueta'])); ?>
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
		<li><?php // echo $this->Html->link(__('New Indicadore'), array('action' => 'add')); ?></li>
		<li><?php // echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
