<?php if (session()->has('diskon')): ?>
    <style>
        body {
            padding-top: 60px; /* geser isi ke bawah */
        }
        #header {
            top: 30px !important; /* header turun sedikit */
        }
        .banner-diskon {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1030;
            font-size: 14px; /* kecilkan font */
            padding: 4px 0;   /* tipiskan tinggi */
        }
    </style>

    <div class="alert alert-info text-center mb-0 banner-diskon" role="alert">
        🎉 Diskon Hari Ini: <strong>Rp<?= number_format(session('diskon'), 0, ',', '.') ?></strong> 🎉
    </div>
<?php endif; ?>

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="<?= base_url() ?>NiceAdmin/assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">Toko</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div>

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">
            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle" href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- Notifikasi, pesan, dll bisa disisipkan di sini -->

            <li class="nav-item dropdown pe-3">
                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    <img src="<?= base_url('assets/img/profile-img.jpg') ?>" alt="Profile" class="rounded-circle">
                    <span class="d-none d-md-block dropdown-toggle ps-2">
                        <?= session()->get('username'); ?> (<?= session()->get('role'); ?>)
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                    <li class="dropdown-header">
                        <h6><?= session()->get('username'); ?></h6>
                        <span><?= session()->get('role'); ?></span>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="<?= base_url('logout') ?>">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>
    </nav>

</header><!-- End Header -->
