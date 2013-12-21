<?php
echo $this->element('design/header');
?>

<?php

echo $this->element('Acos/links');
?>

<?php

if ($run) {
    echo '<h3>' . __d('acl', 'Nuevas ACOs') . '</h3>';

    if (count($create_logs) > 0) {
//        echo '<p>';
//        echo __d('acl', 'The following actions ACOs have been created');
//        echo '<p>';
        echo $this->Html->nestedList($create_logs);
    } else {
        echo '<p>';
        echo __d('acl', 'No hay nuevas acciones ACOs para crear.');
        echo '</p>';
    }

    echo '<h3>' . __d('acl', 'ACOs Obsoletas') . '</h3>';

    if (count($prune_logs) > 0) {
//        echo '<p>';
//        echo __d('acl', 'The following actions ACOs have been deleted');
//        echo '<p>';
        echo $this->Html->nestedList($prune_logs);
    } else {
        echo '<p>';
        echo __d('acl', 'No hay acciones ACO para eliminar');
        echo '</p>';
    }
} else {
    echo '<p>';
    echo __d('acl', 'Esta pagina permite sincronizar los controladores y acciones existentes con la base de datos de ACO.');
    echo '</p>';

    echo '<p>&nbsp;</p>';

    $has_aco_to_sync = false;

    if (count($missing_aco_nodes) > 0) {
        echo '<h3>' . __d('acl', 'ACOs obsoletos') . '</h3>';

        echo '<p>';
        echo $this->Html->nestedList($missing_aco_nodes);
        echo '</p>';

        $has_aco_to_sync = true;
    }

    if (count($nodes_to_prune) > 0) {
        echo '<h3>' . __d('acl', 'ACO obsoletos') . '</h3>';

        echo '<p>';
        echo $this->Html->nestedList($nodes_to_prune);
        echo '</p>';

        $has_aco_to_sync = true;
    }

    if ($has_aco_to_sync) {
        echo '<p>&nbsp;</p>';

        echo '<p>';
        echo __d('acl', 'Esta opcion no cambiara ni eliminara privilegios para las acciones existentes ACOs.');
        echo '</p>';

        echo '<p>';
        echo $this->Html->link($this->Html->image('/acl/img/design/sync.png') . ' ' . __d('acl', 'Sincronizar'), '/admin/acl/acos/synchronize/run', array('escape' => false));
        echo '</p>';
    } else {
        echo '<p style="font-style:italic;">';
        echo $this->Html->image('/acl/img/design/tick.png') . ' ' . __d('acl', 'La base de datos de ACOs esta sincronizada');
        echo '</p>';
    }
}

echo $this->element('design/footer');
?>