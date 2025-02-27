<?php
$conn = new PDO("pgsql:host=localhost;dbname=db_rumahsakit", 'lumm', '123');
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function total_pasien(){
    global $conn;
    $queryPasien = $conn->query("SELECT COUNT(*) as total FROM pasien");
    $totalPasien = $queryPasien->fetch(PDO::FETCH_ASSOC)['total'];
    return $totalPasien;
}

function data_pasien_terbaru(){
    global $conn;
    $queryTerbaru = $conn->query("SELECT * FROM pasien ORDER BY id_pasien DESC LIMIT 5");
    $pasienTerbaru = $queryTerbaru->fetchAll(PDO::FETCH_ASSOC);
    return $pasienTerbaru;
}

function data_pasien(){
    global $conn;
    $query = $conn->query("SELECT * FROM pasien ORDER BY id_pasien ASC");
    $pasien = $query->fetchAll(PDO::FETCH_ASSOC);
    return $pasien;
}

function tambah_pasien($data){
    global $conn;
    $nama = htmlspecialchars($data['nama']);
    $tanggal_lahir = htmlspecialchars($data['tanggal_lahir']);
    $jenis_kelamin = htmlspecialchars($data['jenis_kelamin']);
    $agama = htmlspecialchars($data['agama']);
    $pendidikan = htmlspecialchars($data['pendidikan']);
    $diagnosa = htmlspecialchars($data['diagnosa']);

    $foto = "";
    if ($_FILES['foto']['name']) {
        $target_dir = "../uploads/";
        $foto = uniqid() . "_" . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);
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

function id_pasien($id) {
    global $conn;
    if (!$id) return null; 
    $sql = $conn->prepare("SELECT * FROM pasien WHERE id_pasien = :id");
    $sql->execute(['id' => $id]);
    return $sql->fetch(PDO::FETCH_ASSOC); 
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
    $foto_lama = htmlspecialchars($data['foto_lama']);

    $foto = $foto_lama;
    if ($_FILES['foto']['name']) {
        $target_dir = "../uploads/";
        $foto = uniqid() . "_" . basename($_FILES["foto"]["name"]);
        $target_file = $target_dir . $foto;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file);

        if ($foto_lama && file_exists($target_dir . $foto_lama)) {
            unlink($target_dir . $foto_lama);
        }
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

function hapus_pasien($id){
    global $conn;
    $query = $conn->prepare("SELECT foto FROM pasien WHERE id_pasien = :id");
    $query->execute(['id' => $id]);
    $pasien = $query->fetch(PDO::FETCH_ASSOC);

    if ($pasien) {
        if ($pasien['foto'] && file_exists("../uploads/" . $pasien['foto'])) {
            unlink("../uploads/" . $pasien['foto']);
        }

    $sql = "DELETE FROM pasien WHERE id_pasien = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['id' => $id]);
    }
    return $stmt->rowCount() > 0;
}
?>