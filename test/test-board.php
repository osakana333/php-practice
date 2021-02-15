<?php include_once '../header.php'; ?>

<form method="post">
<p><input type="text" name="name" placeholder="投稿者名">
<p><textarea name="message" rows="6" cols="40" placeholder="投稿するメッセージを入力してください。" required></textarea>
<p><input pattern="^[\w]+$" type="text" name="pswd" placeholder="編集パス" size="8" title="投稿したメッセージを編集したい場合は、編集パスを半角英数で入力してください。">
<input type="submit" value="投稿">
</form>
<hr>


<?php

//変数の定義
$file='board.txt';

if (file_exists($file)) { //過去ログがあれば読み込む
  $board=json_decode(file_get_contents($file));
}

if (isset($_POST['message'])) { //メッセージがあるかどうか
  $tmp_st = $_POST['message'] ;
  $tmp_st = htmlspecialchars($tmp_st,ENT_QUOTES) ;
  //投稿内容をチェックする分岐はここに入れる

    $name = $_POST['name'];
    $name = htmlspecialchars($name,ENT_QUOTES) ;
    $name  = preg_replace("/( |　)/", "", $name );
    if ($name=='') {
      $name = '名無しさん';
    }
  
    $pswd = $_POST['pswd'];
    $pswd = htmlspecialchars($pswd,ENT_QUOTES) ;
    $pswd  = preg_replace("/( |　)/", "", $pswd );
    if (preg_match("/[a-zA-Z_0-9]/",$pswd)=='') {
      $pswd = 'none';
    }

  //ログにポストされた投稿を追加する
  $postday = date("Y-m-d H:i:s");
  $board[] = [$name,$tmp_st,$postday,$pswd] ; //0>名前 1>内容 2>時刻 3>編集パス

  //ログを時間で降順にソートする
  $sort_tm = array();
  foreach ($board as $key => $val) {
    $sort_tm[] = $val[2] ;
  }
  array_multisort($sort_tm,SORT_DESC,$board);
}

if(isset($board)) { //過去ログが存在するか、あるいはポストがあれば書き出しを行う
  file_put_contents($file,json_encode($board));
  chmod($file,0664);
  
  //メッセージの表示処理------------------
  foreach ($board as $text) {
    echo '<p>'.nl2br($text[1]).'</p>
    <p>'.$text[0].'　/　'.$text[2].'</p>
    <hr>';
  }
  //------------------------------------
} else { //なければまだ投稿なしの表示
  echo '<p>まだ投稿がありません。</p>';
}

?>

<?php include_once '../footer.php'; ?>