<?php
  $host = "localhost";
  $user = "root";
  $password = "";
  $db = "akademik";

  $koneksi = mysqli_connect($host, $user, $password, $db);

  if(!$koneksi){
    die("connection failed");
  }

  $nim = "";
  $nama = "";
  $alamat = "";
  $fakultas = "";
  $error = "";
  $sukses = "";

  if(isset($_GET['op'])){
    $op = $_GET['op'];
  }else{
    $op = '';
  }
  if($op == 'delete'){
    $id = $_GET['id'];
    $sql1 = "DELETE FROM mahasiswa WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);

    if($q1){
      $sukses = "Berhasil menghapus data";
    }else{
      $error =  "Data gagal dihapus";
    }
  }

  if($op == 'edit'){
    $id = $_GET['id'];
    $sql1 = "SELECT * FROM mahasiswa WHERE id = '$id'";
    $q1 = mysqli_query($koneksi, $sql1);
    $r1 = mysqli_fetch_array($q1);
    $nim = $r1['nim'];
    $nama = $r1['nama'];
    $alamat = $r1['alamat'];
    $fakultas = $r1['fakultas'];

    if($nim == ''){
      $error= "data tidak ditemukan";
    }
  }

  //CREATE
  if(isset($_POST["simpan"])){
    $nim = $_POST["nim"];
    $nama = $_POST["nama"];
    $alamat = $_POST["alamat"];
    $fakultas = $_POST["fakultas"];

    if($nim && $nama && $alamat && $fakultas){
      if($op == "edit"){//Update
        $sql1 = "UPDATE mahasiswa set nim='$nim',nama='$nama',alamat='$alamat',fakultas='$fakultas' WHERE id = '$id'";
        $q1 = mysqli_query($koneksi,$sql1);
        if($q1){
          $sukses = "Data berhsil di update";
        }else{
          $error = "Data gagal ter-update";
        }
      }else{//Insert
        $sql1 = "INSERT INTO mahasiswa(nim,nama,alamat,fakultas) VALUES('$nim','$nama','$alamat','$fakultas')";
        $q1 = mysqli_query($koneksi, $sql1);
          if($q1){
            $sukses = "berhasil memasukkan data baru";
          }else{
          $error = "gagal gagal di masukkan";
          } 
      }
    }else{
      $error = "anda tidak memasukkan semua data";
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CRUD 1</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <style>
    .mx-auto{
      width: 800px;
    }
    .card{
      margin-top : 10px;
    }
  </style>
</head>
<body>
  <div class="mx-auto">
      <div class="card">
        <div class="card-header">
          Cread/Edit data
        </div>
          <div class="card-body">
          <?php
          if($error){
            ?>
            <div class="alert alert-danger" role="alert">
              <?php echo $error?>
            </div>
            <?php
            header("refresh:2;url=index.php");
          }
          else if($sukses){
            ?>
             <div class="alert alert-success" role = "alert">
              <?php echo $sukses?>
             </div>
            <?php
            header("refresh:2;url=index.php");
          }
          ?>
        </div>
            <form action="" method = "POST" class = "p-3">
              <div class="mb-3 row">
                <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" id="nim" name="nim" value="<?php echo $nim?>">
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
                <label for="fakultas" class="col-sm-2 col-form-label">Fakultas</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="fakultas" id="fakultas">
                      <option value="">
                        - pilih fakultas-
                      </option>
                      <option value="saintek" <?php if($fakultas == "saintek")  echo "selected"?> >saintek</option>
                      <option value="soshum" <?php if($fakultas == "soshum") echo "selected"?> >soshum</option>
                    </select>
                  </div>
              </div>
              <div class="col-12">
                <input type="submit" name="simpan" value ="simpan data" class="btn btn-primary" >
              </div>
            </form>
          </div>
        </div>
        <!-- untuk mengeluarkan data -->
      <div class="card mx-auto">
        <div class="card-header text-white bg-secondary">
          Data Mahasiswa
        </div>
          <div class="card-body">
            <form action="" method = "POST">
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nim</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Fakultas</th>
                    <th scope="col">Aksi</th>
                  </tr>
                  <tbody>
                    <?php
                      $sql2 = "SELECT * FROM mahasiswa order by id desc";
                      $q2 = mysqli_query($koneksi,$sql2);
                      $urut = 1;
                      while($r2 = mysqli_fetch_array($q2)){
                        $id = $r2['id'];
                        $nim = $r2['nim'];
                        $nama = $r2['nama'];
                        $alamat = $r2['alamat'];
                        $fakultas = $r2['fakultas'];
                        ?>
                        <tr>
                          <th scope="row">
                            <?php echo $urut++?>
                          </th>
                          <td scope="row"><?php echo $nim?></td>
                          <td scope="row"><?php echo $nama?></td>
                          <td scope="row"><?php echo $alamat?></td>
                          <td scope="row"><?php echo $fakultas?></td>
                          <td scope="row">
                            <a href="index.php?op=edit&id=<?php echo $id?>">
                            <button type="button" class="btn btn-warning">Edit</button>
                          </a>
                          <a href="index.php?op=delete&id=<?php echo $id?>" onclick = "return confirm('Anda yakin ingin menghapus data')">
                          <button type="button" class="btn btn-danger">Delete</button>
                        </a>
                          </td>
                        </tr>
                        <?php
                      }
                    ?>
                  </tbody>
                </thead>
              </table>
            </form>
        </div>
      </div>
  </div>
</body>
</html>