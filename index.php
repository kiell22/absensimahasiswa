<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Absensi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; }
        .table-responsive { margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Sistem Absensi Mahasiswa</h1>
        
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5>Form Absensi</h5>
                    </div>
                    <div class="card-body">
                        <form action="proses_absensi.php" method="post">
                            <div class="mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control" id="nim" name="nim" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="Hadir">Hadir</option>
                                    <option value="Izin">Izin</option>
                                    <option value="Sakit">Sakit</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Absensi</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5>Pencarian Absensi</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="get">
                            <div class="mb-3">
                                <label for="tanggal" class="form-label">Tanggal</label>
                                <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= date('Y-m-d') ?>">
                            </div>
                            <button type="submit" class="btn btn-success">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive mt-4">
            <h3>Daftar Absensi</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
    <?php
    date_default_timezone_set('Asia/Jayapura');
    $tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');

    $sql = "SELECT a.*, m.nama, m.prodi 
            FROM absensi a 
            JOIN mahasiswa m ON a.nim = m.nim 
            WHERE a.tanggal = '$tanggal'
            ORDER BY a.jam_masuk DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $no = 1;
        while($row = $result->fetch_assoc()) {
            // Konversi jam_masuk ke zona waktu Papua (Asia/Jayapura)
            $utcTime = new DateTime($row['jam_masuk'], new DateTimeZone('UTC'));
            $utcTime->setTimezone(new DateTimeZone('Asia/Jayapura'));
            $jamMasukWIT = $utcTime->format('H:i:s');

            echo "<tr>
                    <td>{$no}</td>
                    <td>{$row['nim']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['prodi']}</td>
                    <td>{$row['tanggal']}</td>
                    <td>{$jamMasukWIT}</td>
                    <td>{$row['status']}</td>
                  </tr>";
            $no++;
        }
    } else {
        echo "<tr><td colspan='7' class='text-center'>Tidak ada data absensi</td></tr>";
    }
    ?>
</tbody>


            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>