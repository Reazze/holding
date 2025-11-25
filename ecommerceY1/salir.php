<?php
session_start();
if(isset($_SESSION['user'])){
}

session_destroy();
print "<script>window.location='./';</script>";
?>