<html>
<head>
    <?php include('header.php'); ?>
    <title><?php echo env('APP_NAME'); ?> :: Ver Link</title>
</head>
<body>
<?php include('navegate_bar.php'); ?>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6">
                <div id="loading" class="progress progress-striped active">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row text-center">
            <div class="col">
                <a class="btn btn-secondary" href="/">Acortar enlace</a>
            </div>
        </div>
    </div>
</div>
<?php include('scripts.php'); ?>
<script type="application/javascript">
    $(document).ready(function() {
        goLink("<?php echo $id_url;?>");
    });

    function goLink(link, pass = "") {
        $.ajax({
            url: '<?php echo env('APP_URL'); ?>/api/urls/'+link+'?pass='+pass,
            type: 'get',
        }).done(function(data){
            swal({
                title: "Enlace:",
                icon: "info",
                content: {
                    element: "p",
                    attributes: {
                        innerHTML: '<a href="'+data["url"]+'">'+data["url"]+'</a>, click si no redirige automaticamente.'
                    }
                }
            });

            window.location = data["url"];
        }).fail( function( jqXHR, textStatus, errorThrown ) {
            if( jqXHR.status === 404 ) {
                swal("Oops!!","El enlace no existe", "error");
            }else if(jqXHR.status === 401) {
                swal("Enlace Protegido. Contraseña:", {
                    content: "input",
                }).then((value) => {
                    goLink(link,value);
                });
            }else {
                swal("Oops!!", "Algo salió mal. Reintentar.", "error");
            }
        }).always(function () {
        });
    }
</script>
</body>
</html>