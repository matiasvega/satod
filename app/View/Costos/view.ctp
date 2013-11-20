<div class="costos view">
<h2><?php echo __('Costo'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($costo['Costo']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Nombre'); ?></dt>
		<dd>
			<?php echo h($costo['Costo']['nombre']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Valor'); ?></dt>
		<dd>
			<?php echo h($costo['Costo']['valor']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Tipo'); ?></dt>
		<dd>
			<?php echo h($costo['Costo']['tipo']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($costo['Costo']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($costo['Costo']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Costos Id'); ?></dt>
		<dd>
			<?php echo h($costo['Costo']['costos_id']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Costo'), array('action' => 'edit', $costo['Costo']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Costo'), array('action' => 'delete', $costo['Costo']['id']), null, __('Are you sure you want to delete # %s?', $costo['Costo']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Costos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Costo'), array('action' => 'add')); ?> </li>
	</ul>
</div>
