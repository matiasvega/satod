<div class="users index">
	<h2><?php echo __('Usuarios'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('username', 'Usuario'); ?></th>
			<th><?php echo $this->Paginator->sort('password', 'Contraseña'); ?></th>
			<th><?php echo $this->Paginator->sort('group_id', 'Grupo'); ?></th>
<!--			<th><?php // echo $this->Paginator->sort('created'); ?></th>
			<th><?php // echo $this->Paginator->sort('modified'); ?></th>-->
			<th class="actions"><?php // echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($users as $user): ?>
	<tr>
		<td><?php echo h($user['User']['id']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['username']); ?>&nbsp;</td>
		<td><?php echo h($user['User']['password']); ?>&nbsp;</td>
		<td><?php echo $grupos[h($user['User']['group_id'])]; ?>&nbsp;</td>
<!--		<td><?php // echo h($user['User']['created']); ?>&nbsp;</td>
		<td><?php // echo h($user['User']['modified']); ?>&nbsp;</td>-->
		<td class="actions">
			<?php // echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id'])); ?>
                        <?php echo $this->Html->link($this->Html->image('edit.png', array('alt' => 'Editar', 'title' => 'Editar')), array('action' => 'edit', $user['User']['id']), array('escape' => false)); ?>			
                    <?php echo $this->Form->postLink($this->Html->image('eliminar.png', array('alt' => 'Eliminar', 'title' => 'Eliminar')), array('action' => 'delete', $user['User']['id']), array('escape' => false), __('Confirma que desea eliminar los datos del usuario %s?', $user['User']['username'])); ?>
                    
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
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<!--
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>
		<li><?php //echo $this->Html->link(__('New User'), array('action' => 'add')); ?></li>
	</ul>
</div>
-->