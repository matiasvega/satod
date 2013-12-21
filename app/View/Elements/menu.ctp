<?php
//d($this->params['controller']); //controller

$controladorSeleccionado = $this->params['controller'];
if ($this->params['controller'] == 'planificaciones') {
    $controladorSeleccionado = 'carteras';
} else if ($this->params['controller'] == 'indicadores_valores') {
    $controladorSeleccionado = 'indicadores';
} else if ($this->params['controller'] == 'costosEstrategias') {
    $controladorSeleccionado = 'estrategias';
} else if ($this->params['controller'] == 'carterasIndicadores') {
    $controladorSeleccionado = 'carteras';
} else if ($this->params['controller'] == 'groups') {
    $controladorSeleccionado = 'users';
} else if ($this->params['controller'] == 'aros' || $this->params['controller'] == 'acos') {
    $controladorSeleccionado = 'users';
}    

//d($controladorSeleccionado);

$options = array();
$options['Clientes']['titulo'] = 'Clientes';
$options['Clientes']['opciones'] = array(
                                            'index' => $this->Html->link('Administrar Clientes', '/clientes/'),
                                            'add' => $this->Html->link('Registrar Cliente', '/clientes/add'),
                                        );
$options['Costos']['titulo'] = 'Costos de gestion';
$options['Costos']['opciones'] = array(
                                            'index' => $this->Html->link('Administrar Costos', '/costos/'),
                                            'add' => $this->Html->link('Registrar Costo', '/costos/add'),
                                        );
$options['Indicadores']['titulo'] = 'Indicadores de recupero';
$options['Indicadores']['opciones'] = array(
                                                'index' => $this->Html->link('Administrar Indicadores', '/indicadores/'),
                                                'add' => $this->Html->link('Registrar Indicador', '/indicadores/add'),
                                            );
$options['Estrategias']['titulo'] = 'Estrategias de gestion';
$options['Estrategias']['opciones'] = array(
                                                'index' => $this->Html->link('Administrar Estrategias', '/estrategias/'),
                                                'add' => $this->Html->link('Registrar Estrategia', '/estrategias/add'),
                                            );
$options['Carteras']['titulo'] = 'Carteras de deudores';
$options['Carteras']['opciones'] = array(
                                            'index' => $this->Html->link('Administrar carteras', '/carteras/'),
                                            'add' => $this->Html->link('Registrar Cartera', '/carteras/add'),
                                            'analizar' => $this->Html->link('Analizar cartera', '/carteras/analizar'),
                                            'presupuestar' => $this->Html->link('Generar presupuesto de gestion', '/carteras/presupuestar'),
                                            'addPlanificacion' =>  $this->Html->link('Generar planificacion de gestion', '/carteras/addPlanificacion'),
                                            'indexPlanificaciones' => $this->Html->link('Administrar planificaciones de gestion', '/carteras/indexPlanificaciones'),
                                        );
$options['Pagos']['titulo'] = 'Generacion de Reportes';
$options['Pagos']['opciones'] = array(
                                'index' => $this->Html->link('Registro de Pagos', '/pagos/'),
                                'generarInformeDePagos' => $this->Html->link('Comportamiento de pagos', '/pagos/generarInformeDePagos'),
                                'generarInformeDeRecupero' => $this->Html->link('Indice de recupero', '/pagos/generarInformeDeRecupero'),
                                'generarEfectividadEstrategias' => $this->Html->link('Efectividad de Estrategias de Gestion', '/pagos/generarEfectividadEstrategias'),
                                'generarScoringDeudores' => $this->Html->link('Scoring de Deudores', '/pagos/generarScoringDeudores'),
                                'generarInformeDeRecupero' => $this->Html->link('Indice de recupero', '/pagos/generarInformeDeRecupero'),
                            );
$options['Users']['titulo'] = 'Usuarios';
$options['Users']['opciones'] = array(
                                        'index' => $this->Html->link('Administrar Usuarios', '/users/'),
                                        'add' => $this->Html->link('Registrar Usuario', '/users/add'),
                                        'indexGroups' => $this->Html->link('Administrar Grupos', '/users/indexGroups'),
                                        'addGroup' => $this->Html->link('Registrar Grupo', '/users/addGroup'),
                                        'indexPriv' => $this->Html->link('Administrar Privilegios', '/users/indexPriv'),
                                        'options' => $this->Html->link('Preferencias de Usuario', sprintf('/users/options/%s', $this->Session->read('Auth.User.id'))),
                                    );


$opcionesMenu = array();
$id = 0;
//d($this->Session->read('Auth.User.grantActions'));
foreach ($this->Session->read('Auth.User.grantActions') as $controller => $actions) {
    $contar = false;
    foreach ($actions as $action => $boolean) {
        if ($boolean) {
            // Agrego la accion al menu
            if (!empty($options[$controller])) {
                $opcionesMenu[$controller]['titulo'] = $options[$controller]['titulo'];
                $opcionesMenu[$controller]['id'] = $id;
                $contar = true;
                if (!empty($options[$controller]['opciones'][$action])) {
                    $opcionesMenu[$controller]['opciones'][] = $options[$controller]['opciones'][$action];
                }                    
            }
        }
    }
    if ($contar) {
        $id++;
    }
}
//d($opcionesMenu);
$codigoHtml = array();
$menu = array();
foreach ($opcionesMenu as $controlador => $opcionMenu) {
        $menu[$controlador] = array(
                                                    'id' => $opcionMenu['id'],
                                                    'titulo' => $opcionMenu['titulo'],
                                                    'opciones' => $opcionMenu['opciones'],
                                                );        
}

$menuHtml = array();
foreach ($menu as $k => $modulo) {    
        $menuHtml[] = $this->Html->tag('h3', $modulo['titulo'], array());
        $menuHtml[] = $this->Html->div('menu-item', $this->Html->nestedList($modulo['opciones']), array());                
}
    
$codigoHtml[] = $this->Html->div('menu', implode($menuHtml, "\n"), array('id' => 'accordion'));

echo implode($codigoHtml, "\n");

//d($menu[ucfirst($controladorSeleccionado)]['id']);
//d($menu);
$this->Js->get('document');
$this->Js->event('ready', sprintf('  
                            var icons = {
                                    header: "ui-icon-circle-arrow-e",
                                    activeHeader: "ui-icon-circle-arrow-s"
                            };
                            $( "#accordion" ).accordion({
                                    icons: icons,
                                    active: %s,
                                    collapsible: true,
                            });
                            $( "#toggle" ).button().click(function() {
                                    if ( $( "#accordion" ).accordion( "option", "icons" ) ) {
                                            $( "#accordion" ).accordion( "option", "icons", null );
                                    } else {
                                            $( "#accordion" ).accordion( "option", "icons", icons );
                                    }
                            });
                         ', 
                            $menu[ucfirst($controladorSeleccionado)]['id']
                            
                            )
                );                

echo $this->Js->writeBuffer();

?>