<script type="text/javascript">
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {

        $('#fileupload').fileupload({                    
            url: 'cargar/1',
            dataType: 'json',
            add: function (e, data) {
                data.submit();                        
            },
            done: function (e, data) {
                console.log(data.result);
                $.ajax({
                        type: "POST",
                        url: "importarCartera",
                        data: data.result
                      })
                        .done(function(html) {
                            $( "#files" ).append(html);
                      });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        });

    });
</script>

<div class="containerX">
    <!-- The fileinput-button span is used to style the file input field as button -->
    <span class="btn btn-success fileinput-button">
<!--        <i class="glyphicon glyphicon-plus"></i>-->
        <span>Select files...</span>
        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" />
    </span>

    <!-- The global progress bar -->
    <div id="progress" class="progress">
        <div class="progress-bar progress-bar-success"></div>
    </div>
    <!-- The container for the uploaded files -->
    <div id="files" class="files"></div>
</div>    