<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nim = $_POST['nim'];
    $status = $_POST['status'];
    $tanggal = date('Y-m-d');
    $jam_masuk = date('H:i:s');
    
    // Cek apakah mahasiswa sudah absen hari ini
    $check_sql = "SELECT * FROM absensi WHERE nim = '$nim' AND tanggal = '$tanggal'";
    $check_result = $conn->query($check_sql);
    
    if ($check_result->num_rows > 0) {
        echo "<script>alert('Anda sudah melakukan absensi hari ini!'); window.location.href='index.php';</script>";
        exit();
    }
    
    // Cek apakah mahasiswa terdaftar
    $mahasiswa_sql = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
    $mahasiswa_result = $conn->query($mahasiswa_sql);
    
    if ($mahasiswa_result->num_rows == 0) {
        echo "<script>alert('NIM tidak terdaftar!'); window.location.href='index.php';</script>";
        exit();
    }
    
    // Insert data absensi
    $sql = "INSERT INTO absensi (nim, tanggal, jam_masuk, status) 
            VALUES ('$nim', '$tanggal', '$jam_masuk', '$status')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Absensi berhasil dicatat!'); window.location.href='index.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>