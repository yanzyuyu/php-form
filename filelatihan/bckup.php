<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form data siswa</title>

</head>

<body>
    <h2>Formulir data diri siswa</h2>
    <form action="datadiri_show.php" method="post">
        <table >
            <tr>
                <td>Nama Lengkap</td>
                <td>:</td>
                <td><input type="text" name="nama" id="nama" required></td>
            </tr>
            <tr>
                <td>NIS</td>
                <td>:</td>
                <td><input type="number" name="nis" id="nis" required></td>
            </tr>
            <tr>
                <td>Tempat Lahir</td>
                <td>:</td>
                <td><input type="text" name="tempat_lahir" id="tempat_lahir" required></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>:</td>
                <td><input type="date" name="tanggal_lahir" id="tanggal_lahir" required></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td>
                    <input type="radio" id="laki-laki" name="jenis_kelamin" value="Laki-laki" required>
                    <label for="laki-laki">Laki-laki</label><br>
                    <input type="radio" id="perempuan" name="jenis_kelamin" value="Perempuan" required>
                    <label for="perempuan">Perempuan</label><br>
                </td>
            </tr>
            <tr>
                <td>Agama</td>
                <td>:</td>
                <td>
                    <select name="agama" id="agama" required>
                        <option value="">Pilih agama</option>
                        <option value="Islam">Islam</option>
                        <option value="Kristen">Kristen</option>
                        <option value="Hindu">Hindu</option>
                        <option value="Budha">Budha</option>
                        <option value="Konghucu">Konghucu</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td>
                    <textarea name="alamat" id="alamat" rows="4" required></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td><input type="submit" value="kirim"></td>
            </tr>
        </table>
    </form>
</body>

</html>