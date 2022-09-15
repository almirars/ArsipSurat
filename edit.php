<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Arsip Surat</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <?php include("include/navbar.php"); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <span class="brand-text font-weight-light">Arsip Surat</span>
    </a>

    <!-- Sidebar -->
    <?php include("include/sidebar.php"); ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Arsip Surat</h1>
            <h6>Berikut ini adalah surat-surat yang telah terbit dan diarsipkan.<br>
                Klik "Lihat" pada kolom aksi untuk menampilkan surat.</h6>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Arsip</a></li>
              <li class="breadcrumb-item active">Arsip Surat</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

      <?php
								include 'koneksi.php';
								//Fungsi untuk mencegah inputan karakter yang tidak sesuai
								function input($data)
								{
									$data = trim($data);
									$data = stripslashes($data);
									$data = htmlspecialchars($data);
									return $data;
								}

								//Cek apakah ada nilai yang dikirim menggunakan methos GET dengan nama id
								if (isset($_GET['id'])) {
									$id = input($_GET["id"]);

									$sql = "SELECT * FROM arsip WHERE id=$id";
									$hasil = mysqli_query($connect, $sql);
									$data = mysqli_fetch_assoc($hasil);
								}
								//Cek apakah ada kiriman form dari method post
								if ($_SERVER["REQUEST_METHOD"] == "POST") {
									$id = htmlspecialchars($_POST["id"]);
									$NomorSurat = input($_POST["NomorSurat"]);
									$Kategori = input($_POST["Kategori"]);
									$Judul = input($_POST["Judul"]);

									$old_file = input($_POST['old_file']);
									if ($_FILES['File_arsip']['name'] != "") {
										$ekstensi_diperbolehkan = array('pdf');
										$nama = $_FILES['File_arsip']['name'];
										$x = explode('.', $nama);
										$ekstensi = strtolower(end($x));
										$ukuran    = $_FILES['File_arsip']['size'];
										$file_tmp = $_FILES['File_arsip']['tmp_name'];
										if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
											if ($ukuran < 5242880) {
												move_uploaded_file($file_tmp, 'asset/' . $nama);
											} else {
												echo '<script type="text/javascript"> alert("Ukuran File Terlalu Besar"); </script>';
												echo "<script>document.location='index.php?arsip'</script>";
											}
										} else {
											echo '<script type="text/javascript"> alert("Ekstensi File Tidak Diperbolehkan"); </script>';
											echo "<script>document.location='index.php?arsip'</script>";
										}
										$file_surat = $nama;
									} else {
										$file_surat = $old_file;
									}

									$sql = "UPDATE arsip SET
									NomorSurat='$NomorSurat', 
								    Kategori='$Kategori', 
									Judul='$Judul', 
									File_arsip='$File_arsip',
									waktu_pengarsipan=now()
									where id=$id";

									//Mengeksekusi atau menjalankan query diatas
									$hasil = mysqli_query($connect, $sql);

									//Kondisi apakah berhasil atau tidak dalam mengeksekusi query diatas
									if ($hasil) {
										echo '<script type="text/javascript"> alert("Berhasil Edit Data"); </script>';
										echo "<script>document.location='index.php?arsip'</script>";
									} else {
										echo '<script type="text/javascript"> alert("Gagal Upload Data"); </script>';
										echo "<script>document.location='index.php?arsip'</script>";
									}
								}
								?>

	<form action="edit.php" method="post" enctype="multipart/form-data">		
    <input type="hidden" name="id" value="<?php echo $data['id'] ?>">
		<table>
			<tr>
				<td>Nomor Surat</td>
				<td>
					<input type="text" name="NomorSurat" value="<?php echo $data['NomorSurat'] ?>">
				</td>					
			</tr>	
			<tr>
				<td>Kategori</td>
				<td>
                <div>
              <select class="form-control" name="Kategori" required>
                <option>Undangan</option>
                <option>Pengumuman</option>
                <option>Nota Dinas</option>
                <option>Pemberitahuan</option>
              </select>
            </div>
            </td>					
			</tr>	
			<tr>
				<td>Judul</td>
				<td><input type="text" name="Judul" value="<?php echo $data['Judul'] ?>"></td>					
			</tr>
            <tr>
				<td>File</td>
				<td><input type="hidden" id="old_file" name="old_file" value="<?= $query['file_surat'] ?>">
				<input type="file" style="height:auto" class="form-control-file form-control height-auto" id="customFile" name="file_surat"></td>					
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" value="Simpan"></td>					
			</tr>				
		</table>
	</form>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

        <a href="unggah.php" class="btn btn-info" role="button" aria-pressed="true">Arsipkan Surat</a>
            </body>
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <!-- <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> -->
    <!-- All rights reserved. -->
    <div class="float-right d-none d-sm-inline-block">
      <!-- <b>Version</b> 3.1.0 -->
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="plugins/moment/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
</body>
</html>