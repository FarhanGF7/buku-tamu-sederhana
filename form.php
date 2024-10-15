<?php 
include 'koneksi.php';

// Uji Jika tombol simpan diklik
if (isset($_POST['bsimpan'])) {
    // htmlspecialchars agar inputan lebih aman dari injection
    $nama = htmlspecialchars($_POST['nama'], ENT_QUOTES);
    $alamat = htmlspecialchars($_POST['alamat'], ENT_QUOTES);
    $tujuan = htmlspecialchars($_POST['tujuan'], ENT_QUOTES);
    $nope = htmlspecialchars($_POST['nope'], ENT_QUOTES);
    
    // persiapan query simpan data
    $simpan = mysqli_query(
        $koneksi,
        "INSERT INTO ttamu (nama, alamat, tujuan, nope) VALUES
    ('$nama', '$alamat', '$tujuan', '$nope')"
    ); // Hapus kolom tanggal dari query

    // uji simpan data jika sukses
    if ($simpan) {
        echo "<script>alert('Simpan data Sukses, Terima kasih..!');
            document.location='base.php?'</script>";
    } else {
        echo "<script>alert('Simpan data GAGAL: " .
            mysqli_error($koneksi) .
            "');
            document.location='base.php?'</script>"; // Tampilkan error dari MySQL
    }
} 

?>

        <!-- Modal for Visitor Form -->
        <div class="modal fade" id="visitorModal" tabindex="-1" role="dialog" aria-labelledby="visitorModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="visitorModalLabel">Identitas Pengunjung</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="user" method="POST" action="form.php"> 
                            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>" /> <!-- CSRF Token -->
                            <div class="mb-3 form-group">
                                <label for="nama">Nama Pengunjung</label>
                                <input type="text" class="form-control" name="nama" placeholder="Nama.." required />
                            </div>
                            <div class="mb-0 form-group">
                                <label for="alamat">Alamat</label>
                                <textarea class="form-control" name="alamat" placeholder="Contoh: Jl. Biawan..." required rows="3"></textarea>
                            </div>
                            <div class="mb-3 form-group">
                                <label for="tujuan">Tujuan</label>
                                <input type="text" class="form-control" name="tujuan" placeholder="Contoh: Data Baru PBB" required />
                            </div>
                            <div class="mb-3 form-group">
                                <label for="nope">No. HP</label>
                                <input type="text" class="form-control" name="nope" placeholder="08123..." required />
                            </div>
                            <button type="submit" name="bsimpan" class="btn btn-primary btn-user btn-block">Simpan Data</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>