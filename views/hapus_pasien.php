<?php
require "../include/db.php";

$id = $_GET['id'];

if (hapus_pasien($id) > 0){
    echo"
        <script>
            alert('Data Berhasil Dihapus !');
            window.location.href = 'pasien.php';
        </script>
        ";
    }else {
        echo "
            <script>
                alert('Data Gagal Dihapus !');
                window.location.href = 'pasien.php';
            </script>
        ";
    }
?>
