<?php
require("function.php");
$id = $_GET['id'];
if (hapus_kategori($id) > 0) {
    echo "
<script>
    alert('Data berhasil dihapus dari database!');
    document.location.href = 'kategori.php';
</script>
";
} else {
    echo "
<script>
    alert('Data gagal dihapus dari database!');
    document.location.href = 'kategori.php';
</script>
";
}
?>