<script type="text/javascript">
    
    $(document).ready(function(treeData) {
        
        var treeData = <?php echo $costosJson; ?>;
	$(function(){

		// --- Initialize sample trees
		$("#tree").dynatree({
                    checkbox: true,
                    selectMode: 3,
                    children: treeData,
                    keyboard: false,
                    fx:{ height: "toggle", duration: 200 },
                    onSelect: function(select, node) {
                      // Get a list of all selected nodes, and convert to a key array:
                      var selKeys = $.map(node.tree.getSelectedNodes(), function(node){
                        return node.data.key;
                      });
                      //$("#echoSelection3").text(selKeys.join(", "));
                      $("#costosSeleccionados").val(selKeys.join(", "));

                      // Get a list of all selected TOP nodes
                      var selRootNodes = node.tree.getSelectedNodes(true);
                      // ... and convert to a key array:
                      var selRootKeys = $.map(selRootNodes, function(node){
                        return node.data.key;
                      });
                      $("#echoSelectionRootKeys3").text(selRootKeys.join(", "));
                      $("#echoSelectionRoots3").text(selRootNodes.join(", "));
                    },
                    onDblClick: function(node, event) {
                      node.toggleSelect();
                    },
                    onKeydown: function(node, event) {
                      if( event.which == 32 ) {
                        node.toggleSelect();
                        return false;
                      }
                    },
                    // The following options are only required, if we have more than one tree on one page:
              //        initId: "treeData",
                    cookieId: "dynatree-Cb3",
                    idPrefix: "dynatree-Cb3-"
		});		
	});
        $('form').h5Validate();                                
        
    });
</script>

<?php

$data = $this->Js->get('#EstrategiaAddForm')->serializeForm(array('isForm' => true, 'inline' => true));

$this->Js->get('#EstrategiaAddForm')->event(
        'submit', sprintf("$(function() {
                        var n = $('.dynatree-selected').length;
                        var error = false;
                        if (n == 0) {
                            error = true;
                            var opts = {
                                    cornerclass: \"\",
                                    width: \"30%%\",
                                    styling: 'jqueryui',
                                    animation: 'show',
                                    title: \" ERROR \",
                                    type: \"error\",
                                };
                            opts.text = 'Debes seleccionar al menos un costo de gestion que aplique a la estrategia.';
                            $.pnotify(opts);                             
                        } else {                            
                            var errorMultiplicador = false;
                            var costosSeleccionados = $('#costosSeleccionados').val().split(',');
                            
                            var costosVariables = '%s';
                            var acostosVariables = costosVariables.split(',');

                            for (i=0;i<costosSeleccionados.length;i++) {
                                console.log('#multiplicador_'+costosSeleccionados[i].trim()+'x');
                                if( jQuery.inArray(costosSeleccionados[i].trim(), acostosVariables) != -1) {
                                    if ($('#multiplicador_'+costosSeleccionados[i].trim()).val() == '') {                                    
                                        $('#multiplicador_'+costosSeleccionados[i].trim()).addClass(\"errorMultiplicador\");
                                        errorMultiplicador = true;
                                        error = true;
                                    } else {
                                        $('#multiplicador_'+costosSeleccionados[i].trim()).removeClass(\"errorMultiplicador\");
                                    }  
                                }
                            }
                        }
                        console.log(error);
                        if (error === false) {
                            $(form).submit();
                        }
                    });
            ", implode(",", $costosVariables))
);

?>


<div class="estrategias form">
<?php echo $this->Form->create('Estrategia'); ?>
	<fieldset>
		<legend><?php echo __('Registrar Estrategia'); ?></legend>
	<?php
		echo $this->Form->input('nombre', array(
                                            'required' => true,
                                            'placeholder' => 'Ingresa un nombre descriptivo que identifique la estrategia.',
                                            'title' => 'Campo requerido',
                                                        )
                                        );
		echo $this->Form->input('descripcion');
                echo $this->Form->input('costosSeleccionados', array('type' => 'hidden', 'id' => 'costosSeleccionados'));
                
                if (!empty($costosJson)) {
                    echo '
                            <label>Costos</label>
                            <!-- Add a <div> element where the tree should appear: -->
                            <div id="tree">  </div>
                        ';
                }
                
	?>
                
	</fieldset>
<?php // echo $this->Form->button('Guardar !!!', array('id' => 'guardar', 'type' => 'button')); ?>    
<?php echo $this->Form->end(__('Guardar')); ?>
</div>
<!--
<div class="actions">
	<h3><?php //echo __('Actions'); ?></h3>
	<ul>

		<li><?php //echo $this->Html->link(__('List Estrategias'), array('action' => 'index')); ?></li>
	</ul>
</div>
-->