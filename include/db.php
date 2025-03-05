<?php
$conn = new PDO("pgsql:host=localhost;dbname=db_rumahsakit", 'lumm', '123');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function login($data) {
    global $conn;
    $username = $data['username'];
    $password = $data['password'];

    $sql = "SELECT id_users, username, password, foto FROM users WHERE username = :username";
    $query = $conn->prepare($sql);
    $query->bindParam(':username', $username, PDO::PARAM_STR);
    $query->execute();

    $user = $query->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['id_users'] = $user['id_users'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['foto'] = $user['foto'];
            header("Location: ../views/dashboard.php");
            exit;
        } else {
            return "Password salah!";
        }
    } else {
        return "Username tidak ditemukan!";
    }
}

function register($data) {
    global $conn;

    $username = htmlspecialchars($data['username']);
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];

    if ($password !== $confirm_password) {
        return "Password dan konfirmasi password tidak cocok!";
    }

    $query = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $query->execute([$username]);

    if ($query->rowCount() > 0) {
        return "Username sudah digunakan!";
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $foto = 'default.jpg';

    $stmt = $conn->prepare("INSERT INTO users (username, password, foto) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $hashed_password, $foto])) {
        header("Location: login.php");
        exit();
    } else {
        return "Gagal mendaftar. Silakan coba lagi!";
    }
}

function profile($userId) {
    global $conn;

    $query = $conn->prepare("SELECT foto FROM users WHERE id_users = ?");
    $query->execute([$userId]);
    $user = $query->fetch();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["foto"]) && $_FILES["foto"]["error"] == 0) {
            $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/RS/uploads/";

            $fileName = time() . "_" . basename($_FILES["foto"]["name"]);
            $targetFile = $targetDir . $fileName;

            if (!empty($user['foto']) && $user['foto'] !== 'default.jpg') {
                $oldFile = $targetDir . $user['foto'];
                if (file_exists($oldFile)) {
                    unlink($oldFile); 
                }
            }

            move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFile);
                $stmt = $conn->prepare("UPDATE users SET foto = ? WHERE id_users = ?");
                $stmt->execute([$fileName, $userId]);
                $_SESSION['foto'] = $fileName;
                header("Location: dashboard.php");
                exit();
        }
    }
}

function total_pasien(){
    global $conn;
    $queryPasien = $conn->query("SELECT COUNT(*) as total FROM pasien");
    $totalPasien = $queryPasien->fetch(PDO::FETCH_ASSOC)['total'];
    return $totalPasien;
}

function total_dokter(){
    global $conn;
    $queryDokter = $conn->query("SELECT COUNT(*) as total FROM dokter");
    $totalDokter = $queryDokter->fetch(PDO::FETCH_ASSOC)['total'];
    return $totalDokter;
}

function data_pasien($sort = 'nama', $order = 'ASC') {
    global $conn;
    $allowed_columns = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'pendidikan', 'diagnosa'];
    $sort = in_array($sort, $allowed_columns) ? $sort : 'nama';
    $order = $order === 'DESC' ? 'DESC' : 'ASC'; 

    $query = "SELECT * FROM pasien ORDER BY $sort $order";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function data_dokter($sort = 'nama', $order = 'ASC'){
    global $conn;
    $allowed_columns = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'agama', 'spesialisasi'];
    $sort = in_array($sort, $allowed_columns) ? $sort : 'nama';
    $order = $order === 'DESC' ? 'DESC' : 'ASC'; 

    $query = "SELECT * FROM dokter ORDER BY $sort $order";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function id_pasien($id) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM pasien WHERE id_pasien = :id");
    $sql->execute(['id' => $id]);
    return $sql->fetch(PDO::FETCH_ASSOC); 
}

function id_dokter($id){
    global $conn;
    $sql = $conn->prepare("SELECT * FROM dokter WHERE id_dokter = :id");
    $sql->execute(['id' => $id]);
    return $sql->fetch(PDO::FETCH_ASSOC);
}

function tambah_pasien($data){
    global $conn;
    $nama = htmlspecialchars($data['nama']);
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir']);
    $jenis_kelamin = htmlspecialchars($data['jenis_kelamin']);
    $agama = htmlspecialchars($data['agama']);
    $pendidikan = htmlspecialchars($data['pendidikan']);
    $diagnosa = htmlspecialchars($data['diagnosa']);

    $foto = upload_foto();
    if (!$foto){
        return false;
    }

    $sql = "INSERT INTO pasien (nama, tanggal_lahir, jenis_kelamin, agama, pendidikan, diagnosa, foto) VALUES (:nama, :tanggal_lahir, :jenis_kelamin, :agama, :pendidikan, :diagnosa, :foto)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nama' => $nama,
        'tanggal_lahir' => $tanggal_lahir,
        'jenis_kelamin' => $jenis_kelamin,
        'agama' => $agama,
        'pendidikan' => $pendidikan,
        'diagnosa' => $diagnosa,
        'foto' => $foto
    ]);
    return $stmt->rowCount() > 0;
}

function tambah_dokter($data){
    global $conn;
    $nama = htmlspecialchars($data['nama']);
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir']);
    $jenis_kelamin = htmlspecialchars($data['jenis_kelamin']);
    $agama = htmlspecialchars($data['agama']);
    $spesialisasi = htmlspecialchars($data['spesialisasi']);

    $foto = upload_foto();
    if(!$foto){
        return false;
    }

    $sql = "INSERT INTO dokter (nama, tanggal_lahir, jenis_kelamin, agama, spesialisasi, foto) VALUES (:nama, :tanggal_lahir, :jenis_kelamin, :agama, :spesialisasi, :foto)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nama' => $nama,
        'tanggal_lahir' => $tanggal_lahir,
        'jenis_kelamin' => $jenis_kelamin,
        'agama' => $agama,
        'spesialisasi' => $spesialisasi,
        'foto' => $foto
    ]);
    return $stmt->rowCount() > 0;
}

function upload_foto(){
    global $conn;
    $namaFoto = $_FILES['foto']['name'];
    $ukuranFoto = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    if ($_FILES['foto']['error'] === 4){
        echo "
            <script>
                alert('Foto Harus Diupload !');
            </script>
        ";
        return false;
    }

    if ($ukuranFoto > 3000000){
        echo "
            <script>
                alert('Ukuran File Terlalu Besar !');
            </script>
        ";
        return false;
    }

    $namaFoto = uniqid() . '_' . $namaFoto;
    $target_file = $_SERVER['DOCUMENT_ROOT'] . '/RS/uploads/' . $namaFoto;
    move_uploaded_file($tmpName, $target_file);
    return $namaFoto;
}

function edit_pasien($data){
    global $conn;
    $id = htmlspecialchars($data['id']);
    $nama = htmlspecialchars($data['nama']);
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir']);
    $jenis_kelamin = htmlspecialchars($data['jenis_kelamin']);
    $agama = htmlspecialchars($data['agama']);
    $pendidikan = htmlspecialchars($data['pendidikan']);
    $diagnosa = htmlspecialchars($data['diagnosa']);
    $foto_lama = $data['foto_lama'];
    $foto_path = $_SERVER['DOCUMENT_ROOT'] . "/RS/uploads/" . $foto_lama;

    if($_FILES['foto']['error'] === 4){
        $foto = $foto_lama;
    }else {
        if (!empty($foto_lama) && file_exists($foto_path)) {
            unlink($foto_path);
        }
        $foto = upload_foto();
    }

    $sql = "UPDATE pasien SET nama = :nama, tanggal_lahir = :tanggal_lahir, jenis_kelamin = :jenis_kelamin, agama = :agama, pendidikan = :pendidikan, diagnosa = :diagnosa, foto = :foto WHERE id_pasien = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nama' => $nama,
        'tanggal_lahir' => $tanggal_lahir,
        'jenis_kelamin' => $jenis_kelamin,
        'agama' => $agama,
        'pendidikan' => $pendidikan,
        'diagnosa' => $diagnosa,
        'foto' => $foto,
        'id' => $id
    ]);
    return $stmt->rowCount() > 0;
}

function edit_dokter($data){
    global $conn;
    $id = htmlspecialchars($data['id']);
    $nama = htmlspecialchars($data['nama']);
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir']);
    $jenis_kelamin = htmlspecialchars($data['jenis_kelamin']);
    $agama = htmlspecialchars($data['agama']);
    $spesialisasi = htmlspecialchars($data['spesialisasi']);
    $foto_lama = $data['foto_lama'];
    $foto_path = $_SERVER['DOCUMENT_ROOT'] . "/RS/uploads/" . $foto_lama;

    if($_FILES['foto']['error'] === 4){
        $foto = $foto_lama;
    }else {
        if (!empty($foto_lama) && file_exists($foto_path)) {
            unlink($foto_path);
        }
        $foto = upload_foto();
    }

    $sql = "UPDATE dokter SET nama = :nama, tanggal_lahir = :tanggal_lahir, jenis_kelamin = :jenis_kelamin, agama = :agama, spesialisasi = :spesialisasi, foto = :foto WHERE id_dokter = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        'nama' => $nama,
        'tanggal_lahir' => $tanggal_lahir,
        'jenis_kelamin' => $jenis_kelamin,
        'agama' => $agama,
        'spesialisasi' => $spesialisasi,
        'foto' => $foto,
        'id' => $id
    ]);
    return $stmt->rowCount() > 0;
}

function hapus_pasien($id){
    global $conn;
    $pasien = id_pasien($id);
    $foto_path = $_SERVER['DOCUMENT_ROOT'] . "/RS/uploads/" . $pasien['foto'];

    if ($pasien) {
        if ($pasien['foto'] && file_exists($foto_path)) {
            unlink($foto_path);
        }

    $sql = "DELETE FROM pasien WHERE id_pasien = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    }
    return $stmt->rowCount() > 0;
}

function hapus_dokter($id){
    global $conn;
    $dokter = id_dokter($id);
    $foto_path = $_SERVER['DOCUMENT_ROOT'] . "/RS/uploads/" . $dokter['foto'];

    if ($dokter) {
        if ($dokter['foto'] && file_exists($foto_path)) {
            unlink($foto_path);
        }

    $sql = "DELETE FROM dokter WHERE id_dokter = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    }
    return $stmt->rowCount() > 0;
}

function total_pasien_by_gender($gender) {
    global $conn;
    $query = $conn->prepare("SELECT COUNT(*) FROM pasien WHERE jenis_kelamin = :gender");
    $query->bindParam(":gender", $gender, PDO::PARAM_STR);
    $query->execute();
    return $query->fetchColumn();
}

function cari_pasien($keyword) {
    global $conn;
    $query = "SELECT * FROM pasien WHERE nama ILIKE :keyword";
    $stmt = $conn->prepare($query);
    $stmt->execute(['keyword' => "%$keyword%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cari_dokter($keyword) {
    global $conn;
    $query = "SELECT * FROM dokter WHERE nama ILIKE :keyword";
    $stmt = $conn->prepare($query);
    $stmt->execute(['keyword' => "%$keyword%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>