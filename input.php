<?php
// Konfigurasi MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "penyakit";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengecek jika data form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['kecamatan'])) {
    // Ambil data dari form
    $kecamatan = $_POST['kecamatan'];
    $tahun = $_POST['tahun'];
    $tb_paru = $_POST['tb_paru'];
    $pneumonia_balita = $_POST['pneumonia_balita'];
    $dbd = $_POST['dbd'];
    $jumlah = $_POST['jumlah'];
    $luas = $_POST['luas'];
    $jumlah_pddk = $_POST['jumlah_pddk'];
    $longitude = $_POST['longitude'];
    $latitude = $_POST['latitude'];
    
    
    // Persiapan query menggunakan prepared statements
    $stmt = $conn->prepare("INSERT INTO prevalensi_penyakit (kecamatan, tahun, tb_paru, pneumonia_balita, dbd, jumlah, luas, jumlah_pddk,  longitude, latitude) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("siiiiiiddd", $kecamatan, $tahun, $tb_paru, $pneumonia_balita, $dbd, $jumlah, $luas, $jumlah_pddk, $longitude, $latitude);


    // Eksekusi query
    if ($stmt->execute()) {
        echo "Data berhasil disimpan. <a href='index.php'>Lihat Data</a>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
}

$conn->close();
?>
