<?php
$host   = "localhost";
$user   = "root";
$pass   = "";
$db     = "magang";

$koneksi = mysqli_connect($host,$user,$pass,$db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}
$no_magang  = "";
$nama       = "";
$alamat     = "";
$devisi     = "";
$sukses     = "";
$error      = "";

if(isset($_GET['op'])){
    $op = $_GET['op'];
}else{
    $op = "";
}

if($op == 'delete'){
    $id = $_GET['id'];
    $sql1 = "delete from user where id = '$id'";
    $q1 = mysqli_query($koneksi,$sql1);
    if($q1){
        $sukses = "Berhasil hapus data";
    }else{
        $error = "Gagal hapus data";
    }
}

if($op == 'edit'){
    $id         = $_GET['id'];
    $sql1       = "select * from user where id = '$id'";
    $q1         = mysqli_query($koneksi,$sql1);
    $r1         = mysqli_fetch_array($q1);
    $no_magang  = $r1['no_magang'];
    $nama       = $r1['nama'];
    $alamat     = $r1['alamat'];
    $devisi     = $r1['devisi'];

    if($no_magang == ''){
        $error = "Data tidak ditemukan";
    }
}

if(isset($_POST['simpan'])){ //untuk create
    $no_magang    = $_POST['no_magang'];
    $nama         = $_POST['nama'];
    $alamat       = $_POST['alamat'];
    $devisi       = $_POST['devisi'];

    if($no_magang && $nama && $alamat && $devisi){
        if($op == 'edit'){ //untuk update
            $sql1 = "update user set no_magang='$no_magang',nama='$nama',alamat='$alamat',devisi='$devisi' where id='$id'";
            $q1 = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Data berhasil di update";
            }else{
                $error = "Data gagal di update";
            }
        }else{ //untuk insert
            $sql1 = "insert into user(no_magang,nama,alamat,devisi) values ('$no_magang','$nama','$alamat','$devisi')";
            $q1   = mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses = "Berhasil input data baru";
            }else{
                $error = "Gagal input data";
            }
        }
    }else{
        $error = "Silahkan input semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .mx-auto { width:800px}
        .card { margin-top: 10px;}
    </style>
</head>
<body>
    <div class="mx-auto">
    <!-- untuk memasukkan data -->
    <div class="card">
        <div class="card-header">
            Create / Update Data
        </div>
        <div class="card-body">
            <?php
            if($error){
            ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error ?>
                </div>
            <?php
                header("refresh:5;url=index.php");
            }
            ?>
            <?php
            if($sukses){
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
                <label for="no_magang" class="col-sm-2 col-form-label">No Magang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_magang" name="no_magang" value="<?php echo $no_magang?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $alamat?>">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="devisi" class="col-sm-2 col-form-label">Devisi</label>
                <div class="col-sm-10">
                    <select class="form-control" name="devisi" id="devisi">
                        <option value="">- Pilih Devisi -</option>
                        <option value="test" <?php if($devisi == "test") echo "selected"?>>test</option>
                        <option value="selasa" <?php if($devisi == "selasa") echo "selected"?>>selasa</option>
                    </select>
                </div>
            </div>
            <div class="col-12">
                <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
            </div>
            </form>
        </div>
    </div>

    <!-- untuk mengeluarkan data -->
    <div class="card">
        <div class="card-header text-white bg-secondary">
            Data User Magang
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">No Magang</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Alamat</th>
                        <th scope="col">Devisi</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                        <?php
                        $sql2   = "SELECT * FROM user";
                        $q2     = mysqli_query($koneksi,$sql2);
                        $urut   = 1;
                        while($r2 = mysqli_fetch_array($q2)){
                            $id         = $r2['id'];
                            $no_magang  = $r2['no_magang'];
                            $nama       = $r2['nama'];
                            $alamat     = $r2['alamat'];
                            $devisi     = $r2['devisi'];
                        
                        ?>

                        <tr>
                            <td scope="row"><?php echo $urut++ ?></td>
                            <td scope="row"><?php echo $no_magang ?></td>
                            <td scope="row"><?php echo $nama ?></td>
                            <td scope="row"><?php echo $alamat ?></td>
                            <td scope="row"><?php echo $devisi ?></td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id?>"><button type="button" class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&id=<?php echo $id?>" onclick="return confirm('Yakin mau delete data?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                
                            </td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
            </table>
        </div>
    </div>
    </div>
</body>
</html>