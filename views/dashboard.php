<?php
require $_SERVER['DOCUMENT_ROOT'] . '/RS/include/db.php';
session_start();
$totalPasien = total_pasien();
$totalDokter = total_dokter();
$totalLaki = total_pasien_by_gender("Laki-laki"); 
$totalPerempuan = total_pasien_by_gender("Perempuan");
$namaPengguna = $_SESSION['username'];
$foto = $_SESSION['foto'] ?? 'default.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Dashboard Rumah Sakit</title>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <aside class="w-64 bg-blue-900 text-white flex flex-col p-5">
        <h2 class="text-2xl font-bold mb-6">🏥 Rumah Sakit</h2>
        <nav class="space-y-3">
            <a href="dashboard.php" class="block p-3 bg-blue-700 rounded-md hover:bg-blue-600">🏠 Home</a>
            <a href="pasien/pasien.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🛏️ Pasien</a>
            <a href="dokter/dokter.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🧑‍⚕️ Dokter</a>
            <a href="/RS/auth/logout.php" class="block p-3 bg-red-600 rounded-md hover:bg-red-700">🚪 Logout</a>
        </nav>
    </aside>

    <main class="flex-1 p-6">
        <header class="flex justify-between items-center bg-white p-4 shadow rounded-lg mb-6">
            <div class="text-lg font-semibold">Selamat Datang Di Dashboard Rumah Sakit!</div>
            <div class="flex items-center space-x-4">
                <div class="w-11 h-11 rounded-full overflow-hidden">
                    <a href="edit_profile.php">
                        <img src="/RS/uploads/<?= htmlspecialchars($foto); ?>" alt="" class="w-full h-full object-cover" />
                    </a>
                </div>
                <div class="text-lg font-semibold">Hi, <?= htmlspecialchars($_SESSION['username']); ?>!</div>
            </div>
        </header>

        <section class="flex justify-evenly gap-4 mb-6">
            <div class="bg-white p-5 rounded-lg shadow flex items-center flex-grow min-w-[250px]">
                <div class="text-3xl text-blue-500">🧑‍⚕️</div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold">Dokter</h2>
                    <p class="text-gray-600"><?= $totalDokter; ?></p>
                </div>
            </div>
            <div class="bg-white p-5 rounded-lg shadow flex items-center flex-grow min-w-[250px]">
                <div class="text-3xl text-green-500">🛏️</div>
                <div class="ml-4">
                    <h2 class="text-lg font-semibold">Pasien</h2>
                    <p class="text-gray-600"><?= $totalPasien; ?></p>
                </div>
            </div>
        </section>

        <div class="flex justify-around">
            <div class="flex justify-center mt-10">
                <div class="w-[600px] h-[300px]"> 
                    <canvas id="genderBarChart" width="500" height="200"></canvas>
                </div>
            </div>

            <div class="flex justify-center mt-10">
                <div class="w-[300px] h-[300px]">
                    <canvas id="doctorPatientPieChart"></canvas>
                </div>
            </div>
        </div>
    </main>

    <script>
        const ctxBar = document.getElementById('genderBarChart').getContext('2d');

        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: [<?= $totalLaki; ?>, <?= $totalPerempuan; ?>],
                    backgroundColor: ['#3B82F6', '#F472B6'],
                    borderColor: ['#1E40AF', '#BE185D'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctxPie = document.getElementById('doctorPatientPieChart').getContext('2d');

        new Chart(ctxPie, {
            type: 'pie',
            data: {
                labels: ['Dokter', 'Pasien'],
                datasets: [{
                    data: [<?= $totalDokter; ?>, <?= $totalPasien; ?>],
                    backgroundColor: ['#34D399', '#F87171'],
                    borderColor: ['#059669', '#B91C1C'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
    </script>

</body>
</html>
