<?php include_once '../header.php'; ?>

<form method="post">
<p><input type="text" name="name" placeholder="投稿者名">
<p><textarea name="message" rows="6" cols="40" placeholder="投稿するメッセージを入力してください。" required></textarea>
<p><input pattern="^[\w]+$" type="text" name="pswd" placeholder="編集パス" size="8" title="投稿したメッセージを編集したい場合は、編集パスを半角英数で入力してください。">
<input type="submit" value="投稿">
<input type="button" value="更新"> <!--こっこのボタン 死んでる-->
</form>
<hr>

<?php

//変数の定義
$file='board.txt';

if (file_exists($file)) { //過去ログがあれば読み込む
  $board=json_decode(file_get_contents($file));
}

if (isset($_POST['message'])) {
//メッセージがポストされていれば、配列に追加する
  $tmp_st = $_POST['message'] ;
  $tmp_st = htmlspecialchars($tmp_st,ENT_QUOTES) ;
  $board[] = $tmp_st ;
}

if(isset($board)) { //過去ログが存在するか、あるいはポストがあれば書き出しを行う
  file_put_contents($file,json_encode($board));
  chmod($file,0664);
  
  //メッセージの表示処理------------------
  foreach ($board as $message) {
    echo '<p>'.nl2br($message).'</p>
    <hr>';
  }
  //------------------------------------
} else { //なければまだ投稿なしの表示
  echo '<p>まだ投稿がありません。</p>';
}


?>

<?php include_once '../footer.php'; ?>