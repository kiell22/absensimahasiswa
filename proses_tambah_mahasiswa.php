<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $prodi = $_POST['prodi'];
    $semester = $_POST['semester'];
    
    // Cek apakah NIM sudah ada
    $check_sql = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        echo "<script>alert('NIM sudah terdaftar!'); window.location.href='tambah_mahasiswa.php';</script>";
        exit();
    }
    
    // Insert data mahasiswa
    $sql = "INSERT INTO mahasiswa (nim, nama, prodi, semester) 
            VALUES ('$nim', '$nama', '$prodi', '$semester')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data mahasiswa berhasil ditambahkan!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>