<?php
require $_SERVER['DOCUMENT_ROOT'] . '/RS/include/db.php';
$id = $_GET['id'] ?? null;
$dokter = id_dokter($id);

if (isset($_POST["submit"])) {
    if (edit_dokter($_POST) > 0) {
        echo "
            <script>
                window.location.href = 'dokter.php';
            </script>
        ";
    } else {
        echo "
            <script>
                window.location.href = 'dokter.php';
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
    <link href="/RS/src/output.css" rel="stylesheet">
    <title>Edit Dokter</title>
</head>
<body class="bg-gray-50 flex min-h-screen">
    <aside class="w-64 bg-blue-900 text-white flex flex-col p-5">
        <h2 class="text-2xl font-bold mb-6">🏥 Rumah Sakit</h2>
        <nav class="space-y-3">
            <a href="../dashboard.php" class="block p-3 bg-blue-700 rounded-md hover:bg-blue-600">🏠 Home</a>
            <a href="../pasien/pasien.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🛏️ Pasien</a>
            <a href="dokter.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🧑‍⚕️ Dokter</a>
            <a href="/RS/auth/logout.php" class="block p-3 bg-red-600 rounded-md hover:bg-red-700">🚪 Logout</a>
        </nav>
    </aside>

    <div class="flex-1 p-8 flex justify-center items-center min-h-screen">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg mt-10">
            <h2 class="text-2xl font-bold text-center mb-6">Edit Dokter</h2>

            <form action="edit_dokter.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                <input type="hidden" name="id" value="<?= $dokter['id_dokter']; ?>">
                <input type="hidden" name="foto_lama" value="<?= $dokter['foto']; ?>">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Nama:</label>
                        <input type="text" name="nama" value="<?= $dokter['nama']; ?>" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Tanggal Lahir:</label>
                        <input type="date" name="tanggal_lahir" value="<?= $dokter['tanggal_lahir']; ?>" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin:</label>
                        <div class="flex gap-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="Laki-laki" class="form-radio text-blue-600" <?= $dokter['jenis_kelamin'] == 'Laki-laki' ? 'checked' : ''; ?>>
                                <span class="ml-2">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="jenis_kelamin" value="Perempuan" class="form-radio text-blue-600" <?= $dokter['jenis_kelamin'] == 'Perempuan' ? 'checked' : ''; ?>>
                                <span class="ml-2">Perempuan</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Agama:</label>
                        <select name="agama" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300">
                            <option value="Islam" <?= $dokter['agama'] == 'Islam' ? 'selected' : ''; ?>>Islam</option>
                            <option value="Kristen" <?= $dokter['agama'] == 'Kristen' ? 'selected' : ''; ?>>Kristen</option>
                            <option value="Katolik" <?= $dokter['agama'] == 'Katolik' ? 'selected' : ''; ?>>Katolik</option>
                            <option value="Hindu" <?= $dokter['agama'] == 'Hindu' ? 'selected' : ''; ?>>Hindu</option>
                            <option value="Buddha" <?= $dokter['agama'] == 'Buddha' ? 'selected' : ''; ?>>Buddha</option>
                            <option value="Konghucu" <?= $dokter['agama'] == 'Konghucu' ? 'selected' : ''; ?>>Konghucu</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-semibold mb-2">Spesialisasi:</label>
                        <input type="text" name="spesialisasi" value="<?= $dokter['spesialisasi']; ?>" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" required>
                    </div>

                    <div class="md:col-span-2 mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Foto:</label>
                        <input type="file" name="foto" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" accept="image/*">
                        <?php if ($dokter['foto']) : ?>
                            <img src="/RS/uploads/<?= $dokter['foto']; ?>" class="w-20 h-20 object-cover mt-2 rounded-md">
                        <?php endif; ?>
                    </div>
                </div>

                <div class="flex justify-center mt-6">
                    <button type="submit" name="submit" class="w-full bg-blue-500 hover:bg-blue-600 transition text-white px-4 py-2 rounded-md font-semibold">Update</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>