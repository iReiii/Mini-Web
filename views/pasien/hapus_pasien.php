<?php
require $_SERVER['DOCUMENT_ROOT'] . '/RS/include/db.php';

$id = $_GET['id'];

if (hapus_pasien($id) > 0){
    echo"
        <script>
            window.location.href = 'pasien.php';
        </script>
        ";
    }else {
        echo "
            <script>
                window.location.href = 'pasien.php';
            </script>
        ";
    }
?>
