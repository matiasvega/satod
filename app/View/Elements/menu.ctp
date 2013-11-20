<?php
//d($this->params['controller']); //controller

$controller = $this->params['controller'];
if ($this->params['controller'] == 'planificaciones') {
    $controller = 'carteras';
} else if ($this->params['controller'] == 'indicadores_valores') {
    $controller = 'indicadores';
} else if ($this->params['controller'] == 'costosEstrategias') {
    $controller = 'estrategias';
} else if ($this->params['controller'] == 'carterasIndicadores') {
    $controller = 'carteras';
} 



$codigoHtml = array();

$menu = array(
    
//                array(
                    'clientes' => array(  
                                        'id' => '0',
                                        'titulo' => 'Clientes',
                                        'controller' => 'clientes',
                                        'opciones' => array(
                                                                $this->Html->link('Administrar Clientes', '/clientes/'),
                                                                $this->Html->link('Registrar Cliente', '/clientes/add'),
                                                            ),
                                      ),
                    'costos' => array(        
                                            'id' => '1',
                                            'titulo' => 'Costos de Gestion',
                                            'controller' => 'costos',
                                            'opciones' => array(
                                                                $this->Html->link('Registrar Costo', '/costos/add'),
                                                                $this->Html->link('Administrar Costos', '/costos/')
                                                             )
                                        ),
//                     ),
//                array(
                    'indicadores' => array(  
                                            'id' => '2',
                                            'titulo' => 'Indicadores de Recupero',
                                            'controller' => 'indicadores',
                                            'opciones' => array(
                                                            $this->Html->link('Registrar Indicador', '/indicadores/add'),
                                                            $this->Html->link('Administrar Indicadores', '/indicadores/')
                                                                )

                                           ),
//                     ),
//                array(
                    'estrategias' => array(  
                                            'id' => '3',
                                            'titulo' => 'Estrategias de Gestion',
                                            'controller' => 'estrategias',
                                            'opciones' => array(
                                                                    $this->Html->link('Registrar Estrategia', '/estrategias/add'),
                                                                    $this->Html->link('Administrar Estrategias', '/estrategias/')
                                                                )
                                            ),
//                     ),
//                array(
                    'carteras' => array(
                                            'id' => '4',
                                            'titulo' => 'Carteras de deudores',
                                            'controller' => 'carteras',
                                            'opciones' => array(
                                                $this->Html->link('Registrar Cartera', '/carteras/add'),
                                                $this->Html->link('Administrar carteras', '/carteras/'),
                                                $this->Html->link('Analizar cartera', '/carteras/analizar'),
                                                $this->Html->link('Generar presupuesto de gestion', '/carteras/presupuestar'),
                                                $this->Html->link('Generar planificacion de gestion', '/planificaciones/add'),
                                                $this->Html->link('Administrar planificaciones de gestion', '/planificaciones/'),
                                                                )
                                          ),

//                      ),    
//                array(

//                     ),
//                array(

    
                    'pagos' => array(
                            'id' => '5',
                            'titulo' => 'Generacion de Reportes',
                            'controller' => 'pagos',
                            'opciones' => array(                                                                    
                                    $this->Html->link('Registro de Pagos', '/pagos/'),
                                    $this->Html->link('Comportamiento de pagos', '/pagos/generarInformeDePagos'),
                                    $this->Html->link('Indice de recupero', '/pagos/generarInformeDeRecupero'),
                                    $this->Html->link('Efectividad de Estrategias de Gestion', '/pagos/generarEfectividadEstrategias'),
                                    $this->Html->link('Scoring de Deudores', '/pagos/generarInformeDeRecupero'),
                                                ),
                                         ),                                            
    
                    'users' => array(
                                        'id' => '6',
                                        'titulo' => 'Usuarios',
                                        'controller' => 'usuarios',
                                        'opciones' => array(
                                                                $this->Html->link('Administrar Usuarios', '/users/'),
                                                                $this->Html->link('Registrar Usuario', '/users/add'),
                                                            ),                    
                                     ),
            ); 


//d($menu);
foreach ($menu as $k => $modulo) {
//    dd($modulo);
//    foreach ($modulos as $modulo) {
        $menuHtml[] = $this->Html->tag('h3', $modulo['titulo'], array());
        $menuHtml[] = $this->Html->div('menu-item', $this->Html->nestedList($modulo['opciones']), array());        
//    }
}



//foreach ($opcionesMenu as $indice => $menu){
//    foreach ($menu as $modulo => $links){
//        $menuHtml[] = $this->Html->tag('h3', $modulo, array());
//
//        $menuHtml[] = $this->Html->div('menu-item', $this->Html->nestedList($links), array());
//    }    
//}
    
$codigoHtml[] = $this->Html->div('menu', implode($menuHtml, "\n"), array('id' => 'accordion'));

echo implode($codigoHtml, "\n");




$this->Js->get('document');
$this->Js->event('ready', sprintf('  
                            var icons = {
                                    header: "ui-icon-circle-arrow-e",
                                    activeHeader: "ui-icon-circle-arrow-s"
                            };
                            $( "#accordion" ).accordion({
                                    icons: icons,
                                    active: %s,
                            });
                            $( "#toggle" ).button().click(function() {
                                    if ( $( "#accordion" ).accordion( "option", "icons" ) ) {
                                            $( "#accordion" ).accordion( "option", "icons", null );
                                    } else {
                                            $( "#accordion" ).accordion( "option", "icons", icons );
                                    }
                            });
                         ', $menu[$controller]['id'])
                );                

echo $this->Js->writeBuffer();

?>