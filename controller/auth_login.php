<?php 
session_start();

// Koneksi database
include "../database/koneksi.php";

// Sanitasi input pengguna
$username = mysqli_escape_string($koneksi, $_POST['username']);
$password = md5($_POST['password']); // Hash password

// Query untuk memeriksa kredensial pengguna
$login = mysqli_query($koneksi, "SELECT * FROM tuser WHERE username = '$username' 
AND password = '$password' AND status = 'Aktif' ");

$data = mysqli_fetch_array($login);

// koneksi login page
include "../page/login.php"; 

// Periksa apakah username dan password benar
if ($data) {
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['password'] = $data['password'];
    $_SESSION['nama_pengguna'] = $data['nama_pengguna'];
    
    // Set session login status
    $_SESSION['loggedin'] = true;

    // Redirect ke halaman admin
    echo '<script>document.location = "../page/base.php";</script>';
} else {
    // Modal HTML untuk kesalahan login
    echo '
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">      
                    <h5 class="modal-title" id="errorModalLabel">Kesalahan Login</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Username atau password yang Anda masukkan salah.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="window.location.href=\'../page/login.php\'">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $("#errorModal").modal("show");
        });
    </script>
    ';
}
?>
