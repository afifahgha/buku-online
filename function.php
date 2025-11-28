<?php
$conn = mysqli_connect("localhost", "root", "", "buku_online");


// fungsi untuk menampilkan data dari database
// function query($query)
// {
//     global $conn;
//     $result = mysqli_query($conn, $query);
//     $rows = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//         $rows[] = $row;
//     }
//     return $rows;
// }

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);

    // Jika query error, tampilkan sebabnya
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }

    return $rows;
}


// fungsi untuk menambahkan data ke database
function tambah_data($data)
{
    global $conn;

    $id_kategori = $data['id_kategori'];
    $judul_buku = $data['judul_buku'];
    $penulis = $data['penulis'];
    $penerbit = $data['penerbit'];
    $tahun_terbit = $data['tahun_terbit'];
    // $gambar = $data['gambar'];

    $gambar = upload_gambar($judul_buku, $penulis);  // outputnya adalah nim_nama.eksentsi
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO buku (id_kategori, judul_buku, penulis, penerbit, tahun_terbit, gambar)
                  VALUES ('$id_kategori','$judul_buku', '$penulis', '$penerbit', '$tahun_terbit', '$gambar')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// fungsi untuk upload gambar
function upload_gambar($judul_buku, $penulis)
{

    // setting gambar
    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang diupload
    if ($error === 4) {
        echo "<script>
            alert('pilih gambar terlebih dahulu!');
        </script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
            alert('yang anda upload bukan gambar!');
        </script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
// maks --> 5MB
    if ($ukuranFile > 5000000) {
        echo "<script>
            alert('ukuran gambar terlalu besar!');
        </script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
// generate nama gambar baru
    $namaFileBaru = $judul_buku . "_" . $penulis;
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

// fungsi tambah data kategori
function tambah_kategori($data)
{
    global $conn;

    $nama_kategori = $data['nama_kategori'];

    $query = "INSERT INTO kategori (nama_kategori)
                  VALUES ('$nama_kategori')";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// fungsi untuk menghapus data dari database
function hapus_data($id)
{
    global $conn;
    $query = "DELETE FROM buku WHERE id_buku = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// fungsi untuk menghapus kategori dari database
function hapus_kategori($id)
{
    global $conn;
    $query = "DELETE FROM kategori WHERE id_kategori = $id";
    $result = mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// fungsi untuk mengubah data dari database
function ubah_data($data)
{
    global $conn;

    $id_buku = $data['id_buku'];
    $judul_buku = $data['judul_buku'];
    $penulis = $data['penulis'];
    $penerbit = $data['penerbit'];
    $tahun_terbit = $data['tahun_terbit'];
    $buku_lama = query("SELECT * FROM buku WHERE id_buku = $id_buku")[0];
    $gambar_lama = $buku_lama['gambar'];
    $id_kategori = $data['id_kategori'];

    // cek apakah ada upload gambar baru
    if ($_FILES['gambar']['error'] === 4) {
        // tidak ganti gambar
        $ekstensi = pathinfo($gambar_lama, PATHINFO_EXTENSION);
        $nama_baru = $judul_buku . "_" . $penulis . "." . $ekstensi;

        if ($nama_baru !== $gambar_lama) {
            rename("img/" . $gambar_lama, "img/" . $nama_baru);
        }
        $gambar = $nama_baru;
        // $gambar = $gambar_lama;
    } else {
        // upload gambar baru
        $gambar = upload_gambar($judul_buku, $penulis);
        // $gambar = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp, "img/" . $gambar);

        // hapus gambar lama
        if (file_exists("img/" . $gambar_lama)) {
            unlink("img/" . $gambar_lama);
        }
    }

    $query = "UPDATE buku SET
                judul_buku = '$judul_buku',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tahun_terbit = '$tahun_terbit',
                gambar = '$gambar',
                id_kategori = '$id_kategori'
              WHERE id_buku = '$id_buku'
             ";

    $result = mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// fungsi untuk mengubah kategori dari database
function ubah_kategori($data)
{
    global $conn;

    $id_kategori = $data['id_kategori'];
    $nama_kategori = $data['nama_kategori'];

    $query = "UPDATE kategori SET
                nama_kategori = '$nama_kategori'
              WHERE id_kategori = '$id_kategori'
             ";

    $result = mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// fungsi untuk mencari data
function search_data($keyword)
{
    global $conn;

    $query = "SELECT buku.*, kategori.nama_kategori
              FROM buku
              JOIN kategori ON buku.id_kategori = kategori.id_kategori
              WHERE 
                buku.judul_buku LIKE '%$keyword%' OR
                kategori.nama_kategori LIKE '%$keyword%'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}


// fungsi untuk mencari data di kategori
function search_kategori($keyword)
{
    global $conn;

    $query = "SELECT kategori.*, 
               COUNT(buku.id_buku) AS jumlah_buku
        FROM kategori
        LEFT JOIN buku ON kategori.id_kategori = buku.id_kategori
        WHERE kategori.nama_kategori LIKE '%$keyword%'";

    $result = mysqli_query($conn, $query);

    if (!$result) {
        die("Query error: " . mysqli_error($conn));
    }

    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// fungsi untuk register
function register($data)
{
    global $conn;


    $username = strtolower($data['username']);
    $email = $data['email'];
    $password = mysqli_real_escape_string($conn, $data['password']);
    // $konfirmasi_password = mysqli_real_escape_string($conn, $data['confirm_password']);


    // query untuk ngecek username yang diinputkan oleh user di database
    $query = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    $result = mysqli_fetch_assoc($query);


    if ($result != NULL) {
        return "Username sudah terdaftar!";
    }

    if (strlen($password) < 8) {
        return "Password minimal 8 karakter!";
    }

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // tambahkan userbaru ke database
    mysqli_query($conn, "INSERT INTO user (username, email, password) VALUES('$username', '$email', '$password')");

    return true;
}

// fungsi untuk login
function login($data)
{
    global $conn;

    $username = $data['username'];
    $password = $data['password'];

    $query = "SELECT * FROM user WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $row['username'];
            return true;
        } else {
            return "Password salah!";
        }

    } else {
        return "Username tidak terdaftar!";
    }
}

?>