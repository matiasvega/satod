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

$cakeDescription = __d('cake_dev', ' V/N Sistema de apoyo a la toma de decisiones');
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

		echo $this->Html->css('cake.generic');
                //echo $this->Html->css('jqtree.css'); // Include jquery tree css                
                echo $this->Html->css('ui.dynatree.css');
                //echo $this->Html->css('jquery.ui.accordion.css');
                echo $this->Html->css('jquery-ui.css');
                
                
                                              
                echo $this->Html->script('jquery-2.0.3.min.js'); // Include jQuery library
                echo $this->Html->script('jquery-ui.custom.min.js'); // Include jQuery library
                echo $this->Html->script('jquery.cookie.js'); // Include jQuery library                                                                                
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
                
                echo $this->Html->script('jquery.ui.effect.js');
                                
                echo $this->Html->script('jquery.dynatree.js'); // Include jQuery Tree
                                             
                echo $this->Html->script('satod.js'); // Include jQuery Tree
                                                                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');                                               
                
	?>
    
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $cakeDescription; ?></h1>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
                        
                        <?php echo $this->fetch('content'); ?>
                    			
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
	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>