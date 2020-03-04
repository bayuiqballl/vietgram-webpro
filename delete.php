<?php
session_start();
require_once 'function/functions.php';

$id = $_GET['id'];

if (hapusPhoto($id) > 0) {
    echo "<script>
    alert('data berhasil dihapus');
    document.location.href = 'explore.php'; 
    </script>";
} else {
    echo "<script>
    alert('Gagal dihapus');
    document.location.href = 'explore.php'; 
    </script>";
}
