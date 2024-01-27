
<?php 
if(!isset($_SESSION)){
    session_start();
}
?>

<div class="popup">
 <p><? echo $_SESSION['message'] ?></p>
</div>