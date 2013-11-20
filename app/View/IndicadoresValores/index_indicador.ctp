<?php
//    d($indicadoresValores);
$opcionesColumna = array(
                                'sum' => 'SUMA',
                                'avg' => 'PROMEDIO',
                                'group' => 'GRUPO'
                            );
?>
<div class="indicadoresValores index">
	<h2><?php echo sprintf('Valores de Indicador de Recupero: %s', $indicadoresValores[0]['Indicadore']['etiqueta']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('valor'); ?></th>
			<th><?php echo $this->Paginator->sort('valor_ponderado', ($indicadoresValores[0]['Indicadore']['tipo'] == 'G')? 'Valor Ponderado':'Valor Calculado'); ?></th>
			<!--<th><?php // echo $this->Paginator->sort('valor_calculo'); ?></th>-->
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>
			<th><?php // echo $this->Paginator->sort('indicadores_id'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($indicadoresValores as $indicadoresValore): ?>
	<tr>
		<td><?php echo h($indicadoresValore['IndicadoresValore']['id']); ?>&nbsp;</td>
		<td><?php ($indicadoresValores[0]['Indicadore']['tipo'] == 'P' && $indicadoresValores[0]['Indicadore']['calculo'] != 'group')?$valor=$opcionesColumna[h($indicadoresValore['IndicadoresValore']['valor'])]:$valor=h($indicadoresValore['IndicadoresValore']['valor']); echo $valor; ?>&nbsp;</td>
		<td><?php echo nro(h($indicadoresValore['IndicadoresValore']['valor_ponderado'])); ?>&nbsp;</td>
		<!--<td><?php // echo h($indicadoresValore['IndicadoresValore']['valor_calculo']); ?>&nbsp;</td>-->
<!--		<td><?php // echo h($indicadoresValore['IndicadoresValore']['created']); ?>&nbsp;</td>
		<td><?php // echo h($indicadoresValore['IndicadoresValore']['modified']); ?>&nbsp;</td>-->
<!--		<td>
			<?php // echo $this->Html->link($indicadoresValore['Indicadore']['etiqueta'], array('controller' => 'indicadores', 'action' => 'view', $indicadoresValore['Indicadore']['id'])); ?>
		</td>-->
		<td class="actions">
			<?php // echo $this->Html->link(__('View'), array('action' => 'view', $indicadoresValore['IndicadoresValore']['id'])); ?>
			<?php 
                            if ($indicadoresValores[0]['Indicadore']['tipo'] == 'G') {
                                echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), sprintf('edit/%s/%s', $indicadoresValore['IndicadoresValore']['id'], $indicadoresValores[0]['Indicadore']['id']), array('escape' => false)); 
//                                echo $indicadoresValore['IndicadoresValore']['id'];
                                echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), sprintf('delete/%s/%s', $indicadoresValore['IndicadoresValore']['id'], $indicadoresValores[0]['Indicadore']['id']), array('escape' => false), __('Confirma que desea eliminar el valor %s?', $indicadoresValore['IndicadoresValore']['valor']));                
                            }
                        

                        ?>
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
		echo $this->Paginator->prev('< ' . __('anterior'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('siguiente') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<!--<div class="actions">
	<h3><?php // echo __('Actions'); ?></h3>
	<ul>
		<li><?php // echo $this->Html->link(__('New Indicadores Valore'), array('action' => 'add')); ?></li>
		<li><?php // echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
