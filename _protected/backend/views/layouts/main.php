<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\components\Sidebar;
use common\widgets\Alert;
use yii\bootstrap5\BootstrapPluginAsset;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

AppAsset::register($this);
BootstrapPluginAsset::register($this);
$this->registerCssFile('https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp');
$this->registerCssFile('https://fonts.googleapis.com/css?family=Noto Sans');
$this->registerJsFile('https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="/images/opsjar_favicon_42x42.png">
    <?php $this->registerCsrfMetaTags() ?>
    <title>Opsjar.site <?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <style>
        body {
            height: 100% !important;
        }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <?php $this->beginBody() ?>
    <?php if(!Yii::$app->user->isGuest): ?>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark  navbar-dark bg-dark border-bottom border-white">
                <div class="container-fluid">
                    <a class="navbar-brand abs" href="/"><img height="30px" src="/images/opsjar_logo.png" alt="Opsjar Logo" class="brand-image" style="opacity: .8"></a>
                    <button class="navbar-toggler ms-auto collapsed" type="button" data-bs-toggle="collapsed" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar-collapse collapse" id="navbarCollapse">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link <?= Sidebar::active('site') ? 'active' : '' ?>" href="/">Beranda</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link <?= Sidebar::active('provinsi', ['view']) ? 'active' : '' ?>" href="/provinsi/view">Peta Kerawanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= Sidebar::active('bimtek') ? 'active' : '' ?>" href="/bimtek">Bimbingan Teknis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= Sidebar::active('anggaran') ? 'active' : '' ?>" href="/anggaran">Anggaran</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= Sidebar::active('anggota') ? 'active' : '' ?>" href="/anggota">Anggota</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link <?= Sidebar::active('capaian') ? 'active' : '' ?>" href="/capaian">Capaian</a>
                            </li>
                            <li class="nav-item">
                                <a  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout" class="nav-link text-warning <?= Sidebar::active('logout') ? 'active' : '' ?>" href="/site/logout"><span class="material-icons-outlined">
                                        logout
                                    </span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
    <?php endif ?>
    <main role="main" class="flex-shrink-0">
        <div class="container-fluid p-2">
            <?= Alert::widget() ?>
            <div class="p-2"><?= $content ?></div>
        </div>
    </main>


    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage();
