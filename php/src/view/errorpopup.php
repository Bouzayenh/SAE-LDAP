<?php 
if(!isset($_SESSION)){
    session_start();
}
?>

<div class="errorpopup">
 <p><? echo $_SESSION['error_message'] ?></p>
</div>