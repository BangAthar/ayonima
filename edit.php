<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ujian CRUD - Perbaruhi Data</title>
    <link rel="stylesheet" href="style/custom.css">
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
        <h4 class="mt-2 mx-2 fw-bold text-center">MERUBAH DATA SISWA</h4>
        <div class="garis"></div>
        <?php

        // -----------------------------------------------------------------------------
        // KODE PHP DIBAWAH MERUPAKAN FUNGSI UNTUK MELAKUKAN EDIT ATAU PERUBAHAN DATA
        // -----------------------------------------------------------------------------


        // Mengimport file connect.php untuk terhubung ke database
        include "connect.php";

        // Fungsi untuk untuk mencegah inputan karakter yg tidak sesuai
        function input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        // Cek apakah ada nilai yg dikirim dengan method GET dengan nama id_siswa
        if (isset($_GET['id_siswa'])) {
            $id = input($_GET["id_siswa"]);

            $sql = "select * from siswa where id='$id'";
            $hasil = mysqli_query($connect, $sql);
            $data = mysqli_fetch_assoc($hasil);
        }

        // Cek apakah ada kiriman form dari method POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = htmlspecialchars($_POST["id_siswa"]);
            $nama = input($_POST["nama"]);
            $absen = input($_POST["absen"]);
            $kelas = input($_POST["kelas"]);
            $foto = $_FILES["foto"]["name"];
            $oldFoto = input($_POST["oldFoto"]);

            // Merubah nama foto pada tabel database
            if ($foto != "") {
                $update_namafile = $_FILES["foto"]["name"];
            } else {
                $update_namafile = $oldFoto;
            }

            // Mengecek apakah nama foto tersedia atau tidak
            if ($_FILES["foto"]["name"] != '') {
                // Mengecek apakah foto sudah tersedia didalam folder 'foto'
                if (file_exists("foto/" . $_FILES["foto"]["name"])) {
                    $namafile = $_FILES["foto"]["name"];
                    header('Location:index.php?error');
                }
                // Menjalankan perintah untuk merubah data
                else {
                    $query = "update siswa set 
                    foto='$update_namafile',
                    nama='$nama',
                    absen='$absen',
                    kelas='$kelas' 
                    where id=$id";
                    $query_run = mysqli_query($connect, $query);

                    if ($query_run) {
                        if ($_FILES["foto"]["name"] != '') {
                            move_uploaded_file($_FILES["foto"]["tmp_name"], "foto/" . $_FILES["foto"]["name"]);
                            unlink("foto/" . $oldFoto);
                        }
                        header('Location:index.php');
                    } else {
                        header('Location:index.php');
                    }
                }
            }
            // Menjalankan perintah untuk merubah data
            else {
                $query = "update siswa set 
                    foto='$update_namafile',
                    nama='$nama',
                    absen='$absen',
                    kelas='$kelas' 
                    where id=$id";
                $query_run = mysqli_query($connect, $query);

                if ($query_run) {
                    if ($_FILES["foto"]["name"] != '') {
                        move_uploaded_file($_FILES["foto"]["tmp_name"], "foto/" . $_FILES["foto"]["name"]);
                        unlink("foto/" . $oldFoto);
                    }
                    header('Location:index.php');
                } else {
                    header('Location:index.php');
                }
            }
        }
        ?>
        <div class="col col-lg-8 mx-auto">
            <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group mt-3">
                    <div class="">
                        <label for="formFile" class="form-label">Merubah foto :</label>
                        <input class="form-control" name="foto" type="file" id="formFile">
                        <input type="hidden" name="oldFoto" value="<?php echo $data["foto"]; ?>">
                        <img src="foto/<?php echo $data["foto"]; ?>" style="width: 100px !important;" alt="" class="mt-2">
                    </div>
                </div>
                <div class="form-group mt-1">
                    <label>Nama:</label>
                    <input type="text" name="nama" class="form-control" placeholder="Masukan Nama" value="<?php echo $data["nama"]; ?>" required />
                </div>
                <div class="form-group mt-3">
                    <label>Absen :</label>
                    <input type="text" name="absen" class="form-control" placeholder="Masukan Absen" value="<?php echo $data["absen"]; ?>" required />
                </div>
                <div class="form-group mt-3">
                    <label>Kelas:</label>
                    <input type="text" name="kelas" class="form-control" placeholder="Masukan Kelas" value="<?php echo $data["kelas"]; ?>" required />
                </div>
                <input type="hidden" name="id_siswa" value="<?php echo $data['id']; ?>" />
                <button type="submit" name="submit" class="btn btn-primary mt-3">Perbaruhi</button>
                <a href="index.php" class="btn btn-danger mt-3 mx-2">kembali</a>
            </form>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</html>