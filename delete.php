<?php
include 'koneksi.php'; // Pastikan koneksi database sudah ada

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk menghapus data
    $query = "DELETE FROM ttamu WHERE id='$id'";
    
    if (mysqli_query($koneksi, $query)) {
        // Redirect atau pesan sukses
        
        echo "<script>alert('Hapus data Sukses, Terima Kasih..!');
            document.location='daftar-pengunjung.php?'</script>";
    } else {
        // Redirect atau pesan error
        echo "<script>alert('Hapus data GAGAL: " .
            mysqli_error($koneksi) .
            "');
            document.location='daftar-pengunjung.php?'</script>";
    }
}
?>

<!-- Modal untuk Konfirmasi Hapus -->
<div class="modal fade" id="deleteModal<?= $data['id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $data['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel<?= $data['id'] ?>">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus data pengunjung dengan nama <strong><?= $data['nama'] ?></strong>?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <a href="delete.php?id=<?= $data['id'] ?>" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>