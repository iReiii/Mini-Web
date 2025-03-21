<?php
require "../include/db.php";

$error = "";

if (isset($_POST['submit'])) {
    $error = register($_POST);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>Register Page</title>
</head>
<body class="bg-gray-700 flex justify-center items-center h-screen">
    <div class="rounded-lg shadow-lg bg-white p-6 w-96">
        <h1 class="text-2xl font-bold mb-4 text-center">Register Page</h1>
        <form action="register.php" method="POST" class="flex flex-col space-y-4">
            <!-- Input Username -->
            <label for="username" class="font-semibold">Username:</label>
            <input type="text" name="username" placeholder="Masukkan Username" required 
                   class="border border-gray-300 p-2 rounded-md block w-full focus:outline-none focus:ring-1 focus:ring-sky-500">

            <!-- Input Password -->
            <label for="password" class="font-semibold">Password:</label>
            <input type="password" name="password" placeholder="Masukkan Password" required 
                   class="border border-gray-300 p-2 rounded-md block w-full focus:outline-none focus:ring-1 focus:ring-sky-500">

            <!-- Input Konfirmasi Password -->
            <label for="confirm_password" class="font-semibold">Konfirmasi Password:</label>
            <input type="password" name="confirm_password" placeholder="Konfirmasi Password" required 
                   class="border border-gray-300 p-2 rounded-md block w-full focus:outline-none focus:ring-1 focus:ring-sky-500">

            <!-- Tampilkan Pesan Error -->
            <?php if (!empty($error)): ?>
                <p class="text-red-600 text-sm"><?= $error ?></p>
            <?php endif; ?>

            <div class="flex items-center justify-between">
                <p class="text-sm text-gray-500">
                    Have Already an Account?
                    <a class="underline hover:text-blue-400" href="login.php">Sign In</a>
                </p>
            </div>

            <!-- Tombol Register -->
            <button type="submit" name="submit" 
                    class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition">Register</button>
        </form>
    </div>
</body>
</html>