<div class="planificaciones view">
<h2><?php echo __('Planificacione'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($planificacione['Planificacione']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Inicio'); ?></dt>
		<dd>
			<?php echo h($planificacione['Planificacione']['fecha_inicio']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Fecha Fin'); ?></dt>
		<dd>
			<?php echo h($planificacione['Planificacione']['fecha_fin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($planificacione['Planificacione']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($planificacione['Planificacione']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Carteras'); ?></dt>
		<dd>
			<?php echo $this->Html->link($planificacione['Carteras']['id'], array('controller' => 'carteras', 'action' => 'view', $planificacione['Carteras']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Planificacione'), array('action' => 'edit', $planificacione['Planificacione']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Planificacione'), array('action' => 'delete', $planificacione['Planificacione']['id']), null, __('Are you sure you want to delete # %s?', $planificacione['Planificacione']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Planificaciones'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Planificacione'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Carteras'), array('controller' => 'carteras', 'action' => 'add')); ?> </li>
	</ul>
</div>
