<?php
//    d($costosEstrategias);
?>
<div class="costosEstrategias index">
	<h2><?php echo sprintf('Costos de Estrategia %s', $costosEstrategias[0]['Estrategias']['nombre']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('costos_id'); ?></th>
			<!--<th><?php // echo $this->Paginator->sort('estrategias_id'); ?></th>-->
			<th><?php echo $this->Paginator->sort('multiplicador'); ?></th>
                        <th><?php echo $this->Paginator->sort('costo_total'); ?></th>
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php 
            $costoEstrategia = array();
            foreach ($costosEstrategias as $k => $costosEstrategia): 
        ?>
	<tr>
		<td><?php echo h($costosEstrategia['CostosEstrategia']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $costosEstrategia['Costos']['nombre']; ?>
		</td>
<!--		<td>
			<?php // echo $this->Html->link($costosEstrategia['Estrategias']['nombre'], array('controller' => 'estrategias', 'action' => 'view', $costosEstrategia['Estrategias']['id'])); ?>
		</td>-->
                
		<td><?php ($costosEstrategia['CostosEstrategia']['multiplicador'] == 0)?$multiplicador='-':$multiplicador=h($costosEstrategia['CostosEstrategia']['multiplicador']); echo $multiplicador; ?>&nbsp;</td>
                                                
                <td><?php ($costosEstrategia['CostosEstrategia']['multiplicador'] == 0)?$costo=$costosEstrategias[$k]['Costos']['valor']:$costo=h($costosEstrategia['CostosEstrategia']['multiplicador']*$costosEstrategias[$k]['Costos']['valor']); echo $costo; $costoEstrategia[] = $costo;?>&nbsp;</td>
                
<!--		<td><?php // echo h($costosEstrategia['CostosEstrategia']['created']); ?>&nbsp;</td>
		<td><?php // echo h($costosEstrategia['CostosEstrategia']['modified']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php // echo $this->Html->link(__('View'), array('action' => 'view', $costosEstrategia['CostosEstrategia']['id'])); ?>
		
        	<?php 
                    if ($costosEstrategia['CostosEstrategia']['multiplicador'] > 0) {
                        echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $costosEstrategia['CostosEstrategia']['id'], $costosEstrategias[0]['Estrategias']['id']), array('escape' => false));    
                    } else {
                        echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), '#', array('escape' => false));
                    }
                ?>
                    
			<?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), sprintf('delete/%s/%s', $costosEstrategia['CostosEstrategia']['id'], $costosEstrategias[0]['Estrategias']['id']), array('escape' => false), __('Confirma que desea eliminar los datos del costo %s?', $costosEstrategia['Costos']['nombre'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
        <tr>
			<th colspan="3"> TOTAL </th>
			<th colspan="2"><?php echo nro(array_sum($costoEstrategia)); ?></th>
	</tr>
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
		<li><?php // echo $this->Html->link(__('New Costos Estrategia'), array('action' => 'add')); ?></li>
		<li><?php // echo $this->Html->link(__('List Costos'), array('controller' => 'costos', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Costos'), array('controller' => 'costos', 'action' => 'add')); ?> </li>
		<li><?php // echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
