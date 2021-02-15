<?php require '../header.php'; ?>

<?php

$user = $_POST["user"];
$user  = preg_replace("/( |　)/", "", $user );
$user = htmlspecialchars($user,ENT_QUOTES) ;

$limit = 14; // 文字数制限

$errmsg = '';

if ($user == '') {
  $errmsg = $errmsg.'<p>お名前が入力されていません。</p>';
}

if(mb_strlen($user) > $limit) { 
  $errmsg = $errmsg.'<p>お名前は'.$limit.'文字以内で入力してください。</p>';
  }

if ($errmsg != '') {
  echo $errmsg;
  
	echo '<form method="post" action="user-input.php">';
	echo '<input type="hidden" name="user" value="'.$user.'">';
	echo '<input type="submit" name="backbtn" value="前のページへ戻る">';
	echo '</form>';
} else {
	echo '<p>ようこそ、「', $user, '」さん。</p>';
}

?>

<?php require '../footer.php'; ?>