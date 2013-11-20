<div class="pagos index">
	<h2><?php echo sprintf('Pagos para cartera: %s', $pagos[0]['Cartera']['nombre']); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<!--<th><?php // echo $this->Paginator->sort('carteras_id', 'Cartera'); ?></th>-->
			<th><?php echo $this->Paginator->sort('monto'); ?></th>
			<th><?php echo $this->Paginator->sort('fecha'); ?></th>
			<th><?php echo $this->Paginator->sort('idImportacion', 'Id importacion'); ?></th>
			<!--<th><?php // echo $this->Paginator->sort('created'); ?></th>-->
			<!--<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<!--<th class="actions"><?php // echo __('Actions'); ?></th>-->
	</tr>
	<?php foreach ($pagos as $pago): ?>
        <?php // d($pago); ?>
	<tr>
		<td><?php echo h($pago['Pago']['id']); ?>&nbsp;</td>
<!--		<td>
			<?php // echo $this->Html->link($pago['Carteras']['id'], array('controller' => 'carteras', 'action' => 'view', $pago['Carteras']['id'])); ?>
                    <?php // echo $pago['Cartera']['nombre']; ?>
		</td>-->
		<td><?php echo h($pago['Pago']['monto']); ?>&nbsp;</td>
		<td><?php echo fecha(h($pago['Pago']['fecha'])); ?>&nbsp;</td>
		<td><?php echo h($pago['Pago']['idImportacion']); ?>&nbsp;</td>
		<!--<td><?php // echo h($pago['Pago']['created']); ?>&nbsp;</td>-->
		<!--<td><?php // echo h($pago['Pago']['modified']); ?>&nbsp;</td>-->
<!--		<td class="actions">
			<?php // echo $this->Html->link(__('View'), array('action' => 'view', $pago['Pago']['id'])); ?>
			<?php // echo $this->Html->link(__('Edit'), array('action' => 'edit', $pago['Pago']['id'])); ?>
			<?php // echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $pago['Pago']['id']), null, __('Are you sure you want to delete # %s?', $pago['Pago']['id'])); ?>
		</td>-->
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
		<li><?php // echo $this->Html->link(__('New Pago'), array('action' => 'add')); ?></li>
		<li><?php // echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php // echo $this->Html->link(__('New Carteras'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>-->
