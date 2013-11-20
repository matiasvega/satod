<?php

echo sprintf("<script type=\"text/javascript\">
    
    $(function(){

        function show_stack_bar_bottom(type, message) {        
            var opts = {
                title: \"Over Here\",
                text: \"Check me out. I'm in a different stack.\",
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
                opts.title = \"Breaking News\";
                opts.text = message;
                opts.type = \"info\";
                break;
            case 'success':
                opts.title = \"Good News Everyone\";
                opts.text = message;
                opts.type = \"success\";
                break;
            }

            $.pnotify(opts);
        }

        show_stack_bar_bottom('info', '%s');

    });
</script>", $message);

?>