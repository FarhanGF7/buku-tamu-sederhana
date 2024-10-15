<?php 
$page_title = "Rekapitulasi | Buku Kunjungan";
include "header.php"; 
?>
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h2 mb-0 text-gray-800">Rekap Data Kunjungan  </h1>
</div>

<!-- Awal Row -->
<div class="row">
    <!-- Awal col-md-12 -->
    <div class="col-md-12">
        <!-- Awal card -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Rekapitulasi Pengunjung</h6>
            </div>
            <div class="card-body">
                <form action="" method="POST" class="text-center">
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Dari Tanggal</label>
                                <input class="form-control" type="date" name="tanggal1" value="<?= isset($_POST['tanggal1']) ? $_POST['tanggal1'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Hingga Tanggal</label>
                                <input class="form-control" type="date" name="tanggal2" value="<?= isset($_POST['tanggal2']) ? $_POST['tanggal2'] : date('Y-m-d') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-2">
                            <button class="btn btn-primary form-control" name="btampilkan">
                                <i class="fa fa-search"></i> Tampilkan
                            </button>

                        </div>
                        <div class="col-md-2">
                            <a href="admin.php" class="btn btn-outline-danger form-control">
                                <i class="fa fa-backward"></i> Kembali
                            </a>
                        </div>
                    </div>
                </form>

                <?php if (isset($_POST['btampilkan'])) : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Tanggal</th>
                                <th>Nama Pengunjung</th>
                                <th>Alamat</th>
                                <th>Tujuan</th>
                                <th>No. HP</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Dapatkan tanggal yang dipilih
                                $tanggal1 = $_POST['tanggal1'];
                                $tanggal2 = $_POST['tanggal2'];

                                // Perbarui query SQL untuk memfilter berdasarkan rentang tanggal yang dipilih dan urutkan berdasarkan tanggal saja
                                $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu WHERE DATE(tanggal) BETWEEN '$tanggal1' AND '$tanggal2' ORDER BY DATE(tanggal) ASC");

                                // Periksa apakah ada kesalahan dalam query
                                if (!$tampil) {
                                    echo "Kesalahan: " . mysqli_error($koneksi);
                                };

                                $no = 1;
                                if (mysqli_num_rows($tampil) > 0) { // Periksa apakah ada hasil
                                    while ($data = mysqli_fetch_array($tampil)) { ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['tanggal'] ?></td>
                                            <td><?= $data['nama'] ?></td>
                                            <td><?= $data['alamat'] ?></td>
                                            <td><?= $data['tujuan'] ?></td>
                                            <td><?= $data['nope'] ?></td>
                                        </tr>
                                    <?php 
                                    }
                                }
                            ?>

                        </tbody>
                    </table>
                    
                    
                    <div class="row justify-content-center">
                        <div class="col-md-2">
                            <form action="exportexcel.php" method="POST">
                                <input type="hidden" name="tanggala" value="<?= @$_POST['tanggal1'] ?>">  
                                <input type="hidden" name="tanggalb" value="<?= @$_POST['tanggal2'] ?>">
                                <button class="btn btn-success form-control" name="bexport">
                                    <i class="fas fa-file-excel-o"></i> Export Data Excel
                                </button>
                            </form>
                        </div>
                    </div>
                    <br>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Akhir card -->
    </div>
    <!-- Akhir col-md-12 -->
</div>
<!-- Akhir Row -->


<?php include "footer.php"; ?>