<!-- Barra Superior de Navegacion -->
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php echo env('APP_URL'); ?>">
            <i class="fa d-inline fa-lg fa-share-alt"></i>
            <b>&nbsp;<?php echo env('APP_NAME'); ?><small class="text-muted">&nbsp;by Streri</small></b>
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbar2SupportedContent" aria-controls="navbar2SupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse text-center justify-content-end" id="navbar2SupportedContent">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo env('APP_URL'); ?>"><i class="fa d-inline fa-lg fa-cut"></i> Acortar URL</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo env('APP_URL'); ?>/ver/estadisticas"><i class="fa d-inline fa-lg fa-star"></i> Ver Estadisticas</a>
                </li>
            </ul>
        </div>
    </div>
</nav><!-- Fin Navegacion -->