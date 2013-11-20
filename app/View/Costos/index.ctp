<div class="costos index">
	<h2><?php echo __('Costos de Gestion'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
                        <th><?php echo $this->Paginator->sort('tipo'); ?></th>
			<th><?php echo $this->Paginator->sort('valor'); ?></th>
			<th><?php echo $this->Paginator->sort('parent_id', 'Grupo'); ?></th>
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($costos as $costo): ?>
	<tr>
		<td><?php echo h($costo['Costo']['id']); ?>&nbsp;</td>
		<td><?php echo h($costo['Costo']['nombre']); ?>&nbsp;</td>
                <td><?php echo $tipoCostos[h($costo['Costo']['tipo'])]; ?>&nbsp;</td>
		<td><?php echo h($costo['Costo']['valor']); ?>&nbsp;</td>
		<td><?php echo h((isset($listaCostos[$costo['Costo']['parent_id']])?$listaCostos[$costo['Costo']['parent_id']]:'-')); ?>&nbsp;</td>                
<!--		<td><?php // echo h($costo['Costo']['created']); ?>&nbsp;</td>
		<td><?php // echo h($costo['Costo']['modified']); ?>&nbsp;</td>-->
		
		<td class="actions">
			<?php // echo $this->Html->link(__('VER'), array('action' => 'view', $costo['Costo']['id'])); ?>
			<?php echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $costo['Costo']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), array('action' => 'delete', $costo['Costo']['id']), array('escape' => false), __('Confirma que desea eliminar los datos de costo %s?', $costo['Costo']['nombre'])); ?>                                        
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
<!--
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__('New Costo'), array('action' => 'add')); ?></li>
	</ul>
</div>
-->