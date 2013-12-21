<div id="acos_link" class="acl_links">
<?php
$selected = isset($selected) ? $selected : $this->params['action'];

$links = array();
$links[] = $this->Html->link(__d('acl', 'Sincronizar acciones ACOs'), '/admin/acl/acos/synchronize', array(array('confirm' => __d('acl', 'Estas seguro ?')), 'class' => ($selected == 'admin_synchronize' ) ? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Eliminar acciones ACOs'),       '/admin/acl/acos/empty_acos',  array(array('confirm' => __d('acl', 'Estas seguro ?')), 'class' => ($selected == 'admin_empty_acos' )  ? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Construir acciones ACOs'),       '/admin/acl/acos/build_acl',                                                     array('class' => ($selected == 'admin_build_acl' )   ? 'selected' : null));
$links[] = $this->Html->link(__d('acl', 'Purgar acciones ACOs'),       '/admin/acl/acos/prune_acos',  array(array('confirm' => __d('acl', 'Estas seguro ?')), 'class' => ($selected == 'admin_prune_acos' )  ? 'selected' : null));


echo $this->Html->nestedList($links, array('class' => 'acl_links'));
?>
</div>