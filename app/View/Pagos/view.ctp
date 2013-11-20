<div class="pagos view">
<h2><?php echo __('Pago'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pago['Pago']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Carteras'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pago['Carteras']['id'], array('controller' => 'carteras', 'action' => 'view', $pago['Carteras']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Monto'); ?></dt>
		<dd>
			<?php echo h($pago['Pago']['monto']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha'); ?></dt>
		<dd>
			<?php echo h($pago['Pago']['fecha']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('IdImportacion'); ?></dt>
		<dd>
			<?php echo h($pago['Pago']['idImportacion']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($pago['Pago']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($pago['Pago']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Pago'), array('action' => 'edit', $pago['Pago']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Pago'), array('action' => 'delete', $pago['Pago']['id']), null, __('Are you sure you want to delete # %s?', $pago['Pago']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Pagos'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Pago'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
