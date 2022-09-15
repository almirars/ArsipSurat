<html>
<head>
    <title>Tutorial Cara Membuat Upload File Dengan PHP MySQL</title>
</head>
<body>
    <h1>Form Upload File Dengan PHP</h1>
    <h2>Isi Data:</h2>
    <form action="uploadFile.php" method="POST" enctype="multipart/form-data">
        <table>
            <tr>
                <td>Nomor</td>
                <td>:</td>
                <td><input type="text" name="nomor"></td>
            </tr>
            <tr>
                <td>File</td>
                <td>:</td>
                <td><input type="file" name="file_ijazah"></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" name="upload" value="Upload"></td>
            </tr>
        </table>
    </form>
</body>
</html>