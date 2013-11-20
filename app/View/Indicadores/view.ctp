<div class="indicadores view">
<h2><?php echo __('Indicadore'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($indicadore['Indicadore']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Etiqueta'); ?></dt>
		<dd>
			<?php echo h($indicadore['Indicadore']['etiqueta']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($indicadore['Indicadore']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($indicadore['Indicadore']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Indicadore'), array('action' => 'edit', $indicadore['Indicadore']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Indicadore'), array('action' => 'delete', $indicadore['Indicadore']['id']), null, __('Are you sure you want to delete # %s?', $indicadore['Indicadore']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Indicadores'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Indicadore'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Carteras'); ?></h3>
	<?php if (!empty($indicadore['Cartera'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Nombre'); ?></th>
		<th><?php echo __('Estado'); ?></th>
		<th><?php echo __('IdAsignacionLogisis'); ?></th>
		<th><?php echo __('Clientes Id'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php foreach ($indicadore['Cartera'] as $cartera): ?>
		<tr>
			<td><?php echo $cartera['id']; ?></td>
			<td><?php echo $cartera['nombre']; ?></td>
			<td><?php echo $cartera['estado']; ?></td>
			<td><?php echo $cartera['idAsignacionLogisis']; ?></td>
			<td><?php echo $cartera['clientes_id']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'carteras', 'action' => 'view', $cartera['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'carteras', 'action' => 'edit', $cartera['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'carteras', 'action' => 'delete', $cartera['id']), null, __('Are you sure you want to delete # %s?', $cartera['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Cartera'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
