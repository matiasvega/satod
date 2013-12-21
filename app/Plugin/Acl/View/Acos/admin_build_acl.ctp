<?php

echo $this->element('design/header');
?>

<?php

echo $this->element('Acos/links');
?>

<?php

if ($run) {
    if (count($logs) > 0) {
        echo '<p>';
        echo __d('acl', 'Las siguientes acciones ACOs han sido creadas');
        echo '<p>';
        echo $this->Html->nestedList($logs);
    } else {
        echo '<p>';
        echo __d('acl', 'No existen nuevas acciones ACOs para crear');
        echo '</p>';
    }
} else {
    echo '<p>';
    echo __d('acl', 'Esta pagina permite reconstruir las acciones obsoletas que existan.');
    echo '</p>';

    echo '<p>&nbsp;</p>';

    if (count($missing_aco_nodes) > 0) {
        echo '<h3>' . __d('acl', 'Missing ACOs') . '</h3>';

        echo '<p>';
        echo $this->Html->nestedList($missing_aco_nodes);
        echo '</p>';

        echo '<p>&nbsp;</p>';

        echo '<p>';
        echo __d('acl', 'Esta opcion no eliminara las acciones ACOs existentes');
        echo '</p>';

        echo '<p>';
        echo $this->Html->link($this->Html->image('/acl/img/design/add.png') . ' ' . __d('acl', 'Build'), '/admin/acl/acos/build_acl/run', array('escape' => false));
        echo '</p>';
    } else {
        echo '<p style="font-style:italic;">';
        echo $this->Html->image('/acl/img/design/tick.png') . ' ' . __d('acl', 'No existen ACOs para crear');
        echo '</p>';
    }
}

echo $this->element('design/footer');
?>