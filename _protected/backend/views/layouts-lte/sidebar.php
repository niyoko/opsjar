<?php 
    use common\components\Sidebar;
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/images/opsjar_logo.png" alt="Opsjar Logo" class="brand-image" style="opacity: .8">
        <span class="brand-text font-weight-light">&nbsp;</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="/images/no-pict.png" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= Yii::$app->user->identity->username ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    // ['label' => 'Beranda', 'icon' => 'th', 'badge' => '<span class="right badge badge-danger">New</span>'],
                    ['label' => 'Beranda', 'icon' => 'fa-solid fa-chart-pie', 'url' => ['/report/import-data'], 'active' => Sidebar::active(['report'])],
                    ['label' => 'Peta Kerawanan', 'url' => ['/provinsi'], 'icon' => 'fa-solid fa-map', 'active' => Sidebar::active(['provinsi'])],
                    ['label' => 'Bimbingan Teknis',  'icon' => 'fa-solid fa-lightbulb', 'url' => ['/bimtek'], 'active' => Sidebar::active(['bimtek'])],
                    ['label' => 'Anggota',  'icon' => 'fa-solid fa-users', 'url' => ['/anggota'], 'active' => Sidebar::active(['anggota'])],
                    ['label' => 'Capaian', 'icon' => 'fa-solid fa-tasks', 'url' => ['/capaian'], 'active' => Sidebar::active(['capaian'])],
                    ['label' => 'Anggaran', 'icon' => 'fa-solid  fa-credit-card','active' => Sidebar::active(['anggaran']), 'url' => ['/anggaran'] ],
                    ['label' => 'Setting', 'icon' => 'fa-solid fa-cog', 'url' => ['/user'], 'active' => Sidebar::active(['user'])],
                    ['label' => 'Logout', 'icon' => 'fa-solid fa-arrow-right', 'url' => ['/site/logout']],
                 
                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

