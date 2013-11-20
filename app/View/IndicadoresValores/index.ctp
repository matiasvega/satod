<div class="indicadoresValores index">
	<h2><?php echo __('Indicadores Valores'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('valor'); ?></th>
			<th><?php echo $this->Paginator->sort('valor_ponderado'); ?></th>
			<th><?php echo $this->Paginator->sort('valor_calculo'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('indicadores_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($indicadoresValores as $indicadoresValore): ?>
	<tr>
		<td><?php echo h($indicadoresValore['IndicadoresValore']['id']); ?>&nbsp;</td>
		<td><?php echo h($indicadoresValore['IndicadoresValore']['valor']); ?>&nbsp;</td>
		<td><?php echo h($indicadoresValore['IndicadoresValore']['valor_ponderado']); ?>&nbsp;</td>
		<td><?php echo h($indicadoresValore['IndicadoresValore']['valor_calculo']); ?>&nbsp;</td>
		<td><?php echo h($indicadoresValore['IndicadoresValore']['created']); ?>&nbsp;</td>
		<td><?php echo h($indicadoresValore['IndicadoresValore']['modified']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($indicadoresValore['Indicadore']['etiqueta'], array('controller' => 'indicadores', 'action' => 'view', $indicadoresValore['Indicadore']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $indicadoresValore['IndicadoresValore']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $indicadoresValore['IndicadoresValore']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $indicadoresValore['IndicadoresValore']['id']), null, __('Are you sure you want to delete # %s?', $indicadoresValore['IndicadoresValore']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Indicadores Valore'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
	</ul>
</div>
