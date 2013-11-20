<?php 

$data = $this->Js->get('#CarteraAnalizarForm')->serializeForm(array('isForm' => true, 'inline' => true));
$this->Js->get('#CarteraAnalizarForm')->event(
      'submit',
      $this->Js->request(
        array('action' => 'planificar'),
        array(
                'update' => '#xxx',
                'data' => $data,
                'async' => true,    
                'dataExpression'=>true,
                'method' => 'POST',
                'before' => "$('#xxx').dialog({
                        modal: true,
                        width: 750,
                        height: 650,
                        closeOnEscape: true,
                        draggable: false,
                        resizable: false,
                        title: 'Analisis de cartera de deudores',
                        buttons: {                            
                            'Exportar PDF': function() {
                                $(location).attr('href', './analizar/1.pdf');
                            },
                            Cerrar: function() {
                                $(this).dialog(\"close\");
                            },
                        }
                    });",
            )
        )
    );

?>

<div spellcheck="<none>" class="carteras form">
    <?php echo $this->Form->create('Cartera', array('action' => 'planificar', 'default' => false)); ?>
    <fieldset spellcheck="true" >
        <legend><?php echo 'Generar planificacion de gestion de Cartera de Deudores'; ?></legend>
        <?php
        echo $this->Form->input('clientes_id');
        echo $this->Form->input('carteras_id');
        
        echo $this->Form->input('fecha_inicio');
        echo $this->Form->input('fecha_fin');
        
        
        echo $this->Form->input('Estrategia.estrategias_id', array('multiple' => true));
               
        echo $this->Html->div('x', false, array('id' => 'xxx'));
        
        ?>
    </fieldset>
    <?php 
        echo $this->Form->end(__('Emitir Informe')); 
        echo $this->Js->writeBuffer();
    ?>
</div>