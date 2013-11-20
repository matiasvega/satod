<script>
    $(document).ready(function() {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: "dd-mm-yy",
            minDate: new Date(),
            showAnim: "slide",
            onClose: function(selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 3,
            dateFormat: "dd-mm-yy",
            showAnim: "slide",
            onClose: function(selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });        

    });
</script>

<?php

$data = $this->Js->get('#PlanificacioneAddForm')->serializeForm(array('isForm' => true, 'inline' => true));

$this->Js->get('#PlanificacioneAddForm')->event(
        'submit', sprintf("
            $(function() {
            var errorCliente = false;
            var errorCartera = false;
            var fechaInicio = false;
            var fechaFin = false

            var opts = {
                            cornerclass: \"\",
                            width: \"30%%\",
                            styling: 'jqueryui',
                            animation: 'show',
                            title: \" ERROR \",
                            type: \"error\",
                        };
             
            if ($('#comboCliente').val() == '') {
                $(\"label[for='\"+$('#comboCliente').attr('id')+\"']\").css('color', 'red');
                errorCliente = true;                                        
            } else {
                $(\"label[for='\"+$('#comboCliente').attr('id')+\"']\").css('color', '#000000');
            }

            if ($('#comboCartera').val() == '') {
                $(\"label[for='\"+$('#comboCartera').attr('id')+\"']\").css('color', 'red');
                errorCartera = true;
            } else {
                $(\"label[for='\"+$('#comboCartera').attr('id')+\"']\").css('color', '#000000');
            }

            if ($('#from').val() == '') {
                $(\"label[for='\"+$('#from').attr('id')+\"']\").css('color', 'red');
                fechaInicio = true;
            } else {
                $(\"label[for='\"+$('#from').attr('id')+\"']\").css('color', '#000000');
            }

            if ($('#to').val() == '') {
                $(\"label[for='\"+$('#to').attr('id')+\"']\").css('color', 'red');
                fechaFin = true;
            } else {
                $(\"label[for='\"+$('#to').attr('id')+\"']\").css('color', '#000000');
            }
            
            // Valido las fechas ingresadas y estrategias seleccionadas
            var errorDetalle = false;
            
            var aFechaInicio = jQuery.makeArray($('.fechaInicio'));
            var aFechaFin = jQuery.makeArray($('.fechaFin'));
            var aEstrategia = jQuery.makeArray($('.selectEstrategia'));
            
            console.log(aFechaInicio.length);
            console.log(aFechaFin.length);
            console.log(aEstrategia.length);
            
            for(i=0;i<aFechaInicio.length;i++) {
                if ($(aFechaInicio[i]).val() != '' || $(aFechaFin[i]).val() != '' || $(aEstrategia[i]).val() != '') {
                
                    if ($(aFechaInicio[i]).val() == '') {
                        $(aFechaInicio[i]).addClass('ui-state-error');
                        errorDetalle = true;
                    } else {
                        $(aFechaInicio[i]).removeClass('ui-state-error');
                    }

                    if ($(aFechaFin[i]).val() == '') {
                        $(aFechaFin[i]).addClass('ui-state-error');
                        errorDetalle = true;
                    } else {
                        $(aFechaFin[i]).removeClass('ui-state-error');
                    }

                    if ($(aEstrategia[i]).val() == '') {
                        $(aEstrategia[i]).addClass('ui-state-error');
                        errorDetalle = true;
                    } else {
                        $(aEstrategia[i]).removeClass('ui-state-error');
                    }
                    
                }

            }
            

            if (errorCliente || errorCartera || fechaInicio || fechaFin || errorDetalle) {
                opts.text = 'Debes seleccionar valores para los campos marcados como requeridos.';
                $.pnotify(opts); 
            } else {
                $.ajax({
                    type: 'POST',
                    data: %s,
                    async:true,
                    url: 'add',
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
                            title: 'Planificacion de gestion de cartera de deudores',
                            show: {
                                    effect: \"blind\",
                                    duration: 1000,
                                  },
                            hide: {
                              effect: \"fade\",
                              duration: 1000,
                            },
                            close: function() {
                                $(location).attr('href', '%s/devel/satod/planificaciones/');
                            },
                            buttons: {                            
                                Cerrar: function() {
                                    $(this).dialog(\"close\");                                    
                                },
                            }
                        });
                });
            }
        }  )
        ", $data, '<img src="/devel/satod/img/load.gif" />', FULL_BASE_URL)
);

$this->Js->get('.inputPlanificacion')->event(
        'change', sprintf("
            $(function() {
            var errorCliente = false;
            var errorCartera = false;
            var fechaInicio = false;
            var fechaFin = false
            
            if ($('#comboCliente').val() == '') {                
                errorCliente = true;                                        
            } else {
                $(\"label[for='\"+$('#comboCliente').attr('id')+\"']\").css('color', '#000000');
            }

            if ($('#comboCartera').val() == '') {
                errorCartera = true;
            } else {
                $(\"label[for='\"+$('#comboCartera').attr('id')+\"']\").css('color', '#000000');
            }

            if ($('#from').val() == '') {
                fechaInicio = true;
            } else {
                $(\"label[for='\"+$('#from').attr('id')+\"']\").css('color', '#000000');
            }

            if ($('#to').val() == '') {
                fechaFin = true;
            } else {
                $(\"label[for='\"+$('#to').attr('id')+\"']\").css('color', '#000000');
            }

            if (!errorCliente && !errorCartera && !fechaInicio && !fechaFin) {            
                $.ajax({
                    type: 'POST',
                    data: %s,
                    async:true,
                    url: 'buscarIndicadores',
                    cache:false,
                    beforeSend: function() {
                        $('#indicadores').html('%s');
                    }
                  })
                    .done(function(data) {
                        $('#indicadores').html(data);
                        $(window).scrollTop($('#indicadores').offset().top);
                });                
            }
        }  )
        ", 
          $data, 
          '<img src="/devel/satod/img/load.gif" />'
           )
);


$this->Js->get('#ver_analisis_cartera')->event(
        'click', sprintf("
            $(function() {
            var errorCliente = false;
            var errorCartera = false;
            
            if ($('#comboCliente').val() == '') {                
                $(\"label[for='\"+$('#comboCliente').attr('id')+\"']\").css('color', 'red');
                errorCliente = true;                                        
            } else {
                $(\"label[for='\"+$('#comboCliente').attr('id')+\"']\").css('color', '#000000');
            }

            if ($('#comboCartera').val() == '') {
                $(\"label[for='\"+$('#comboCartera').attr('id')+\"']\").css('color', 'red');
                errorCartera = true;
            } else {
                $(\"label[for='\"+$('#comboCartera').attr('id')+\"']\").css('color', '#000000');
            }
            
            var opts = {
                            cornerclass: \"\",
                            width: \"30%%\",
                            styling: 'jqueryui',
                            animation: 'show',
                            title: \" ERROR \",
                            type: \"error\",
                        };
                        

            if (errorCliente || errorCartera) {
                opts.text = 'Debes seleccionar valores para los campos marcados como requeridos.';
                $.pnotify(opts); 
            } else {
                $.ajax({
                    type: 'POST',
                    data: %s,
                    async:true,
                    url: '%s/devel/satod/carteras/analizar',
                    cache:false,
                    beforeSend: function() {
                        $('#analisis').html('%s');
                    }
                  })
                    .done(function(data) {
                        $('#analisis').html(data);
                        $('#analisis').dialog({
                            modal: true,
                            width: 1150,
                            height: 650,
                            draggable: true,
                            resizable: true,
                            title: 'Analisis de cartera de deudores',
                            show: {
                                    effect: \"blind\",
                                    duration: 1000,
                                  },
                            hide: {
                              effect: \"fade\",
                              duration: 1000,
                            },

                            buttons: {                            
                                Cerrar: function() {
                                    $(this).dialog(\"close\");                                    
                                },
                            }
                        });
                        console.log($('#analisis').offset());
                        $(window).scrollTop(($('#analisis').offset().top-400));
                });                                
            }
        }  )
        ", 
          $data, 
          FULL_BASE_URL,
          '<img src="/devel/satod/img/load.gif" />'
           )
);



?>

<div class="planificaciones form">
<?php echo $this->Form->create('Planificacione'); ?>
    <fieldset>
        <legend><?php echo __('Generar planificacion de gestion'); ?></legend>
<?php
    echo $this->Form->input('clientes_id', array(
                                                    'id' => 'comboCliente',
                                                    'empty' => 'Seleccione',
                                                    'label' => 'Cliente',
                                                    'div' => 'required',
                                                    'class' => 'inputPlanificacion',
                                                )
                            );
    echo $this->Form->input('carteras_id', array(
                                                    'id' => 'comboCartera',
                                                    'empty' => 'Seleccione',
                                                    'label' => 'Cartera',
                                                    'div' => 'required',
                                                    'class' => 'inputPlanificacion',
                                                )
                            );
    echo $this->Form->input('fecha_inicio', array(
                                                    'id' => 'from', 
                                                    'type' => 'text',
                                                    'div' => 'required',
                                                    'class' => 'inputPlanificacion',
                                                    )
                            );
    echo $this->Form->input('fecha_fin', array(
                                                'id' => 'to', 
                                                'type' => 'text',
                                                'div' => 'required',
                                                'class' => 'inputPlanificacion',
                                                )
                            );

    echo $this->Form->button('Ver analisis de cartera', array(
                                                            'id' => 'ver_analisis_cartera', 
                                                            'type' => 'button',
                                                        )
                            );

    echo $this->Html->div('indicadores', false, array('id' => 'indicadores'));
    echo $this->Html->div('informe', false, array('id' => 'informe'));
    echo $this->Html->div('analisis', false, array('id' => 'analisis'));

    echo $this->Js->writeBuffer();
?>
    </fieldset>
<?php
    echo $this->Form->end('Generar planificacion');
?>

</div>

<!--
<div class="actions">
        <h3><?php //echo __('Actions'); ?></h3>
        <ul>

                <li><?php //echo $this->Html->link(__('List Planificaciones'), array('action' => 'index'));  ?></li>
                <li><?php //echo $this->Html->link(__('List Carteras'), array('controller' => 'carteras', 'action' => 'index'));  ?> </li>
                <li><?php //echo $this->Html->link(__('New Carteras'), array('controller' => 'carteras', 'action' => 'add'));  ?> </li>
        </ul>
</div>
-->