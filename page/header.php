<?php

// Mulai sesi
session_start();

// Tentukan durasi timeout dalam detik (30 menit = 1800 detik)
$timeout_duration = 1800;

// Periksa apakah variabel sesi untuk aktivitas terakhir disetel
if (isset($_SESSION['LAST_ACTIVITY'])) {
    // Hitung umur sesi
    $session_life = time() - $_SESSION['LAST_ACTIVITY'];

    // Jika sesi telah kedaluwarsa
    if ($session_life > $timeout_duration) {
        // Hapus variabel sesi
        session_unset();
        session_destroy();

        // Redirect ke halaman login dengan pesan
        echo "<script>
            alert('Sesi telah kedaluwarsa. Silakan login kembali untuk melanjutkan.');
            document.location='login.php';
            </script>";
        exit();
    }
}

// Perbarui timestamp aktivitas terakhir
$_SESSION['LAST_ACTIVITY'] = time();

// Buat token CSRF jika belum disetel
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Periksa apakah variabel sesi disetel
if (empty($_SESSION['username']) || empty($_SESSION['password']) || empty($_SESSION['nama_pengguna'])) {
    echo "<script>
        alert('Maaf, untuk mengakses halaman ini, Anda diharuskan Login terlebih dahulu..!!');
        document.location='login.php';
        </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo isset($page_title) ? $page_title : 'Default Title'; ?></title>

    <!-- Custom fonts for this template-->
    <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="icon" href="../assets/img/logo.jpg" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/font-awesome.min.css" integrity="sha512-Fo3rlrZj/k7ujTnDd2eOvqHU0FgEYZh65O1JbV0FlJzFv4g+JkTkaKtL0pvkwkZgoBmKPqad8htBRY5Rhz7Vg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="base.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <img src="../assets/img/logo.jpg" alt="" style="width: 30px; height: auto; border-radius: 50px;">
                </div>
                <div class="sidebar-brand-text mx-3">Buku Tamu</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'base.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="base.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">Menu</div>

            <!-- Nav Item - Daftar Pengunjung -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'daftar-pengunjung.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="daftar-pengunjung.php ">
                    <i class="fas fa-fw fa-address-book"></i>
                    <span>Daftar Pengunjung</span></a>
            </li>

            <!-- Nav Item - Rekap -->
            <li class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'rekapitulasi.php' ? 'active' : ''; ?>">
                <a class="nav-link" href="rekapitulasi.php ">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Rekapitulasi</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION['nama_pengguna']); ?></span>
                                <img class="img-profile rounded-circle" src="../assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="account_profil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php include "../database/koneksi.php"; ?>
