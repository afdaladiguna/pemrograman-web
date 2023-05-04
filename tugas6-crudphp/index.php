<?php

include "koneksi.php";
include "functions.php";

$nim = "";
$nama = "";
$program_studi = "";
$nilai_total = "";
$sukses = "";
$error = "";

if (isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == 'delete') {
    $id         = $_GET['id'];
    $sql1       = "delete from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error  = "Gagal melakukan delete data";
    }
}

if ($op == 'edit') {
    $id         = $_GET['id'];
    $sql1       = "select * from mahasiswa where id = '$id'";
    $q1         = mysqli_query($koneksi, $sql1);
    $r1         = mysqli_fetch_array($q1);
    $nim        = $r1['nim'];
    $nama       = $r1['nama'];
    $program_studi   = $r1['program_studi'];
    $nilai_total   = $r1['nilai_total'];

    if ($nim == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) {
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $program_studi = $_POST['program_studi'];
    $nilai_total = $_POST['nilai_total'];

    if ($nim && $nama && $program_studi && $nilai_total) {
        if ($op == 'edit') {
            $sql1 = "update mahasiswa set nim = '$nim', nama = '$nama', program_studi = '$program_studi', nilai_total = '$nilai_total' where id = '$id'";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Data berhasil diupdate";
            } else {
                $error  = "Data gagal diupdate";
            }
        } else {
            $sql1 = "insert into mahasiswa(nim,nama,program_studi,nilai_total)
            values('$nim','$nama', '$program_studi', '$nilai_total')";
            $q1 = mysqli_query($koneksi, $sql1);
            if ($q1) {
                $sukses = "Berhasil menambahkan data baru.";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan nim";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Nilai FIKOM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<body>
    <div class="container mx-auto">

    <h1 class="text-center my-5">Input Nilai Mahasiswa FIKOM</h1>
        <!-- // INPUT DATA -->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error ?>
                    </div>
                <?php
                }

                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                <?php
                header("refresh:5;url=index.php");
                }

                ?>

                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama ?>">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="program_studi" class="col-sm-2 col-form-label">Program Studi</label>
                        <div class="col-sm-10">
                            <select id="program_studi" class="form-control" name="program_studi">
                                <option value="">=== Pilih Program Studi ===</option>
                                <option value="Teknik Informatika" <?php if ($program_studi == "Teknik Informatika") echo "selected" ?>>Teknik Informatika</option>
                                <option value="Sistem Informasi" <?php if ($program_studi == "Sistem Informasi") echo "selected" ?>>Sistem Informasi</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="nilai_total" class="col-sm-2 col-form-label">Nilai Total</label>
                        <div class="col-sm-10">
                            <input type="number" max="100" class="form-control" id="nilai_total" name="nilai_total" value="<?php echo $nilai_total ?>">
                        </div>
                    </div>

                    <input type="submit" class="btn btn-primary" name="simpan" value="Submit">
                </form>
            </div>
        </div>

        <!-- // OUTPUT DATA -->
        <div class="card">
            <div class="card-header">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">NIM</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Program Studi</th>
                            <th scope="col">Total Nilai</th>
                            <th scope="col">Nilai Huruf</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql2 = "select * from mahasiswa order by id desc";
                        $q2 = mysqli_query($koneksi, $sql2);
                        $urut = 1;
                        while ($r2 = mysqli_fetch_array($q2)) {
                            $id = $r2['id'];
                            $nim = $r2['nim'];
                            $nama = $r2['nama'];
                            $program_studi = $r2['program_studi'];
                            $nilai_total = $r2['nilai_total'];
                            $nilai_huruf = nilai_huruf($nilai_total);

                        ?>
                            <tr>
                                <td scope="row"><?php echo $urut++ ?></td>
                                <td scope="row"><?php echo $nim ?></td>
                                <td scope="row"><?php echo $nama ?></td>
                                <td scope="row"><?php echo $program_studi ?></td>
                                <td scope="row"><?php echo $nilai_total ?></td>
                                <td scope="row"><?php echo $nilai_huruf ?></td>
                                <td scope="row">
                                    <a href="index.php?op=edit&id=<?php echo $id ?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                    <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                </td>
                            </tr>
                        <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>