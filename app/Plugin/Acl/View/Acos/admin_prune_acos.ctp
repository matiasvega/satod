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
        echo __d('acl', 'Las siguientes acciones ACOs han sido reducidas');
        echo '<p>';
        echo $this->Html->nestedList($logs);
    } else {
        echo '<p>';
        echo __d('acl', 'No hay acciones ACOs para reducir');
        echo '</p>';
    }
} else {
    echo '<p>';
    echo __d('acl', 'Esta pagina permite reducir ACOs obsoletos.');
    echo '</p>';

    echo '<p>&nbsp;</p>';

    if (count($nodes_to_prune) > 0) {
        echo '<h3>' . __d('acl', 'ACOs obsoletos') . '</h3>';

        echo '<p>';
        echo $this->Html->nestedList($nodes_to_prune);
        echo '</p>';

        echo '<p>&nbsp;</p>';

        echo '<p>';
        echo __d('acl', 'Esta opcion no cambiara ni eliminara privilegios para acciones ACOs que no esten obssoletas.');
        echo '</p>';

        echo '<p>';
        echo $this->Html->link($this->Html->image('/acl/img/design/clean.png') . ' ' . __d('acl', 'Reducir'), '/admin/acl/acos/prune_acos/run', array('escape' => false));
        echo '</p>';
    } else {
        echo '<p style="font-style:italic;">';
        echo $this->Html->image('/acl/img/design/tick.png') . ' ' . __d('acl', 'No hay ACOs para eliminar');
        echo '</p>';
    }
}

echo $this->element('design/footer');
?>