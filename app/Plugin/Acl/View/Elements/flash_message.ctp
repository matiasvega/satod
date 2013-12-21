<!--<div id="pluginAclflashMessage" class="message">
	ACL: <?php // echo $message; ?>
</div>-->

<?php

echo sprintf("<script type=\"text/javascript\">
    
    $(function(){

        function show_stack_bar_bottom(type, message) {        
            var opts = {
                addclass: \"stack-bar-bottom\",
                cornerclass: \"\",
                width: \"30%%\",
                styling: 'jqueryui',
                animation: 'show'
    //            stack: show_stack_bar_bottom,
            };

            switch (type) {
            case 'error':
                opts.title = \" ERROR \";
                opts.text = message
                opts.type = \"error\";
                break;
            case 'info':
                opts.title = message;
//                opts.text = message;
                opts.type = \"info\";
                break;
            case 'success':
                opts.title = message;
//                opts.text = message;
                opts.type = \"success\";
                break;
            }

            $.pnotify(opts);
        }

        show_stack_bar_bottom('success', '%s');

    });
</script>", $message);

?>
