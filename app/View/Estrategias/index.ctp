<div class="estrategias index">
	<h2><?php echo __('Estrategias'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('descripcion'); ?></th>
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($estrategias as $estrategia): ?>
	<tr>
		<td><?php echo h($estrategia['Estrategia']['id']); ?>&nbsp;</td>
		<td><?php echo h($estrategia['Estrategia']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($estrategia['Estrategia']['descripcion']); ?>&nbsp;</td>
<!--		<td><?php // echo h($estrategia['Estrategia']['created']); ?>&nbsp;</td>
		<td><?php // echo h($estrategia['Estrategia']['modified']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('costo.png', array('alt' => 'Costos', 'title' => 'Costos')), 
                                                                        array(
                                                                            'controller' => 'costosEstrategias', 
                                                                            'action' => 'indexEstrategia', 
                                                                            $estrategia['Estrategia']['id']
                                                                        ),
                                                                        array('escape' => false)
                                                    ); ?>
			<?php echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $estrategia['Estrategia']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), array('action' => 'delete', $estrategia['Estrategia']['id']), array('escape' => false), __('Confirma que desea eliminar los datos de la estrategia %s?', $estrategia['Estrategia']['nombre'])); ?>
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
		<li><?php //echo $this->Html->link(__('New Estrategia'), array('action' => 'add')); ?></li>
	</ul>
</div>
-->