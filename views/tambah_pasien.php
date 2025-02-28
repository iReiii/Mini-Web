<?php
require "../include/db.php";
if (isset($_POST["submit"])) {
    if (tambah_pasien($_POST) > 0) {
        echo"
            <script>
                alert('Data Berhasil Ditambahkan !');
                window.location.href = 'pasien.php';
            </script>
        ";
    }else {
        echo "
            <script>
                alert('Data Gagal Ditambahkan !');
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
    <title>Tambah Pasien</title>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen py-10">
    <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-bold text-center mb-6">Tambah Pasien</h2>

        <form action="tambah_pasien.php" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-gray-700 font-semibold">Nama:</label>
                <input type="text" name="nama" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Tanggal Lahir:</label>
                <input type="date" name="tanggal_lahir" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Jenis Kelamin:</label>
                <select name="jenis_kelamin" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Agama:</label>
                <select name="agama" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300">
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katolik">Katolik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Buddha">Buddha</option>
                    <option value="Konghucu">Konghucu</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Pendidikan:</label>
                <select name="pendidikan" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300">
                    <option value="TK">TK</option>
                    <option value="SD">SD</option>
                    <option value="SMP">SMP</option>
                    <option value="SMA">SMA</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Sarjana">Sarjana</option>
                    <option value="Magister">Magister</option>
                    <option value="Doktor">Doktor</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Diagnosa:</label>
                <input type="text" name="diagnosa" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
            </div>
            
            <div>
                <label class="block text-gray-700 font-semibold">Foto:</label>
                <input type="file" name="foto" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" accept="image/*">
            </div>

            <button type="submit" name="submit" class="w-full bg-green-500 hover:bg-green-600 transition text-white px-4 py-2 rounded-md font-semibold">Tambah</button>
        </form>
    </div>
</body>
</html>
