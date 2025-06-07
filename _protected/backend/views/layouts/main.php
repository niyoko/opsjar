<?php

/** @var \yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use common\components\Roles;
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
$this->registerCssFile('https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,100..900;1,100..900&display=swap');
$this->registerCssFile('https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200');
$this->registerJsFile('https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js');
$this->registerCss(<<<CSS
  .material-symbols-outlined {
    font-variation-settings:
    'FILL' 1,
    'wght' 400,
    'GRAD' 0,
    'opsz' 24
  }
CSS);
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
    <?php if (!Yii::$app->user->isGuest): ?>
        <header>
            <nav class="navbar navbar-expand-md navbar-dark  navbar-dark bg-dark border-bottom border-white">
                <div class="container-fluid">
                    <a class="navbar-brand abs" href="/"><img height="30px" src="/images/opsjar_logo.png" alt="Opsjar Logo" class="brand-image" style="opacity: .8"></a>
                    <button class="navbar-toggler ms-auto collapsed" type="button" data-bs-toggle="collapsed" data-bs-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="navbar text-white" id="navbarCollapse">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item">
                                <a class="nav-link text-white <?= Sidebar::active('site') ? 'active' : '' ?>" href="/">Beranda</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link text-white <?= Sidebar::active('provinsi', ['view']) ? 'active' : '' ?>" href="/provinsi/view">Peta Kerawanan</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= Sidebar::active('bimtek') ? 'active' : '' ?>" href="/bimtek">Bimbingan Teknis</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= Sidebar::active('anggaran') ? 'active' : '' ?>" href="/anggaran">Anggaran</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= Sidebar::active('anggota') ? 'active' : '' ?>" href="/anggota">Anggota</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white <?= Sidebar::active('capaian') ? 'active' : '' ?>" href="/capaian">Capaian</a>
                            </li>
                            <?php if (isset(Yii::$app->user->identity->role) && Yii::$app->user->identity->role == Roles::ROLE_ADMIN) : ?>
                                <li class="nav-item">
                                    <a class="nav-link text-warning" href="/report">
                                        <span class="flex items-center gap-1">
                                            <span class="material-icons-outlined">arrow_back</span>
                                            <span>Kembali</span>
                                        </span>
                                    </a>
                                </li>
                            <?php else : ?>
                                <li class="nav-item">
                                    <a data-bs-toggle="tooltip" data-bs-placement="bottom" title="Logout" class="nav-link text-warning <?= Sidebar::active('logout') ? 'active' : '' ?>" href="/site/logout">
                                        <span class="material-icons-outlined">logout</span>
                                    </a>
                                </li>
                            <?php endif; ?>
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
