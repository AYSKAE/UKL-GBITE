<?php
    session_start();
    session_destroy();
?>

<script type= "text/javascript">
    alert('Selamat, anda berhasil logout.');
    location.href = "/UKL_GBITE/user/login/index.php";
</script>