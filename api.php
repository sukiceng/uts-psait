<?php
require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];


switch ($request_method) {
    case 'GET':
        if (!empty($_GET["nim"])) {
            $nim = $_GET["nim"];
            get_nilai_mahasiswa($nim);
        } else {
            get_all_nilai_mahasiswa();
        }
        break;
    case 'POST':
        insert_nilai_mahasiswa();
        break;
    case 'PUT':
        update_nilai_mahasiswa();
        break;
    case 'DELETE':
        delete_nilai_mahasiswa();
        break;
    default:
        // Metode permintaan tidak valid
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Fungsi untuk menampilkan semua nilai mahasiswa
function get_all_nilai_mahasiswa()
{
    global $mysqli;
    $query = "SELECT mahasiswa.nim, mahasiswa.nama, mahasiswa.alamat, matakuliah.nama_mk, perkuliahan.nilai
    FROM mahasiswa
    JOIN perkuliahan ON mahasiswa.nim = perkuliahan.nim
    JOIN matakuliah ON perkuliahan.kode_mk = matakuliah.kode_mk;";
    $data = array();
    $result = $mysqli->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Get List Nilai Mahasiswa Successfully.',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Fungsi untuk menampilkan nilai mahasiswa tertentu berdasarkan NIM
function get_nilai_mahasiswa($nim)
{
    global $mysqli;
    $query = "SELECT * FROM perkuliahan WHERE nim = '$nim'";
    $data = array();
    $result = $mysqli->query($query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    $response = array(
        'status' => 1,
        'message' => 'Get Nilai Mahasiswa Successfully.',
        'data' => $data
    );
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Fungsi untuk memasukkan nilai baru untuk mahasiswa tertentu
function insert_nilai_mahasiswa()
{
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $nim = $data['nim'];
    $kode_mk = $data['kode_mk'];
    $nilai = $data['nilai'];
    $result = mysqli_query($mysqli, "INSERT INTO perkuliahan (nim, kode_mk, nilai) VALUES ('$nim', '$kode_mk', $nilai)");
    if ($result) {
        $response = array(
            'status' => 1,
            'message' => 'Nilai Mahasiswa Added Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Nilai Mahasiswa Addition Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

// Fungsi untuk mengupdate nilai mahasiswa berdasarkan NIM dan kode_mk
function update_nilai_mahasiswa()
{
    global $mysqli;
    $data = json_decode(file_get_contents('php://input'), true);
    $nim = $data['nim'];
    $kode_mk = $data['kode_mk'];
    $nilai = $data['nilai'];
    
    $query = "UPDATE perkuliahan SET nilai = $nilai WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
    $result = mysqli_query($mysqli, $query);
    
    if ($result && mysqli_affected_rows($mysqli) > 0) {
        $response = array(
            'status' => 1,
            'message' => 'Nilai Mahasiswa Updated Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'message' => 'Nilai Mahasiswa Updation Failed.'
        );
    }
    
    header('Content-Type: application/json');
    echo json_encode($response);
}


// Fungsi untuk menghapus nilai mahasiswa berdasarkan NIM dan kode_mk
function delete_nilai_mahasiswa()
{
    global $mysqli;
    $json_data = file_get_contents('php://input');
    $data = json_decode($json_data, true);

    if (isset($data['nim']) && isset($data['kode_mk'])) {
        $nim = $data['nim'];
        $kode_mk = $data['kode_mk'];

        $query = "DELETE FROM perkuliahan WHERE nim = '$nim' AND kode_mk = '$kode_mk'";
        if (mysqli_query($mysqli, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Nilai Mahasiswa Deleted Successfully.'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Nilai Mahasiswa Deletion Failed.'
            );
        }
    } else {
        $response = array(
            'status' => 0,
            'message' => 'NIM and kode_mk are required.'
        );
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
    
?>
