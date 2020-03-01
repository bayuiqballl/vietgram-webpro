<?php
// koneksi database
$koneksi = mysqli_connect("localhost", "root", "", "vietgram");

// menampilkan isi query
function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] =  $row;
    }
    return $rows;
}

// tambah photo
function tambahPhoto($data)
{
    global $koneksi;
    $caption = htmlspecialchars($data['caption']);
    // $like = $data['like'];
    //upload gambar 
    $gambar = upload();
    if (!$gambar) {
        return false;
    }

    $query = "INSERT INTO photo VALUES ('','$gambar','$caption')";
    mysqli_query($koneksi, $query);

    return mysqli_affected_rows($koneksi);
}

function upload()
{

    $namaFile = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error = $_FILES['gambar']['error'];
    $tmpName = $_FILES['gambar']['tmp_name'];

    // cek apakah tidak ada gambar yang di upload  
    if ($error === 4) {
        echo "<script>
		 	alert('Pilih Gambar terlebih dahulu!');
		</script>";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));
    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        echo "<script>
    	 	alert('yang di upload bukan gambar');
    	</script>";
        return false;
    }

    // cek jika ukurannya terlalu besar
    if ($ukuranFile > 1000000) {
        echo "<script>
		 	alert('ukuran anda terlalu besar');
		</script>";
        return false;
    }

    // lolos pengecekan, gambar siap diupload
    // generate nama gambar baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiGambar;

    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);
    echo var_dump($gambar);
    return $namaFileBaru;
}

function hapusPhoto($id)
{
    global $koneksi;
    mysqli_query($koneksi, "DELETE FROM mahasiswa WHERE id = $id");
    return mysqli_affected_rows($koneksi);
}
// ==================================================
