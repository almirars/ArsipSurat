<?php
include('koneksi.php');
if (isset($_GET['id'])) {
	$id = $_GET['id'];

	$sql = mysqli_query($connect, "SELECT * FROM arsip WHERE id = '$id'");
	$data = mysqli_fetch_assoc($sql);
	$file_surat = 'asset/' . $data['File_arsip'];
	if (file_exists($file_surat)) {
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename="' . basename($file_surat) . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize('asset/' . $data['File_arsip']));
    }}
?>