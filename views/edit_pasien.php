<?php
require "../include/db.php";
$id = $_GET['id'] ?? null;
$pasien = id_pasien($id);

if(isset($_POST["submit"])) {
    if (edit_pasien($_POST) > 0){
        echo "
            <script>
                alert('Data Berhasil Diedit !');
                window.location.href = 'pasien.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Data Gagal Diedit !');
                window.location.href = 'pasien.php';
            </script>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>Edit Pasien</title>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen py-10">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Edit Pasien</h2>

        <form action="edit_pasien.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <input type="hidden" name="id" value="<?= $pasien['id_pasien']; ?>">
            <input type="hidden" name="foto_lama" value="<?= $pasien['foto']; ?>">

            <div>
                <label class="block text-gray-700 font-semibold">Nama:</label>
                <input type="text" name="nama" value="<?= $pasien['nama']; ?>" class="shadow-lg w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" value="<?= $pasien['tanggal_lahir']; ?>" class="shadow-lg w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Jenis Kelamin:</label>
                <select name="jenis_kelamin" class="shadow-lg w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300">
                    <option value="Laki-laki" <?= $pasien['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                    <option value="Perempuan" <?= $pasien['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Agama:</label>
                <select name="agama" class="shadow-lg w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300">
                    <option value="Islam" <?= $pasien['agama'] == 'Islam' ? 'selected' : ''; ?>>Islam</option>
                    <option value="Kristen" <?= $pasien['agama'] == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                    <option value="Katolik" <?= $pasien['agama'] == 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                    <option value="Hindu" <?= $pasien['agama'] == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                    <option value="Buddha" <?= $pasien['agama'] == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                    <option value="Konghucu" <?= $pasien['agama'] == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Pendidikan:</label>
                <select name="pendidikan" class="shadow-lg w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300">
                    <option value="TK" <?= $pasien['pendidikan'] == 'TK' ? 'selected' : ''; ?>>TK</option>
                    <option value="SD" <?= $pasien['pendidikan'] == 'SD' ? 'selected' : ''; ?>>SD</option>
                    <option value="SMP" <?= $pasien['pendidikan'] == 'SMP' ? 'selected' : ''; ?>>SMP</option>
                    <option value="SMA" <?= $pasien['pendidikan'] == 'SMA' ? 'selected' : ''; ?>>SMA</option>
                    <option value="Diploma" <?= $pasien['pendidikan'] == 'Diploma' ? 'selected' : ''; ?>>Diploma</option>
                    <option value="Sarjana" <?= $pasien['pendidikan'] == 'Sarjana' ? 'selected' : ''; ?>>Sarjana</option>
                    <option value="Magister" <?= $pasien['pendidikan'] == 'Magister' ? 'selected' : ''; ?>>Magister</option>
                    <option value="Doktor" <?= $pasien['pendidikan'] == 'Doktor' ? 'selected' : ''; ?>>Doktor</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Diagnosa:</label>
                <input type="text" name="diagnosa" value="<?= $pasien['diagnosa']; ?>" class="shadow-lg w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Foto:</label>
                <input type="file" name="foto" class="shadow-lg w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" accept="image/*">
                <?php if ($pasien['foto']) : ?>
                    <img src="../uploads/<?= $pasien['foto']; ?>" class="w-20 h-20 object-cover mt-2 rounded-md">
                <?php endif; ?>
            </div>

            <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-600 transition text-white px-4 py-2 rounded-md font-semibold">Update</button>
        </form>
    </div>
</body>
</html>