<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array( 
//                        'DebugKit.Toolbar', 
                        'Session', 
                        'RequestHandler',
                        'Acl',
                        'Acl.AclManager',
                        'Acl.AclReflector',
                        'Auth' => array(
                            'loginRedirect' => array('controller' => 'clientes', 'action' => 'index'),
                            'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
                            'authError' => 'Para ingresar en el sistema, debes utilizar tu nombre de usuario y contraseña.',
                            'authorize' => array(
                                                    'Actions' => array('actionPath' => 'controllers'),
                                                )
                                        )
                                    );
        
    public function beforeFilter() {
//        $this->Auth->allow();
//        $this->Auth->allow('initDB');
//        $this->Auth->allow('login');
//        $this->Auth->allow('logout');
        
        $actions = array();
        $fullActions = $this->AclReflector->get_all_actions();
//        d($fullActions);
        $i = 0;
        foreach ($fullActions as $fullAction) {
            $arrActions = String::tokenize($fullAction, '/');    
//            d($arrActions);
            if (count($arrActions) == 2) {
                $actions[$i]['controller'] = $arrActions[0];
                $actions[$i]['action'] = $arrActions[1];
            } elseif (count($arrActions) == 3) {
                $actions[$i]['controller'] = $arrActions[1];
                $actions[$i]['action'] = $arrActions[2];
            }
            $i++;
        }
//        dd($actions);
        $granActions = array();
        foreach ($actions as $k => $action) {
            if ($this->Acl->check(array('User' => array('id' => $this->Session->read('Auth.User.id'))), sprintf('%s/%s', $action['controller'], $action['action']))) {
                $granActions[$action['controller']][$action['action']] = true;
            }              
        }

        $this->Session->write('Auth.User.grantActions', $granActions);

    }
    
                        
    public $helpers = array(
                                'Js' => array('Jquery'),
//                                'Googlechart',
                            );            
}
