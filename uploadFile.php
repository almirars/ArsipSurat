<?php

include('koneksi.php');

if (isset($_POST['simpan'])) {
	$NomorSurat = $_POST['NomorSurat'];
	$Kategori = $_POST['Kategori'];
	$Judul = $_POST['Judul'];
	if ($_FILES['file']['name'] != "") {
		$ekstensi_diperbolehkan    = array('pdf');
		$nama       = $_FILES['file']['name'];
		$x          = explode('.', $nama);
		$ekstensi   = strtolower(end($x));
		$ukuran     = $_FILES['file']['size'];
		$file_tmp   = $_FILES['file']['tmp_name'];

		if (in_array($ekstensi, $ekstensi_diperbolehkan) === true) {
			if ($ukuran < 5242880) {
                move_uploaded_file($file_tmp, 'asset/' . $nama);
				$sql = "INSERT INTO arsip (NomorSurat, Kategori, Judul, File_arsip) VALUES ('$NomorSurat', '$Kategori', '$Judul', '$nama');";

				$query = mysqli_query($connect, $sql);
				if ($query) {
					echo '<script type="text/javascript"> alert("Data Berhasil Disimpan"); </script>';
					echo "<script>document.location='index.php'</script>";
				} else {
					echo '<script type="text/javascript"> alert("Data Gagal Disimpan"); </script>';
					echo "<script>document.location='index.php'</script>";
				}
			} else {
				echo '<script type="text/javascript"> alert("Ukuran File Terlalu Besar"); </script>';
				echo "<script>document.location='index.php'</script>";
			}
		} else {
			echo '<script type="text/javascript"> alert("Ekstensi File Tidak Diperbolehkan"); </script>';
			echo "<script>document.location='index.php'</script>";
		}
	}
} else {
	echo 'Coba lagi';
}