<?php
//    d($costosEstrategias);
?>
<div class="costosEstrategias index">
	<h2><?php echo __('Costos Estrategias'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('costos_id'); ?></th>
			<th><?php echo $this->Paginator->sort('estrategias_id'); ?></th>
			<th><?php echo $this->Paginator->sort('multiplicador'); ?></th>
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($costosEstrategias as $costosEstrategia): ?>
	<tr>
		<td><?php echo h($costosEstrategia['CostosEstrategia']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($costosEstrategia['Costos']['nombre'], array('controller' => 'costos', 'action' => 'view', $costosEstrategia['Costos']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($costosEstrategia['Estrategias']['nombre'], array('controller' => 'estrategias', 'action' => 'view', $costosEstrategia['Estrategias']['id'])); ?>
		</td>
                
		<td><?php echo h($costosEstrategia['CostosEstrategia']['multiplicador']); ?>&nbsp;</td>
<!--		<td><?php // echo h($costosEstrategia['CostosEstrategia']['created']); ?>&nbsp;</td>
		<td><?php // echo h($costosEstrategia['CostosEstrategia']['modified']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $costosEstrategia['CostosEstrategia']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $costosEstrategia['CostosEstrategia']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $costosEstrategia['CostosEstrategia']['id']), null, __('Are you sure you want to delete # %s?', $costosEstrategia['CostosEstrategia']['id'])); ?>
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
		<li><?php // echo $this->Html->link(__('New Costos Estrategia'), array('action' => 'add')); ?></li>
		<li><?php // echo $this->Html->link(__('List Costos'), array('controller' => 'costos', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Costos'), array('controller' => 'costos', 'action' => 'add')); ?> </li>
		<li><?php // echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
