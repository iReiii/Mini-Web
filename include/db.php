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

function id_pasien($id) {
    global $conn;
    $sql = $conn->prepare("SELECT * FROM pasien WHERE id_pasien = :id");
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
    $target_file = '../uploads/' . $namaFoto;
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

    if($_FILES['foto']['error'] === 4){
        $foto = $foto_lama;
    }else {
        if (!empty($foto_lama) && file_exists("../uploads/" . $foto_lama)) {
            unlink("../uploads/" . $foto_lama);
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

function hapus_pasien($id){
    global $conn;
    $pasien = id_pasien($id);

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