<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biodata siswa</title>
</head>

<body>
    <form id="formBiodata" name="formBiodata" action="proses_radio.php" method="post">
        <p>Nama : <input type="text" name="nama" id="nama" required><br></p>
        <p>Kelas : <input type="number" name="kelas" id="kelas" required><br></p>
        <p>NIS : <input type="number" name="nis" id="nis" required><br></p>
        <p>Jurusan : </p>
        <input type="radio" name="jurusan" value="RPL" required> RPL
        <input type="radio" name="jurusan" value="TAV" required> TAV
        <input type="radio" name="jurusan" value="TBSM" required> TBSM
        <input type="radio" name="jurusan" value="TKR" required> TKR
        <input type="radio" name="jurusan" value="TPM" required> TPM
        <input type="submit" name="button" id="button" value=" Tampil">
    </form>
</body>

</html>