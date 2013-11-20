<div class="carteras view">
    <h2><?php echo __('Cartera'); ?></h2>
    <dl>
        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($cartera['Cartera']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Nombre'); ?></dt>
        <dd>
            <?php echo h($cartera['Cartera']['nombre']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Estado'); ?></dt>
        <dd>
            <?php echo h($cartera['Cartera']['estado']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('IdAsignacionLogisis'); ?></dt>
        <dd>
            <?php echo h($cartera['Cartera']['idAsignacionLogisis']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Clientes'); ?></dt>
        <dd>
            <?php echo $this->Html->link($cartera['Clientes']['id'], array('controller' => 'clientes', 'action' => 'view', $cartera['Clientes']['id'])); ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('Edit Cartera'), array('action' => 'edit', $cartera['Cartera']['id'])); ?> </li>
        <li><?php echo $this->Form->postLink(__('Delete Cartera'), array('action' => 'delete', $cartera['Cartera']['id']), null, __('Are you sure you want to delete # %s?', $cartera['Cartera']['id'])); ?> </li>
        <li><?php echo $this->Html->link(__('List Carteras'), array('action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Cartera'), array('action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Clientes'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
    </ul>
</div>
<div class="related">
    <h3><?php echo __('Related Indicadores'); ?></h3>
    <?php if (!empty($cartera['Indicadore'])): ?>
    <table cellpadding = "0" cellspacing = "0">
        <tr>
            <th><?php echo __('Id'); ?></th>
            <th><?php echo __('Etiqueta'); ?></th>
            <th><?php echo __('Created'); ?></th>
            <th><?php echo __('Modified'); ?></th>
            <th class="actions"><?php echo __('Actions'); ?></th>
        </tr>
        <?php foreach ($cartera['Indicadore'] as $indicadore): ?>
        <tr>
            <td><?php echo $indicadore['id']; ?></td>
            <td><?php echo $indicadore['etiqueta']; ?></td>
            <td><?php echo $indicadore['created']; ?></td>
            <td><?php echo $indicadore['modified']; ?></td>
            <td class="actions">
                <?php echo $this->Html->link(__('View'), array('controller' => 'indicadores', 'action' => 'view', $indicadore['id'])); ?>
                <?php echo $this->Html->link(__('Edit'), array('controller' => 'indicadores', 'action' => 'edit', $indicadore['id'])); ?>
                <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'indicadores', 'action' => 'delete', $indicadore['id']), null, __('Are you sure you want to delete # %s?', $indicadore['id'])); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <?php endif; ?>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
        </ul>
    </div>
</div>
