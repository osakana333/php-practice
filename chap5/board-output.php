<?php include_once '../header.php'; ?>

<?php

//変数の定義
$file='board.txt';

if (file_exists($file)) { //過去ログがあれば読み込む
  $board=json_decode(file_get_contents($file));
}

//配列にポストされたメッセージを追加する
$tmp_st = $_POST['message'] ;
$tmp_st = htmlspecialchars($tmp_st,ENT_QUOTES) ;
$board[] = $tmp_st ;

//ログ書き出し
file_put_contents($file,json_encode($board));
chmod($file,0664);

//メッセージの表示処理------------------
foreach ($board as $message) {
  echo '<p>'.$message.'</p><hr>';
}
//------------------------------------


?>

<?php include_once '../footer.php'; ?>