<?php
require $_SERVER['DOCUMENT_ROOT'] . '/RS/include/db.php';
session_start();

$userId = $_SESSION['id_users'];
$foto = $_SESSION['foto'] ?? 'default.jpg';

if (isset($_POST['upload'])) {
    profile($userId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-100 flex min-h-screen">
    <aside class="w-64 bg-blue-900 text-white flex flex-col p-5 min-h-screen">
        <h2 class="text-2xl font-bold mb-6">🏥 Rumah Sakit</h2>
        <nav class="space-y-3">
            <a href="dashboard.php" class="block p-3 bg-blue-700 rounded-md hover:bg-blue-600">🏠 Home</a>
            <a href="pasien/pasien.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🛏️ Pasien</a>
            <a href="dokter/dokter.php" class="block p-3 bg-blue-800 rounded-md hover:bg-blue-700">🧑‍⚕️ Dokter</a>
            <a href="/RS/auth/logout.php" class="block p-3 bg-red-600 rounded-md hover:bg-red-700">🚪 Logout</a>
        </nav>
    </aside>

    <div class="flex-1 p-8 flex justify-center items-center min-h-screen">
        <div class="w-full max-w-lg bg-white p-8 rounded-lg shadow-lg mt-10"> 
            <h2 class="text-2xl font-bold text-center mb-6">Edit Profile</h2>
            <div class="flex justify-center mb-6">
                <div class="w-50 h-50 rounded-full overflow-hidden">
                    <img src="/RS/uploads/<?= htmlspecialchars($foto); ?>" alt="" class="w-full h-full object-cover" />
                </div>
            </div>

            <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
                <div class="md:col-span-2 mb-4"> 
                    <label class="block text-gray-700 font-semibold mb-2">Foto:</label>
                    <input type="file" name="foto" class="shadow-md w-full p-2 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-300" accept="image/*">
                </div>
                <div class="flex justify-center mt-6">
                    <button type="submit" name="upload" class="w-full bg-green-500 hover:bg-green-600 transition text-white px-4 py-2 rounded-md font-semibold">Upload</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>