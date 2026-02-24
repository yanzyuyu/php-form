<?php 
$nama = $_POST['nama'];
echo "Nama : " . $nama . "<br>";
echo "Daftar Belanja Anda : <br>";
for ($i = 1; $i <= 5; $i++) {
    $barang = "barang" . $i;
    if (isset($_POST[$barang])) {
        echo "- " . $_POST[$barang] . "<br>";
    }
}
?>