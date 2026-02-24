<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form input</title>
</head>

<body>
    <form action="proses_combobox.php" id="form_text" name="form_text" method="post">
        <label>Pilih Kota:</label>
        <select name="kota">
            <option value="Jakarta">Jakarta</option>
            <option value="Bandung">Bandung</option>
            <option value="Surabaya">Surabaya</option>
            <option value="Yogyakarta">Yogyakarta</option>
            <option value="Semarang">Semarang</option>
            <option value="Jayapura">Jayapura</option>
            <option value="Samarinda">Samarinda</option>
        </select>
        <input type="submit" name="button" id="button" value="Tampil">
    </form>
</body>

</html>