<?php
//    dd($carteras);
?>
<div class="carteras index">
	<h2><?php echo __('Carteras'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
                        <th><?php echo $this->Paginator->sort('clientes_id', 'Cliente'); ?></th>
			<th><?php echo $this->Paginator->sort('nombre'); ?></th>
			<th><?php echo $this->Paginator->sort('estado'); ?></th>
			<th><?php echo $this->Paginator->sort('idAsignacionLogisis', 'id Asignacion Logisis'); ?></th>
                        <th><?php echo $this->Paginator->sort('comision', 'Comision (%)'); ?></th>
			
			<th class="actions"><?php //  echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($carteras as $cartera): ?>
	<tr>
		<td><?php echo h($cartera['Cartera']['id']); ?>&nbsp;</td>
                <td><?php echo h($cartera['Cliente']['nombre']); ?>&nbsp;</td>
		<td><?php echo h($cartera['Cartera']['nombre']); ?>&nbsp;</td>
		<td><?php echo $estados[h($cartera['Cartera']['estado'])]; ?>&nbsp;</td>
		<td><?php echo h($cartera['Cartera']['idAsignacionLogisis']); ?>&nbsp;</td>
                <td><?php echo h($cartera['Cartera']['comision']); ?>&nbsp;</td>
<!--		<td>
			<?php //echo $this->Html->link($cartera['Clientes']['id'], array('controller' => 'clientes', 'action' => 'view', $cartera['Clientes']['id'])); ?>
		</td>-->
		<td class="actions">
			<?php echo $this->Html->link($this->Html->image('gauge.png', array('alt' => 'Indicadores de recupero', 'title' => 'Indicadores de recupero')), array('controller' => 'carterasIndicadores','action' => 'indexCartera', $cartera['Cartera']['id']), array('escape' => false)); ?>
                        <?php echo $this->Html->link($this->Html->image('pagos.png', array('alt' => 'Pagos', 'title' => 'Pagos')), array('controller' => 'pagos','action' => 'indexCartera', $cartera['Cartera']['id']), array('escape' => false)); ?>
			<?php echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $cartera['Cartera']['id']), array('escape' => false)); ?>
			<?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), array('action' => 'delete', $cartera['Cartera']['id']), array('escape' => false), __('Confirma que desea eliminar los datos de la cartera de deudores %s?', $cartera['Cartera']['nombre'])); ?>
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
		<li><?php //echo $this->Html->link(__('New Cartera'), array('action' => 'add')); ?></li>
		<li><?php //echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
		<li><?php //echo $this->Html->link(__('New Clientes'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
		<li><?php //echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
		<li><?php //echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
	</ul>
</div>
-->