<?php 
$data = $this->Js->get('#PagoGenerarInformeDeRecuperoForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#PagoGenerarInformeDeRecuperoForm')->event(
      'submit',
      sprintf("
            $(function(){
                var errorCliente = false;
                var errorCartera = false;

                var opts = {
                                cornerclass: \"\",
                                width: \"30%%\",
                                styling: 'jqueryui',
                                animation: 'show',
                                title: \" ERROR \",
                                type: \"error\",
                                history: false,
                                sticker: false,
                                delay: 2000,
                            };

                if ($('#comboClientes').val() == '') {
                    $(\"label[for='\"+$('#comboClientes').attr('id')+\"']\").css('color', 'red');
                    errorCliente = true;                                        
                } else {
                    $(\"label[for='\"+$('#comboClientes').attr('id')+\"']\").css('color', '#000000');
                }

                if ($('#comboCartera').val() == null) {
                    $(\"label[for='\"+$('#comboCartera').attr('id')+\"']\").css('color', 'red');
                    errorCartera = true;
                } else {
                    $(\"label[for='\"+$('#comboCartera').attr('id')+\"']\").css('color', '#000000');
                }

                if (errorCliente || errorCartera) {
                    opts.text = 'Debes seleccionar valores para los campos marcados como requeridos.';
                    $.pnotify(opts);                                         
                } else {
                        $.ajax({
                            type: 'POST',
                            data: %s,
                            async:true,
                            url: 'generarInformeDeRecupero',
                            cache:false,
                            beforeSend: function() {
                                $('#informe').html('%s');
                            }
                          })
                            .done(function(data) {
                                $('#informe').html(data);                                                    
                                $('#informe').dialog({
                                    modal: true,
                                    width: 1150,
                                    height: 650,
                                    draggable: true,
                                    resizable: true,
                                    title: 'Indice de Recupero',
                                    show: {
                                            effect: \"blind\",
                                            duration: 1000,
                                          },
                                    hide: {
                                      effect: \"fade\",
                                      duration: 1000,
                                    },
                                    buttons: {                            
                                        'Exportar PDF': function() {
                                            //$(location).attr('href', 'presupuestar/' + $(\"#estrategias_id\").val() + '/' + $(\"#cartera_seleccionada\").val() + '.pdf');
                                        },
                                        Cerrar: function() {
                                            $(this).dialog(\"close\");
                                        },
                                     }
                                });
                        });
                }

            });
          ", 
                    $data,
                    '<img src="/devel/satod/img/load.gif" />')
    );

$this->Js->get('#comboCartera')->event(
        'change', $this->Js->request(
                array('action' => 'buscarIndicadores', 'generarInformeDeRecupero'), 
                array(
                    'update' => '#indicadores',
                    'data' => $data,
                    'async' => true,
                    'dataExpression' => true,
                    'method' => 'POST',
                )
        )
);

?>

<div spellcheck="<none>" class="pagos form">
    <?php echo $this->Form->create('Pago', array('action' => 'generarInformeDeRecupero', 'default' => false)); ?>
    <fieldset spellcheck="true" >
        <legend><?php echo 'Generar Informe de Indice de Recupero'; ?></legend>
        <?php
        echo $this->Form->input('clientes_id', array(
                                                        'id' => 'comboClientes',
                                                        'empty' => 'Elegi el cliente',
                                                        'label' => 'Cliente',
                                                        'div' => 'required',
                                                    )
                                );
        echo $this->Form->input('carteras_id', array(
                                                        'id' => 'comboCartera',
                                                        'data-placeholder' => 'Elegi la cartera',
                                                        'label' => 'Cartera',
                                                        'multiple' => true,
                                                        'div' => 'required',
                                                    )
                                );
        
        
        echo $this->Html->div('indicadores', false, array('id' => 'indicadores'));
        echo $this->Html->div('informe', false, array('id' => 'informe'));
        
        ?>
    </fieldset>
    <?php 
        echo $this->Form->end(__('Emitir Informe')); 
        echo $this->Js->writeBuffer();
    ?>
</div>
<!--
<div class="actions">
    <h3><?php //echo __('Actions'); ?></h3>
    <ul>

        <li><?php //echo $this->Html->link(__('List Carteras'), array('action' => 'index')); ?></li>
        <li><?php //echo $this->Html->link(__('List Clientes'), array('controller' => 'clientes', 'action' => 'index')); ?> </li>
        <li><?php //echo $this->Html->link(__('New Clientes'), array('controller' => 'clientes', 'action' => 'add')); ?> </li>
        <li><?php //echo $this->Html->link(__('List Indicadores'), array('controller' => 'indicadores', 'action' => 'index')); ?> </li>
        <li><?php //echo $this->Html->link(__('New Indicadore'), array('controller' => 'indicadores', 'action' => 'add')); ?> </li>
    </ul>
</div>
-->

