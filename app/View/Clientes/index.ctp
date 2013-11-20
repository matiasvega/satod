<?php $this->Html->addCrumb('Clientes', '/clientes'); ?>
<div class="clientes index">
	<h2><?php echo __('Clientes'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('direccion'); ?></th>
			<th><?php echo $this->Paginator->sort('telefono'); ?></th>
			<th><?php echo $this->Paginator->sort('email'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th><?php echo $this->Paginator->sort('id Logisis'); ?></th>
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($clientes as $cliente): ?>
	<tr>
		<td><?php echo h($cliente['Cliente']['id']); ?>&nbsp;</td>
		<td><?php echo h($cliente['Cliente']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($cliente['Cliente']['direccion']); ?>&nbsp;</td>
		<td><?php echo h($cliente['Cliente']['telefono']); ?>&nbsp;</td>
		<td><?php echo h($cliente['Cliente']['email']); ?>&nbsp;</td>
		<td><?php echo h($estados[$cliente['Cliente']['estado']]); ?>&nbsp;</td>
		<td><?php echo h($cliente['Cliente']['idLogisis']); ?>&nbsp;</td>
<!--		<td><?php // echo h($cliente['Cliente']['created']); ?>&nbsp;</td>
		<td><?php // echo h($cliente['Cliente']['modified']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php // echo $this->Html->link(__('VER'), array('action' => 'view', $cliente['Cliente']['id'])); ?>
			<?php echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $cliente['Cliente']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), array('action' => 'delete', $cliente['Cliente']['id']), array('escape' => false), __('Confirma que desea eliminar los datos del cliente %s?', $cliente['Cliente']['nombre'])); ?>
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
		<li><?php //echo $this->Html->link(__('New Cliente'), array('action' => 'add')); ?></li>
	</ul>
</div>
-->