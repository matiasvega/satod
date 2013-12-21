<?php

echo $this->element('design/header');
?>

<?php

echo $this->element('Acos/links');
?>

<?php

echo '<p>';
echo __d('acl', 'Esta pagina permite eliminar todas las acciones ACOs.');
echo '</p>';

echo '<p>&nbsp;</p>';

if ($actions_exist) {
    echo '<p>';
    echo __d('acl', 'Esta opcion eliminara todas las acciones ACOs existentes y sus privilegios asociados.');
    echo '</p>';

    echo '<p>';
    echo $this->Html->link($this->Html->image('/acl/img/design/cross.png') . ' ' . __d('acl', 'Eliminar ACOs'), '/admin/acl/acos/empty_acos/run', array('confirm' => __d('acl', 'Estas seguro que deseas eliminar todas las ACOs existentes?'), 'escape' => false));
    echo '</p>';
} else {
    echo '<p style="font-style:italic;">';
    echo __d('acl', 'No hay ACOs para eliminar');
    echo '</p>';
}

echo $this->element('design/footer');
?>