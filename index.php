<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_sekolah";

$koneksi = mysqli_connect($host, $user, $pass, $db);
if (!$koneksi) { //cek koneksi
    die("Tidak bisa terkoneksi ke database");
}

$nim = "";
$nama = "";
$alamat = "";
$jurusan = "";
$sukses = "";
$eror = "";

    if(isset($_GET['op'])){
        $op =$_GET['op'];
    }else{
        $op ="";
    }
    if($op =='delete'){
        $id     =$_GET['id'];
        $sql1   ="delete from mahasiswa where id ='$id'";
        $q1     =mysqli_query($koneksi,$sql1);
        if($q1){
            $sukses ="Berhasil hapus data";
        }else{
            $eror   ="Gagal melakukan delete data";
        }
    }
    if($op == 'edit'){
        $id         =$_GET['id'];
        $sql1       ="select * from mahasiswa where id = '$id'";
        $q1         =mysqli_query($koneksi,$sql1);
        $r1         =mysqli_fetch_array($q1);
        $nim        =$r1['nim'];
        $nama       =$r1['nama'];
        $alamat     =$r1['alamat'];
        $jurusan    =$r1['jurusan'];

        if($nim ==''){
            $eror ="data tidak ditemukan";
        }
    }
if (isset($_POST['simpan'])) { //untuk create
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $jurusan = $_POST['jurusan'];

    if ($nim && $nama && $alamat && $jurusan) {
        if($op =='edit'){
            $sql1       ="update mahasiswa set nim ='$nim',nama='$nama',alamat='$alamat',jurusan='$jurusan' where id ='$id'";
            $q1         =mysqli_query($koneksi,$sql1);
            if($q1){
                $sukses ="Data Berhasil Di Update";
            }else{
                $eror   ="Data gagal di update";
            }
        }else{
             $sql1 = "insert into mahasiswa(nim,nama,alamat,jurusan) values ('$nim','$nama','$alamat','$jurusan')";
        $q1 = mysqli_query($koneksi, $sql1);
        if ($q1) {
            $sukses = "Berhasil memasukkan data baru";
        } else {
            $error = "Gagal memasukkan data";
        }
    }
        }
       
} else {
    $error = "Silakan masukkan semua data";
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        .mx-auto {
            width: 800px
        }

        .card {
            margin-top: 10px
        }
    </style>
</head>

<body>
    <div class="mx-auto">
        <!-----untuk mengisi data--->
        <div class="card">
            <div class="card-header">
                Create / Edit Data
            </div>
            <div class="card-body">
                <?php
                if ($eror) {
                    ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $eror ?>
                </div>
                <?php
                header("refresh:2;url=index.php"); //2: detik
                }
                ?>
                <div class="card-body">
                    <?php
                    if ($sukses) {
                        ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses ?>
                    </div>
                    <?php
                    header("refresh:2;url=index.php");
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
                            <label for="nama" class="col-sm-2 col-form-label">NAMA</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="nama" name="nama"
                                    value="<?php echo $nama ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="alamat" class="col-sm-2 col-form-label">ALAMAT</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="alamat" name="alamat"
                                    value="<?php echo $alamat ?>">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="jurusan" class="col-sm-2 col-form-label">JURUSAN</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="jurusan" id="jurusan">
                                    <option value="">- Pilih Jurusan -</option>
                                    <option value="RPL">RPL
                                        <?php if ($jurusan == "RPL")
                                            echo "selected" ?>
                                    </option>
                                    <option value="TKJ">TKJ
                                        <?php if ($jurusan == "TKJ")
                                            echo "selected" ?>
                                    </option>
                                    <option value="BM">BM
                                        <?php if ($jurusan == "BM")
                                            echo "selected" ?>
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!------untuk mengeluarkan data----->
        <div class="card">
            <div class="card-header text-white bg-secondary">
                Data Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nim</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Alamat</th>
                            <th scope="col">Jurusan</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    <tbody>
                        <?php
                                        $sql2 = "select * from mahasiswa order by id desc";
                                        $q2 = mysqli_query($koneksi, $sql2);
                                        $urut = 1;
                                        while ($r2 = mysqli_fetch_array($q2)) {
                                            $id = $r2['id'];
                                            $nama = $r2['nama'];
                                            $alamat = $r2['alamat'];
                                            $jurusan = $r2['jurusan'];
                                            ?>
                        <tr>
                            <th scope="row">
                                <?php echo $urut++ ?>
                            </th>
                            <td scope="row">
                                <?php echo $nim ?>
                            </td>
                            <td scope="row">
                                <?php echo $nama ?>
                            </td>
                            <td scope="row">
                                <?php echo $alamat ?>
                            </td>
                            <td scope="row">
                                <?php echo $jurusan ?>
                            </td>
                            <td scope="row">
                                <a href="index.php?op=edit&id=<?php echo $id ?>"> <button type="button" class="btn btn-warning">Edit</button></a>
                                <a href="index.php?op=delete&id=<?php echo $id ?>" onclick="return confirm('Yakin Mau delete data ?')"><button type="button" class="btn btn-danger">Delete</button></a>
                                
                            </td>
                        </tr>
                        <?php
                         }
                         ?>
                    </tbody>
                    </thead>

                </table>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4"
            crossorigin="anonymous"></script>
</body>

</html>
