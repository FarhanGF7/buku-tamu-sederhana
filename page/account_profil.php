<?php 
$page_title = "Profil Akun | Buku Kunjungan";
include "header.php"; 
?>

<?php 
include "../database/koneksi.php"; // Sertakan koneksi database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    echo "<p>Anda harus login untuk melihat halaman ini.</p>";
    exit; // Hentikan eksekusi jika belum login
}

$user_id = $_SESSION['id_user']; // Ambil id_user dari pengguna yang sedang login

// Ambil data pengguna
$sql = "SELECT username, password, nama_pengguna, status FROM tuser WHERE id_user = ?"; // Gunakan id_user untuk filter
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("i", $user_id); // Ikat parameter user_id
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();

$message = ''; // Variabel untuk menyimpan pesan modal

// Tangani perubahan password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Cek apakah password baru dan konfirmasi password cocok
    if ($new_password === $confirm_password) {
        // Hash password baru menggunakan MD5
        $hashed_password = md5($new_password);
        
        // Update password di database
        $update_sql = "UPDATE tuser SET password = ? WHERE id_user = ?";
        $update_stmt = $koneksi->prepare($update_sql);
        $update_stmt->bind_param("si", $hashed_password, $user_id);
        $update_stmt->execute();
        
        // Cek apakah password berhasil diubah
        if ($update_stmt->affected_rows > 0) {
            $message = "Password berhasil diubah.";
        } else {
            $message = "Gagal mengubah password.";
        }
        
        $update_stmt->close();
    } else {
        $message = "Password baru dan konfirmasi password tidak cocok.";
    }
}
?>



<div class="col-xl-8">
    <!-- Kartu detail akun-->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Detail Akun
            </h6>
        </div>
        <div class="card-body">
            <form id="changePasswordForm" method="POST">
                <!-- Form Group (Username)-->
                <div class="mb-3">
                    <label class="small mb-1" for="inputUsername">Username</label>
                    <input class="form-control" id="inputUsername" type="text" placeholder="Username.." value="<?php echo htmlspecialchars($user_data['username']); ?>" readonly />
                </div>
                <!-- Form Group (Nama)-->
                <div class="mb-3">
                    <label class="small mb-1" for="inputFirstName">Nama</label>
                    <input class="form-control" id="inputFirstName" type="text" placeholder="Nama.." value="<?php echo htmlspecialchars($user_data['nama_pengguna']); ?>" readonly />
                </div>
                <!-- Form Group (Status)-->
                <div class="mb-3">
                    <label class="small mb-1" for="inputLastName">Status</label>
                    <input class="form-control" id="inputLastName" type="text" placeholder="Status.." value="<?php echo htmlspecialchars($user_data['status']); ?>" readonly />
                </div>
                <!-- Form Group (Password)-->
                <div class="mb-3">
                    <label class="small mb-1" for="inputPassword">Password Hashed MD5</label>
                    <input class="form-control" id="inputPassword" name="text" type="text" value="<?php echo htmlspecialchars($user_data['password']); ?>" readonly />
                </div>
                <!-- Catatan -->
                <div class="alert alert-info">
                    <small>
                    Catatan: Password ditampilkan dalam hash MD5. Untuk melihat password asli, Anda dapat menggunakan layanan dekripsi MD5 online.
                    </small>
                </div>

                <!-- Form Group (Password Baru)-->
                <div class="mb-3">
                    <label class="small mb-1" for="newPassword">Password Baru</label>
                    <input class="form-control" id="newPassword" name="new_password" type="text" placeholder="Masukkan password baru" required />
                </div>
                <!-- Form Group (Konfirmasi Password)-->
                <div class="mb-3">
                    <label class="small mb-1" for="confirmPassword">Konfirmasi Password</label>
                    <input class="form-control" id="confirmPassword" name="confirm_password" type="text" placeholder="Konfirmasi password baru" required />
                </div>
                <!-- Tombol Submit-->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">Ubah Password</button>
            </form>
        </div>
    </div>
</div>

<!-- Modal Dialog untuk Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Perubahan Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin mengubah password?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tidak</button>
                <button type="button" class="btn btn-primary" id="confirmYesButton">Ya</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Dialog untuk Pesan Status -->
<div class="modal fade" id="validationModal" tabindex="-1" aria-labelledby="validationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="validationModalLabel">Status Perubahan Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                <?php echo htmlspecialchars($message); ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<?php 
// Tutup koneksi database
$koneksi->close(); 
?>

<?php include "footer.php"; ?>

<!-- Trigger Modal jika ada pesan -->
<?php if (!empty($message)): ?>
    <script>
        var validationModal = new bootstrap.Modal(document.getElementById('validationModal'));
        validationModal.show();
    </script>
<?php endif; ?>

<script>
    // Tangani klik tombol "Ya" pada modal konfirmasi
    document.getElementById('confirmYesButton').addEventListener('click', function () {
        // Kirim form setelah konfirmasi
        document.getElementById('changePasswordForm').submit();
    });
</script>
