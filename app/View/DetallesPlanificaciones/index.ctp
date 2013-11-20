<div class="detallesPlanificaciones index">
	<h2><?php echo __('Detalles Planificaciones'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_inicio'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha_fin'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('estrategias_id'); ?></th>
			<th><?php echo $this->Paginator->sort('carteras_indicadores_id'); ?></th>
			<th><?php echo $this->Paginator->sort('planificaciones_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($detallesPlanificaciones as $detallesPlanificacione): ?>
	<tr>
		<td><?php echo h($detallesPlanificacione['DetallesPlanificacione']['id']); ?>&nbsp;</td>
		<td><?php echo h($detallesPlanificacione['DetallesPlanificacione']['fecha_inicio']); ?>&nbsp;</td>
		<td><?php echo h($detallesPlanificacione['DetallesPlanificacione']['fecha_fin']); ?>&nbsp;</td>
		<td><?php echo h($detallesPlanificacione['DetallesPlanificacione']['created']); ?>&nbsp;</td>
		<td><?php echo h($detallesPlanificacione['DetallesPlanificacione']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($detallesPlanificacione['Estrategias']['id'], array('controller' => 'estrategias', 'action' => 'view', $detallesPlanificacione['Estrategias']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($detallesPlanificacione['CarterasIndicadores']['id'], array('controller' => 'carteras_indicadores', 'action' => 'view', $detallesPlanificacione['CarterasIndicadores']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($detallesPlanificacione['Planificaciones']['id'], array('controller' => 'planificaciones', 'action' => 'view', $detallesPlanificacione['Planificaciones']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $detallesPlanificacione['DetallesPlanificacione']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $detallesPlanificacione['DetallesPlanificacione']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $detallesPlanificacione['DetallesPlanificacione']['id']), null, __('Are you sure you want to delete # %s?', $detallesPlanificacione['DetallesPlanificacione']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
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
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Detalles Planificacione'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Estrategias'), array('controller' => 'estrategias', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Estrategias'), array('controller' => 'estrategias', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras Indicadores'), array('controller' => 'carteras_indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras Indicadores'), array('controller' => 'carteras_indicadores', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Planificaciones'), array('controller' => 'planificaciones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Planificaciones'), array('controller' => 'planificaciones', 'action' => 'add')); ?> </li>
	</ul>
</div>
