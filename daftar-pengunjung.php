<?php include "header.php"; ?>

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Daftar Kunjungan</h1>
</div>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data Pengunjung Keseluruhan</h6>
    </div>
    <div class="card-body">
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#visitorModal"><i class="fa fa-plus-square"></i> Isi Kunjungan</button>
        <form action="exportkeseluruhan.php" method="post" class="d-none d-sm-inline-block mb-3">
            <button type="submit" name="bexport" class="btn btn-outline-primary shadow-sm mb-3">
                <i class="fas fa-download fa-sm"></i> Excel
            </button>
        </form>

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
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch all visitor data from the database
                    $tampil = mysqli_query($koneksi, "SELECT * FROM ttamu ORDER BY tanggal DESC");
                    $no = 1;
                    while ($data = mysqli_fetch_array($tampil)) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $data['tanggal'] ?></td>
                            <td><?= $data['nama'] ?></td>
                            <td><?= $data['alamat'] ?></td>
                            <td><?= $data['tujuan'] ?></td>
                            <td><?= $data['nope'] ?></td>
                            <td>
                                <a href="update.php" class="btn btn-warning btn-sm shadow-sm" data-toggle="modal" data-target="#updateModal<?= $data['id'] ?>">Edit</a> <!-- Tombol update yang memicu modal -->
                                <button class="btn btn-danger btn-sm shadow-sm" data-toggle="modal" data-target="#deleteModal<?= $data['id'] ?>">Hapus</button>
                            </td>
                        </tr>
                        <?php include 'delete.php'; ?>
                    <?php }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include 'form.php'; ?>

<?php include 'update.php'; ?>



<?php include "footer.php"; ?>
