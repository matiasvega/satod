<?php
/**
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
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Sistema de apoyo a la toma de decisiones');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
        <script src="https://www.google.com/jsapi"></script>
	<?php
		echo $this->Html->meta('icon');

                echo $this->Html->css('chosen.css');
                echo $this->Html->css('jquery.fileupload.css');                        
                echo $this->Html->css('jquery.fileupload-ui.css');                
		echo $this->Html->css('cake.generic');
                //echo $this->Html->css('jqtree.css'); // Include jquery tree css                
                echo $this->Html->css('ui.dynatree.css');
                //echo $this->Html->css('jquery.ui.accordion.css');
//                echo $this->Html->css('jquery-ui.css');
                echo $this->Html->css('jquery-ui-1.10.3.custom.css');                
                echo $this->Html->css('bootstrap.min.css');
//                echo $this->Html->css('jquery.dataTables_themeroller.css');                
                echo $this->Html->css('demo_page.css');
                echo $this->Html->css('demo_table.css');
                echo $this->Html->css('jquery.pnotify.default.css');
                echo $this->Html->css('jquery.pnotify.default.icons.css');
                        
                
                                                              
                echo $this->Html->script('jquery-2.0.3.min.js'); // Include jQuery library
                echo $this->Html->script('jquery-ui.custom.min.js'); // Include jQuery library
                echo $this->Html->script('jquery.cookie.js'); // Include jQuery library                                
                //echo $this->Html->script('tree.jquery.js'); // Include jQuery Tree                                               
                                
                echo $this->Html->script('jquery-1.9.1.js');                                
                echo $this->Html->script('jquery.ui.core.js');
                echo $this->Html->script('jquery.ui.widget.js');
                echo $this->Html->script('jquery.ui.mouse.js');
                echo $this->Html->script('jquery.ui.accordion.js');
                
                echo $this->Html->script('jquery.ui.draggable.js');
                echo $this->Html->script('jquery.ui.position.js');
                echo $this->Html->script('jquery.ui.resizable.js');
                echo $this->Html->script('jquery.ui.button.js');
                echo $this->Html->script('jquery.ui.dialog.js');
                echo $this->Html->script('jquery.ui.datepicker.js');
                echo $this->Html->script('jquery.ui.effect.js');
                
                echo $this->Html->script('jquery.ui.effect-blind.js');
                echo $this->Html->script('jquery.ui.effect-explode.js');
                echo $this->Html->script('jquery.ui.effect-clip.js');
                echo $this->Html->script('jquery.ui.effect-slide.js');
                                                                                
                echo $this->Html->script('jquery.dynatree.js'); // Include jQuery Tree
                echo $this->Html->script('jquery.pnotify.js');
                                             
                echo $this->Html->script('satod.js'); // Include jQuery Tree
                
                echo $this->Html->script('chosen.jquery.js');
                echo $this->Html->script('jquery.iframe-transport.js');
                echo $this->Html->script('jquery.fileupload.js');
                echo $this->Html->script('jquery.dataTables.js');
                echo $this->Html->script('jquery.ui.spinner.js');
                echo $this->Html->script('jquery.jqdock.js');
                echo $this->Html->script('jquery.h5validate.js');
//                echo $this->Html->script('bootstrap.min.js');
                
                                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');                                               
                
	?>

   
</head>
<body>    
	<div id="container">
		<div id="header">
                        <div id="himage">
                            <?php // echo $this->Html->image('logo-vn-trans.png', array('alt' => 'V/N')); ?>
                            <div id="user" >
                                <?php
                                    echo sprintf('+ [%s@%s]', 
                                            $this->Session->read('Auth.User.username'),
                                            $this->Session->read('Auth.User.Group.name')
                                                );
                                ?>
                            </div>
                            <h1>
                                <span id="description">
                                    <?php echo $cakeDescription; ?>
                                </span>                                
                                <div id="toolbar">                                    
                                    <div id="page">                                        
                                        <div id="menu">
                                        <?php 
                                        echo $this->Html->image('user.png', array(
                                                                                'alt' => 'Opciones de usuario',
                                                                                'title' => 'Opciones de usuario',
                                                                                'url' => sprintf('/users/options/%s',
                                                                                        $this->Session->read('Auth.User.id')),
                                                                                  ));
                                        
                                        echo $this->Html->image('help.png', array(
                                                                                'alt' => 'Ayuda',
                                                                                'title' => 'Ayuda',
                                                                                'url' => 'https://github.com/matiasvega/satod/wiki',
                                                                                array('target' => '_blank')
                                                                              ));                                        
                                                                                       
    
                                        echo $this->Html->image('logout.png', array(
                                                                                         'alt' => 'Salir',
                                                                                         'title' => 'Salir',
                                                                                         'url' => '/users/logout',
                                                                                         ));

                                        ?> 
                                        </div>
                                    </div>                                
                                </div>      
                            </h1>

                        </div>                                                                                    
                         
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
                        
                    <div id="menu">  
                        <?php echo $this->element('menu'); ?>
                    </div>
                    <div id="contenido">                          
                        <?php 
//                            echo $this->Html->getCrumbs(' > ', 'Inicio'); 
                            //echo $this->html->div('breadcrumb', $this->Html->getCrumbs(' > ', 'Inicio'), array('id' => 'breadcrumb'));
                        ?>
                        <?php echo $this->fetch('content'); ?>
                    </div>
                    			
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php // echo $this->element('sql_dump'); ?>
    
    
    
</body>
</html>