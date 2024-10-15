<?php include "header.php"; ?>
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Selamat Datang di Daftar Kunjungan Wajib Pajak <br>UPTD Pendapatan Daerah Wilayah 4 </h1>                        
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <?php
                            // setting awal timezone
                            date_default_timezone_set('Asia/Makassar');

                            // menampilkan tanggal sekarang
                            $tgl_sekarang = date('Y-m-d');

                            // menampilkan tanggal kemaren
                            $kemarin = date(
                                'Y-m-d',
                                strtotime('-1 day', strtotime(date('Y-m-d')))
                            );

                            // mendapatkan 6 hari sebelum tgl skrg
                            $seminggu = date(
                                'Y-m-d H:i:s',
                                strtotime('-1 week +1 day', strtotime($tgl_sekarang))
                            );

                            // menampilkan waktu sekarang
                            $sekarang = date('Y-m-d H:i:s');

                            // menampilkan bulan ini
                            $bulan_ini = date('m');

                            // query tampilan data pengunjung
                            $tgl_sekarang = mysqli_fetch_array(
                                mysqli_query(
                                    $koneksi,
                                    "SELECT count(*) FROM ttamu WHERE tanggal like '%$tgl_sekarang%'"
                                )
                            );

                            $kemarin = mysqli_fetch_array(
                                mysqli_query(
                                    $koneksi,
                                    "SELECT count(*) FROM ttamu WHERE tanggal like '%$kemarin%'"
                                )
                            );

                            $seminggu = mysqli_fetch_array(
                                mysqli_query(
                                    $koneksi,
                                    "SELECT count(*) FROM ttamu WHERE tanggal BETWEEN '$seminggu' and '$sekarang'"
                                )
                            );

                            $sebulan = mysqli_fetch_array(
                                mysqli_query(
                                    $koneksi,
                                    "SELECT count(*) FROM ttamu WHERE month(tanggal) = '$bulan_ini'"
                                )
                            );

                            $keseluruhan = mysqli_fetch_array(
                                mysqli_query($koneksi, 'SELECT count(*) FROM ttamu')
                            );
                        ?>

                        <!-- Statistik Pengunjung Hari Ini -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-x font-weight-bold text-primary text-uppercase mb-1">
                                                Hari ini
                                            </div>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $tgl_sekarang[0] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-clock fa-3x text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Pengunjung Minggu Ini -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-x font-weight-bold text-success text-uppercase mb-1">
                                                Minggu ini
                                            </div>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $seminggu[0] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-3x text-success"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Pengunjung Bulan Ini -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-x font-weight-bold text-info text-uppercase mb-1">
                                                Bulan Ini
                                            </div>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $sebulan[0] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar-alt fa-3x text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Statistik Secara Keseluruhan -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-x font-weight-bold text-warning text-uppercase mb-1">
                                                Keseluruhan
                                            </div>
                                            <div class="h4 mb-0 font-weight-bold text-gray-800"><?= $keseluruhan[0] ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-chart-bar fa-3x text-warning"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Content Column -->
                        <div class="col-lg-12 mb-4">
                            <!-- DataTales Example -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Hari ini [<?= date(
                                        'd-m-Y'
                                    ) ?>]</h6>
                                </div>
                                <div class="card-body">
                                <form action="exportnow.php" method="post" class="d-none d-sm-inline-block mb-3">
                                    <button type="submit" name="bexport" class="btn btn-outline-primary shadow-sm mb-3">
                                        <i class="fas fa-download fa-sm"></i> Excel
                                    </button>
                                </form>

                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>No. </th>
                                                    <th>Tanggal</th>
                                                    <th>Nama Pengunjung</th>
                                                    <th>Alamat</th>
                                                    <th>Tujuan</th>
                                                    <th>No. HP</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $tgl = date('Y-m-d');
                                                $tampil = mysqli_query(
                                                    $koneksi,
                                                    "SELECT * FROM ttamu WHERE tanggal like '%$tgl%' ORDER BY tanggal ASC"
                                                );
                                                $no = 1;
                                                while ($data = mysqli_fetch_array($tampil)) { ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td><?= $data['tanggal'] ?></td>
                                                        <td><?= $data['nama'] ?></td>
                                                        <td><?= $data['alamat'] ?></td>
                                                        <td><?= $data['tujuan'] ?></td>
                                                        <td><?= $data['nope'] ?></td>
                                                    </tr>
                                                <?php }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                    </div>

             

<?php include "footer.php"; ?>