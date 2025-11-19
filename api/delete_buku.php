<?php
// Set Header untuk mengizinkan akses dari domain lain (CORS)
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// --------------------------------------------------------
// ⚠️ KONFIGURASI KONEKSI DATABASE - HARUS DIGANTI ⚠️
// --------------------------------------------------------
$host = "localhost"; // Ganti dengan IP/Host database hosting Anda
$user = "root";      // Ganti dengan username database hosting Anda
$pass = "";          // Ganti dengan password database hosting Anda
$db   = "perpustakaan_simpel"; // Pastikan ini nama database yang benar

$conn = new mysqli($host, $user, $pass, $db);

// Cek koneksi
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Koneksi database gagal: " . $conn->connect_error]);
    exit;
}

// --------------------------------------------------------
// 📦 Proses Penghapusan
// --------------------------------------------------------

// Ambil data JSON dari body request POST (dari JavaScript)
$data = json_decode(file_get_contents("php://input"), true);

// Pastikan 'id' buku dikirim dan merupakan integer
$id = isset($data["id"]) ? intval($data["id"]) : 0;

if ($id > 0) {
    // 🗑️ Query DELETE
    $sql = "DELETE FROM buku WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        // Berhasil dihapus
        // Tambahan: Pastikan stok juga terupdate jika ada logic stok
        echo json_encode(["status" => "success", "message" => "Buku berhasil dihapus."]);
    } else {
        // Gagal dieksekusi
        echo json_encode(["status" => "error", "message" => "Gagal menghapus buku: " . $conn->error]);
    }
} else {
    // ID tidak ditemukan dalam request
    echo json_encode(["status" => "error", "message" => "ID buku tidak valid."]);
}

$conn->close();
?>