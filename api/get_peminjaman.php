<?php

header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// KRITIS: KONEKSI KE perpustakaan_simpel
$conn = new mysqli("localhost", "root", "", "perpustakaan_simpel");
if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => $conn->connect_error]);
  exit;
}

// Menambahkan tipe permintaan untuk Daftar Siswa/Peminjam Unik
$type = isset($_GET["type"]) ? $conn->real_escape_string($_GET["type"]) : "peminjaman";

// Logika 1: Ambil Daftar Siswa Unik (untuk menu operator)
if ($type === 'siswa_list') {
    $sql = "SELECT DISTINCT nama, kelas FROM peminjaman ORDER BY nama ASC";
    $result = $conn->query($sql);
    $data = [];

    if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        $data[] = $row;
      }
    }
    
    echo json_encode($data);
    $conn->close();
    exit; // Hentikan eksekusi setelah mengirim data siswa
}

// Logika 2 (Default): Ambil Data Peminjaman (Aktif atau Riwayat)
$status = isset($_GET["status"]) ? $conn->real_escape_string($_GET["status"]) : null;

if ($status === 'ya' || $status === 'tidak') {
  $stmt = $conn->prepare("SELECT * FROM peminjaman WHERE dikembalikan = ? ORDER BY tanggal_pinjam DESC");
  $stmt->bind_param("s", $status);
} else {
  $stmt = $conn->prepare("SELECT * FROM peminjaman ORDER BY tanggal_pinjam DESC");
}

$stmt->execute();
$result = $stmt->get_result();
$data = [];
// ... (lanjutan rendering data)
if ($result && $result->num_rows > 0) {
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }
}

echo json_encode($data);
$stmt->close();
$conn->close();
?>