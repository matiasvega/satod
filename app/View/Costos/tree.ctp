<div class="costos index">
	<h2><?php echo __('Costos'); ?></h2>
        
        
        <?php
            echo "<ul>";
            foreach($costos as $key=>$value){
                echo "<li>$value</li>";
            }
            echo "</ul>";
        ?>
        
	
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Costo'), array('action' => 'add')); ?></li>
	</ul>
</div>
