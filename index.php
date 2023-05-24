<!-- COPYRIGHT CONTENT NOXVALPROJECT

SOURCE CODE MILIK NOXVAL

-->



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian CRUD - Home</title>
    <link rel="stylesheet" href="style/custom.css">
    <!-- Google Font API -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- Framework Style Boostrap biar ga perlu styling manual -->
    <link rel="stylesheet" href="boostrap/css/bootstrap.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap.rtl.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-grid.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-grid.rtl.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-grid.min.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-grid.rtl.min.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-utilities.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-utilities.rtl.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-utilities.min.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-utilities.rtl.min.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-reboot.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-reboot.rtl.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-reboot.min.css">
    <link rel="stylesheet" href="boostrap/css/bootstrap-reboot.rtl.min.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container-fluid ">
            <a class="navbar-brand text-uppercase text-light fw-bold" href="index.php">PHP NATIVE | CRUD</a>
        </div>
    </nav>
    <div class="container">
        <h5 class="mt-2 text-center fw-bold">PROFILE TUGAS CRUD</h5>
        <div class="mx-auto text-center">
            Nama : Muhammad Naufal Mathara Rahman<br>
            Absen : 26<br>
            Kelas : XI TKJ 2
        </div>
        
        <h4 class="mt-2 mx-2 fw-bold text-center">DATA SISWA</h4>
        <div class="garis"></div>
        <?php

        // -----------------------------------------------------------------------
        // KODE PHP DIBAWAH MERUPAKAN FUNGSI UNTUK MELAKUKAN READ DAN DELETE
        // -----------------------------------------------------------------------


        // Mengimport file connect.php untuk mengakses ke database
        include "connect.php";

        if (isset($_GET["error"])) {
            echo "<script>alert('foto sudah tersedia');</script>";
        }

        if (isset($_GET['id_siswa'])) {
            $id = htmlspecialchars($_GET["id_siswa"]);

            // Mengambil semua data dari tabel siswa
            $all = "select * from siswa where id='$id'";
            $hasil = mysqli_query($connect, $all);
            $data = mysqli_fetch_assoc($hasil);

            // Mengambil foto dari folder 'foto' untuk dihapus
            $foto_dir = 'foto/';
            $foto_nama = $data["foto"];

            // Apakah kondisi diatas berhasil atau tidak
            if ($hasil) {
                // Kondisi mengapus Data dan Foto
                $sql = "delete from siswa where id='$id' ";
                $que = mysqli_query($connect, $sql);
                unlink($foto_dir . $foto_nama);
                header("Location:index.php");
            }
            // Jika kondisi gagal
            else {
                echo "<div class='alert alert-danger'> Data Gagal dihapus.</div>";
            }
        }
        ?>
        <div class="container col-lg-10">
            <table class="table table-bordered mt-4">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Foto</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Absen</th>
                        <th scope="col">Kelas</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <?php
                // Mengimport file connect.php untuk koneksi ke database
                include "connect.php";

                // Mengambil semua data dari database
                $sql = "select * from siswa order by id desc";
                $hasil = mysqli_query($connect, $sql);

                // Looping data pada tabel
                $no = 0;
                while ($data = mysqli_fetch_array($hasil)) {
                    $no++;
                ?>
                    <tbody>
                        <tr>
                            <th scope="row">
                                <?php echo $no ?>
                            </th>
                            <td style="width: 150px !important;">
                                <img src="foto/<?php echo $data["foto"]; ?>" alt="" srcset="" class="rounded img-fluid">
                            </td>
                            <td>
                                <?php echo $data["nama"] ?>
                            </td>
                            <td>
                                <?php echo $data["absen"] ?>
                            </td>
                            <td>
                                <?php echo $data["kelas"] ?>
                            </td>
                            <td style="width: 160px !important;" class=" justify-content-center align-item-center">
                                <a href="edit.php?id_siswa=<?php echo htmlspecialchars($data['id']); ?>" class="btn btn-warning">Edit</a>
                                <a href="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id_siswa=<?php echo $data['id']; ?>" class="btn btn-danger">Hapus</a>
                            </td>
                        </tr>
                    </tbody>
                <?php } ?>
            </table>
            <a href="create.php" class="btn btn-primary">Buat Data</a>
        </div>
    </div>

</body>
<!-- Framework Style Boostrap biar ga perlu styling manual -->
<script src="boostrap/js/bootstrap.bundle.js"></script>
<script src="boostrap/js/bootstrap.bundle.min.js"></script>
<script src="boostrap/js/bootstrap.js"></script>
<script src="boostrap/js/bootstrap.min.js"></script>

</html>