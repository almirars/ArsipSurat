<?php

include('koneksi.php');

$id = $_GET['id'];

$sql = "DELETE FROM arsip WHERE id=$id";
$query = mysqli_query($connect, $sql);
	
if($query){
	echo '<script type="text/javascript"> alert("Data Berhasil Dihapus"); </script>';
	echo "<script>document.location='index.php'</script>";
}else{
	echo '<script type="text/javascript"> alert("Data Gagal Dihapus");</script>';
	echo"<script>document.location='index.php'</script>";
}
?>