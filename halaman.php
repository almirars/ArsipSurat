<!DOCTYPE Html>
<Html>
<Head>
    <Title>Upload Dan Download File PDF Dengan PHP Dan MySQL</Title>
</Head>
<Body Style="Width: 800px; Margin: Auto; Padding: 10px;">
    <H2 Style="Text-Align: Center;">Tabel Upload/Download File (PDF)</H2>
    <Button Onclick="Document.Location='Halaman_upload.Php'">Tambah Data</Button>
    <Br /><Br />
    <Table Border="1" Style="Width: 100%; Border-Collapse: Collapse;">
        <Thead>
            <Tr>
                <Th Style="Width: 30px">Nomor Surat</Th>
                <Th Style="Width: 100px">Kategori</Th>
                <Th>Nama</Th>
                <Th Style="Width: 100px">Judul</Th>
                <Th Style="Width: 100px">File</Th>
                <!-- <Th Style="Width: 100px">Aksi</Th> -->
            </Tr>
        </Thead>
        <Tbody Style="Text-Align: Center;">
            <?Php
                Include 'koneksi.Php';
                // $Nomor_urut = 0;
                $Result = SelectAllData();
                $CountData = Mysqli_num_rows($Result);
                If ($CountData < 1) { 
            ?>    
                    <Tr>
                        <Td Colspan="5" Style="Text-Align: Center; Font-Weight: Bold; Font-Size: 12px; Padding: 5px; Color: Red">TIDAK ADA DATA</Td>
                    </Tr>
            <?Php
                } Else {
                    While ($Row = Mysqli_fetch_assoc($Result)) {
                        // $Nomor_urut = $Nomor_urut + 1;
            ?>
                        <Tr>
                            <!-- <Td><?Php Echo $Nomor_urut; ?></Td> -->
                            <Td><?Php Echo $Row['NomorSurat']; ?></Td>
                            <Td><?Php Echo $Row['Kategori']; ?></Td>
                            <Td><?Php Echo $Row['Judul']; ?></Td>
                            <Td><?Php Echo $Row['File']; ?></Td>
                            <Td><?Php Echo Strtoupper($Row['Ekstensi']) ?></Td>
                            <Td><?Php Echo Number_format($Row['Size']/(1024*1024), 2) ?>MB</Td>
                            <Td><A Href="DownloadFile.Php?Url=<?Php Echo $Row['Berkas']; ?>">Download</A></Td>
                        </Tr>
            <?Php 
                    }
                } 
            ?>
        </Tbody>
    </Table>
    
</Body>
</Html>