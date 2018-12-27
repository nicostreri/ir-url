<html>
<head>
    <?php include('header.php'); ?>
    <title><?php echo env('APP_NAME'); ?> :: Inicio</title>
</head>
<body>
    <?php include('navegate_bar.php'); ?>
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 card text-white p-4 bg-primary">
                    <div class="card-body">
                        <div class="text-center">
                            <h1 class="mb-2">Acortar URL</h1>
                            <div id="formNewURL" class="form-inline">
                                <input type="url" class="form-control col-10" placeholder="URL" id="url_input" required/>
                                <button type="button" onclick="create_url()" class="btn btn-secondary" id="button_create_url" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Espere...">
                                    Acortar <i class="fa fa-cut"></i>
                                </button>
                            </div>
                        </div>
                        <div class="checkbox">
                            <label><input id="check_password" type="checkbox" value=""/>Proteger enlace?</label>
                            <input style="display: none;" type="password" class="form-control" placeholder="Clave" id="pass_input"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('scripts.php'); ?>
    <script type="application/javascript">
        $(document).ready(function() {

            //enable or disable the password input
            $('#check_password').change(function () {
                const field = $("#pass_input");
                if ($(this).is(':checked')) {
                    field.css("display", "block");
                } else {
                    field.css("display", "none");
                }
            });

            //enable use enter key for send the create url petition
            ["#url_input", "#pass_input"].forEach(function(e){
                $(e).keyup(function(event) {
                    if (event.keyCode === 13) {
                        $("#button_create_url").click();
                    }
                });
            });
        });

        function create_url() {
            if(!document.getElementById("url_input").validity.valid){
                swal("Oops!!","Ingresar una url valida","error");
                return;
            }
            var pass = null;
            if($("#check_password").prop("checked")){
                if($("#pass_input").val() === ""){
                    swal("Oops!!", "Ingresar una contraseña", "error");
                }else{
                    pass = $("#pass_input").val(); //save for send in creation
                }
            }
            $('#button_create_url').hide();

            $.ajax({
                url: '<?php echo env('APP_URL'); ?>/api/urls',
                type: 'post',
                dataType: 'json',
                contentType: 'application/json',
                data: JSON.stringify({
                    url: $("#url_input").val(),
                    pass:pass
                })
            }).done(function( data ){
                var htmlTexto = '<img src="//api.qrserver.com/v1/create-qr-code/?data='+encodeURIComponent(data["fullUrl"])+'&size=200x200" alt="" title=""/>';
                htmlTexto += "</br>Tu enlace es: <a href='"+data["fullUrl"]+"'>"+data["fullUrl"]+"</a>";
                swal({
                    title: "Acortado!!",
                    icon: "success",
                    content: {
                        element: "p",
                        attributes: {
                            innerHTML: htmlTexto
                        }
                    }
                });
                $("#url_input").val("");
            }).fail( function( jqXHR, textStatus, errorThrown ) {
                if( jqXHR.status === 422 ) {
                    //process validation errors.
                    var errors = jqXHR.responseJSON;

                    errorsHtml = '<ul>';
                    $.each( errors , function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>';
                    });
                    errorsHtml += '</ul></di>';
                    swal({
                        title: "Oops!!",
                        icon: "error",
                        content: {
                            element: "p",
                            attributes: {
                                innerHTML: errorsHtml
                            }
                        }
                    });
                } else {
                    swal("Oops!!", "Algo salió mal. Reintentar.", "error");
                }
            }).always(function () {
                $('#button_create_url').show();
            });
        }
    </script>
</body>
</html>