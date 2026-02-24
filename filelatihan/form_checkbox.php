<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form input</title>
</head>

<body>
    <form action="proses_checkbox.php" id="form_text" name="form_text" method="post">
        <p>Nama Pelanggan : <input type="text" name="nama" id="nama"><br></p>
        <p>Belanja : </p>
        <input type="checkbox" name="barang1" value="Buku Tulis"> Buku Tulis
        <input type="checkbox" name="barang2" value="Pulpen"> Pulpen
        <input type="checkbox" name="barang3" value="Pensil"> Pensil
        <input type="checkbox" name="barang4" value="Penggaris"> Penggaris
        <input type="checkbox" name="barang5" value="Spidol"> Spidol
        <input type="submit" name="button" id="button" value="Tampil">
    </form>
</body>

</html>