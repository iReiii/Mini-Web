<?php
require "../include/db.php";
$totalPasien = total_pasien();
$pasien = data_pasien_terbaru();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../src/output.css" rel="stylesheet">
    <title>Dashboard Rumah Sakit</title>
</head>
<body class="bg-gray-100 flex h-screen">
    <aside class="w-64 bg-blue-900 text-white flex flex-col p-5">
        <h2 class="text-2xl font-bold mb-6">🏥 Rumah Sakit</h2>
        <nav class="space-y-3">
            <a href="dashboard.php" class="block p-3 bg-blue-700 rounded-md hover:bg-blue-600">🏠 Home</a>
            <a href="pasien.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🛏️ Pasien</a>
            <a href="dokter.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🧑‍⚕️ Dokter</a>
            <a href="../auth/logout.php" class="block p-3 bg-red-600 rounded-md hover:bg-red-700">🚪 Logout</a>
        </nav>
    </aside>

    <main class="flex-1 p-6">
        <header class="bg-white shadow-md p-4 rounded-md mb-6">
            <h1 class="text-xl font-bold">Selamat Datang di Dashboard Rumah Sakit</h1>
        </header>

        <section class="grid grid-cols-3 gap-4 mb-6">
            <div class="bg-white p-5 rounded-lg shadow flex items-center">
                <div class="text-3xl text-blue-500">🧑‍⚕️</div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold">Dokter</h2>
                    <p class="text-gray-600">0</p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-lg shadow flex items-center">
                <div class="text-3xl text-green-500">🛏️</div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold">Pasien</h2>
                    <p class="text-gray-600"><?= $totalPasien; ?></p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-lg shadow flex items-center">
                <div class="text-3xl text-yellow-500">📅</div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold">Jadwal Hari Ini</h2>
                    <p class="text-gray-600">0</p>
                </div>
            </div>
        </section>

        <section class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-lg font-bold mb-4">Pasien Terbaru</h2>
            <div class="overflow-x-auto">
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
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                        <?php $i=1; ?>
                        <?php foreach ($pasien as $row): ?>
                            <tr class="hover:bg-gray-100 transition">
                                <td class="px-2 py-1"><?= $i; ?></td>
                                <td class="px-2 py-1"><?= $row['nama']; ?></td>
                                <td class="px-2 py-1"><?= $row['tanggal_lahir']; ?></td>
                                <td class="px-2 py-1"><?= $row['jenis_kelamin']; ?></td>
                                <td class="px-2 py-1"><?= $row['agama']; ?></td>
                                <td class="px-2 py-1"><?= $row['pendidikan']; ?></td>
                                <td class="px-2 py-1"><?= $row['diagnosa']; ?></td>
                                <td class="px-2 py-1 flex justify-center">
                                    <?php if ($row['foto']): ?>
                                        <img src="../uploads/<?= $row['foto']; ?>" alt="Foto Pasien" class="w-12 h-12 object-cover rounded-md">
                                    <?php else: ?>
                                        <span class="text-gray-500">Tidak Ada Foto</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php $i++; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>
