<?php

if (!empty($indicadores)) {
    
    echo $this->Form->input('indicadores_id', array(                                                            
                                                            'id' => 'indicadores_id',
                                                            'data-placeholder' => 'Elegi los indicadores de recupero que desees.',
                                                            'label' => 'Indicadores de Recupero',
                                                            'multiple' => true,
                                                        )
                        );
    
} else {
    echo sprintf("
            <script type='text/javascript'>
                $(location).attr('href', '%s/devel/satod/pagos/%s');
            </script>
        ", FULL_BASE_URL, $accion);
}

?>

<script>
    $('select').chosen({width: "100%"});
</script>