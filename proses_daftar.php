<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    memprosesPengirimanForm();
}

header('Location: daftar.php');
exit;

/* Memproses pengiriman form dan menangani unggah file serta penyisipan data ke database. */
function memprosesPengirimanForm() {
    $direktoriUnggah = 'uploads/';
    $berkas = $_FILES['berkas'];
    $namaBerkas = menghasilkanNamaUnik($berkas['name']);

    // Validasi ekstensi file
    $ext = pathinfo($berkas['name'], PATHINFO_EXTENSION);
    if (strtolower($ext) !== 'pdf') {
        $_SESSION['error'] = 'Hanya file dengan format PDF yang diperbolehkan.';
        header('Location: daftar.php');
        exit;
    }

    // Proses unggah berkas
    if (mengunggahBerkas($berkas['tmp_name'], $direktoriUnggah . $namaBerkas)) {
        $data = [
            $_POST['nama'],
            $_POST['email'],
            $_POST['hp'],
            $_POST['semester'],
            $_POST['ipk'],
            $_POST['jenis_beasiswa'],
            $namaBerkas
        ];

        menyisipkanDataPendaftaran($data);
        mengalihdatangkanKeHalamanHasil();
    } else {
        $_SESSION['error'] = 'Gagal mengunggah berkas. Silakan coba lagi.';
        header('Location: daftar.php');
        exit;
    }
}

/* Menghasilkan nama berkas yang unik. */
function menghasilkanNamaUnik($namaAsli) {
    return time() . '_' . $namaAsli;
}

/* Mengunggah berkas ke tujuan yang ditentukan. */
function mengunggahBerkas($sumberPath, $tujuanPath) {
    if (move_uploaded_file($sumberPath, $tujuanPath)) {
        return true;
    }
    return false;
}

/* Menyisipkan data formulir ke dalam tabel pendaftaran. */
function menyisipkanDataPendaftaran($data) {
    global $pdo;

    $sql = "INSERT INTO pendaftaran (nama, email, no_hp, semester, ipk, 
            jenis_beasiswa, berkas, status_ajuan) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 'Belum di verifikasi')";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
}

/* Mengalihkan pengguna ke halaman hasil.php */
function mengalihdatangkanKeHalamanHasil() {
    header('Location: hasil.php');
    exit;
}
