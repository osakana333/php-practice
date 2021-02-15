<?php require '../header.php'; ?>

<?php
if (isset($_POST["backbtn"])) {
	$user		= $_POST["user"];
	$user		= htmlspecialchars($user, ENT_QUOTES);
} else {
  $user = '';
}
?>

<p>お名前を入力してください。</p>

<form action="user-output.php" method="post">
  <input type="text" name="user" value="<?=$user?>">
  <input type="submit" value="確定">
</form>

<?php require '../footer.php'; ?>