<?php
require $_SERVER['DOCUMENT_ROOT'] . '/RS/include/db.php';

$sort = $_GET['sort'] ?? 'nama';
$order = $_GET['order'] ?? 'ASC'; 

$pasien = data_pasien($sort, $order);

    if (isset($_POST["cari"])) {
        $pasien = cari_pasien($_POST['keyword']);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/RS/src/output.css" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <title>Data Pasien</title>
</head>
<body class="bg-gray-50 flex h-screen">
    <aside class="w-64 bg-blue-900 text-white flex flex-col p-5 min-h-screen">
        <h2 class="text-2xl font-bold mb-6">🏥 Rumah Sakit</h2>
        <nav class="space-y-3">
            <a href="../dashboard.php" class="block p-3 bg-blue-700 rounded-md hover:bg-blue-600">🏠 Home</a>
            <a href="pasien.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🛏️ Pasien</a>
            <a href="../dokter/dokter.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🧑‍⚕️ Dokter</a>
            <a href="/RS/auth/logout.php" class="block p-3 bg-red-600 rounded-md hover:bg-red-700">🚪 Logout</a>
        </nav>
    </aside>

    <div class="flex-1 p-8">
        <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Data Pasien</h2>

                <div class="flex items-center gap-4"> 
                    <a href="tambah_pasien.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition">+ Tambah Pasien</a>
                    <a href="export_pdf_all.php" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition inline-flex items-center">
                        <i data-lucide="file-text" class="mr-2"></i> 
                        <span>Export All</span> 
                    </a>                
                </div>
            </div>

            <form action="pasien.php" method="POST" class="mb-6">
                <div class="flex items-center gap-4">
                    <input type="text" name="keyword" class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan nama pasien..." autofocus autocomplete="off">
                    <button type="submit" name="cari" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">Cari</button>
                </div>
            </form>
            
            <div class="overflow-x-auto mt-6">
                <table class="w-full border-collapse text-md text-gray-700">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-2 py-1 text-left">
                                <a href="?sort=nama&order=<?= $sort === 'nama' && $order === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    No <?= $sort === 'nama' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th class="px-2 py-1 text-left">
                                <a href="?sort=nama&order=<?= $sort === 'nama' && $order === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    Nama <?= $sort === 'nama' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th class="px-2 py-1 text-left">
                                <a href="?sort=tanggal_lahir&order=<?= $sort === 'tanggal_lahir' && $order === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    Tanggal Lahir <?= $sort === 'tanggal_lahir' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th class="px-2 py-1 text-left">
                                <a href="?sort=jenis_kelamin&order=<?= $sort === 'jenis_kelamin' && $order === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    Jenis Kelamin <?= $sort === 'jenis_kelamin' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th class="px-2 py-1 text-left">
                                <a href="?sort=agama&order=<?= $sort === 'agama' && $order === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    Agama <?= $sort === 'agama' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th class="px-2 py-1 text-left">
                                <a href="?sort=pendidikan&order=<?= $sort === 'pendidikan' && $order === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    Pendidikan <?= $sort === 'pendidikan' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th class="px-2 py-1 text-left">
                                <a href="?sort=diagnosa&order=<?= $sort === 'diagnosa' && $order === 'ASC' ? 'DESC' : 'ASC' ?>">
                                    Diagnosa <?= $sort === 'diagnosa' ? ($order === 'ASC' ? '↑' : '↓') : '' ?>
                                </a>
                            </th>
                            <th class="px-2 py-1 text-left">Foto</th>
                            <th class="px-2 py-1 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-300">
                    <?php if (!empty($pasien)): ?>
                        <?php $i = 1; ?>
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
                                        <img src="/RS/uploads/<?= $row['foto']; ?>" alt="Foto Pasien" class="w-12 h-12 object-cover rounded-md">
                                    <?php else: ?>
                                        <span class="text-gray-500">Tidak Ada Foto</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-2 py-1 text-center space-x-1">
                                    <a href="edit_pasien.php?id=<?= $row['id_pasien']; ?>" class="bg-yellow-500 text-white px-2 py-1 rounded-md hover:bg-yellow-600 transition inline-flex items-center justify-center">
                                        <i data-lucide="edit-3"></i>
                                    </a>
                                    <a href="hapus_pasien.php?id=<?= $row['id_pasien']; ?>" onclick="return confirm('Yakin ingin menghapus?');" class="bg-red-500 text-white px-2 py-1 rounded-md hover:bg-red-800 transition inline-flex items-center justify-center">
                                        <i data-lucide="trash-2"></i>
                                    </a>
                                    <a href="export_pdf_pasien.php?id=<?= $row['id_pasien']; ?>" class="bg-blue-500 text-white px-2 py-1 rounded-md hover:bg-blue-600 transition inline-flex items-center justify-center">
                                        <i data-lucide="file-text"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $i++; ?>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center text-gray-500">Tidak ada data pasien.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>