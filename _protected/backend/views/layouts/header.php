<?php

use common\components\Sidebar;
use yii\bootstrap5\Html;
use yii\bootstrap5\Nav;
use yii\bootstrap5\NavBar;

?>




<?php
    NavBar::begin([
        'brandLabel' => '<img height="30px" src="/images/opsjar_logo.png" alt="Opsjar Logo" class="brand-image" style="opacity: .8">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark bg-dark fixed-top d-flex border-bottom border-white',
        ],
    ]);
    $menuItems = [
        ['label' => 'Beranda', 'url' => ['/site'],'linkOptions' => ['class' => Sidebar::active(['site'])]],
        ['label' => 'Peta Kerawanan', 'url' => ['/provinsi/map'], 'linkOptions' => ['class' => Sidebar::active(['provinsi'], ['map'])]],
        ['label' => 'Anggota', 'url' => ['/anggota'],'linkOptions' => ['class' => Sidebar::active(['anggota'])]],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    }     
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav me-auto mb-2 mb-md-0'],
        'items' => $menuItems,
    ]);
    if (Yii::$app->user->isGuest) {
        echo Html::tag('div',Html::a('Login',['/site/login'],['class' => ['btn btn-link login text-decoration-none']]),['class' => ['d-flex']]);
    } else {
        echo Html::beginForm(['/site/logout'], 'post', ['class' => 'd-flex'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout text-decoration-none']
            )
            . Html::endForm();
    }
    NavBar::end();
    ?>


<!-- right -->

<nav class="navbar navbar-expand-md navbar-dark  navbar-dark bg-dark border-bottom border-white nabar-main">
    <div class="container-fluid">
        <a class="navbar-brand abs" href="/"><img height="30px" src="/images/opsjar_logo.png" alt="Opsjar Logo" class="brand-image" style="opacity: .8"></a>
        <button class="navbar-toggler ms-auto collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w0-collapse" class="navbar-collapse collapse" style="">
        <div class="navbar-collapse collapse" id="collapseNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?= Sidebar::active('site') ? 'active' : '' ?>" href="/">Beranda</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link <?= Sidebar::active('provinsi',['view']) ? 'active' : '' ?>" href="/provinsi/view">Peta Kerawanan</a>
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
            </ul>
        </div>
    </div>
</nav>