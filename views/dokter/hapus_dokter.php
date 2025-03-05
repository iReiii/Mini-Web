<?php
require $_SERVER['DOCUMENT_ROOT'] . '/RS/include/db.php';

$id = $_GET['id'];

if (hapus_dokter($id) > 0){
    echo"
        <script>
            window.location.href = 'dokter.php';
        </script>
        ";
    }else {
        echo "
            <script>
                window.location.href = 'doktesr.php';
            </script>
        ";
    }
?>
