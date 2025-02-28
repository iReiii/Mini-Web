<?php
require "../include/db.php";
$pasien = data_pasien();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>Data Pasien</title>
</head>
<body class="bg-gray-50 flex h-screen">

    <aside class="w-64 bg-blue-900 text-white flex flex-col p-5">
        <h2 class="text-2xl font-bold mb-6">🏥 Rumah Sakit</h2>
        <nav class="space-y-3">
            <a href="dashboard.php" class="block p-3 bg-blue-700 rounded-md hover:bg-blue-600">🏠 Home</a>
            <a href="pasien.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🛏️ Pasien</a>
            <a href="../auth/logout.php" class="block p-3 bg-red-600 rounded-md hover:bg-red-700">🚪 Logout</a>
        </nav>
    </aside>

    <div class="flex-1 p-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Data Pasien</h2>
            
            <a href="tambah_pasien.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">+ Tambah Pasien</a>

            <div class="overflow-x-auto mt-6">
                <table class="w-full border-collapse text-md text-gray-700">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-2 py-1 text-left">No</th>
                            <th class="px-2 py-1 text-left">Nama</th>
                            <th class="px-2 py-1 text-left">Tanggal Lahir</th>
                            <th class="px-2 py-1 text-left">Jenis Kelamin</th>
                            <th class="px-2 py-1 text-left">Agama</th>
                            <th class="px-2 py-1 text-left">Pendidikan</th>
                            <th class="px-2 py-1 text-left">Diagnosa</th>
                            <th class="px-2 py-1 text-left">Foto</th>
                            <th class="px-2 py-1 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        <?php $i=1; ?>
                        <?php foreach ($pasien as $row): ?>
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-2 py-1"><?= ($i); ?></td>
                                <td class="px-2 py-1"><?= ($row['nama']); ?></td>
                                <td class="px-2 py-1"><?= ($row['tanggal_lahir']); ?></td>
                                <td class="px-2 py-1"><?= ($row['jenis_kelamin']); ?></td>
                                <td class="px-2 py-1"><?= ($row['agama']); ?></td>
                                <td class="px-2 py-1"><?= ($row['pendidikan']); ?></td>
                                <td class="px-2 py-1"><?= ($row['diagnosa']); ?></td>
                                <td class="px-2 py-1 flex justify-center">
                                    <?php if ($row['foto']): ?>
                                        <img src="../uploads/<?= $row['foto']; ?>" alt="Foto Pasien" class="w-12 h-12 object-cover rounded-md">
                                    <?php else: ?>
                                        <span class="text-gray-500">Tidak Ada Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-2 py-1 text-center space-x-1">
                                    <a href="edit_pasien.php?id=<?= $row['id_pasien']; ?>" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600 transition">Edit</a>
                                    <a href="hapus_pasien.php?id=<?= $row['id_pasien']; ?>" onclick="return confirm('Yakin ingin menghapus?');" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-700 transition">Hapus</a>
                                    <a href="export_pdf.php?id=<?= $row['id_pasien']; ?>" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600 transition">📄 Export PDF</a>
                                </td>
                            </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>