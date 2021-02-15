<?php
  include_once '../header.php';
  require_once '../database.php'; ?>
<p>
<form method="post">
<input type="text" name="keyword" id="keyword">
<input type="submit" value="検索">
<input type="button" onclick="location.href='database_menu.php'" value="すべて表示">
</form>
</p>
<div class="th0">No</div>
    <div class="th1">商品名</div>
    <div class="th3">価格</div>
    <div class="th4">画像ファイル</div>
    <br>

<?php

//検索、一覧、編集ページ(database_edit.php)へのリンク
//検索フラグが立ってたら検索結果を表示、そうじゃない場合は一覧を表示する
//検索内容が白紙だったら一覧を表示する

if (isset($_POST['keyword'])) { //POSTされた検索キーワードのチェック
  $keyword = $_POST['keyword'] ;
  $keyword = preg_replace("/( |　)/", "", $keyword ) ;
  $keyword = htmlspecialchars($keyword,ENT_QUOTES) ;

  if ($keyword=='') {
    $keyword = null ;
  }
}

if (isset($keyword)) {
  //----------------------------------------- 検索結果を表示する

  $sql=$pdo->prepare('select * from product where name like ?');
  $sql->execute(['%'.$_POST['keyword'].'%']);

  $result = $sql->rowCount();
  if ($result==0) {
    echo '
    <div class="td0"></div>
    該当する検索結果はありません。
    ';

  } else {
    
    foreach ($sql as $row) {
      ?>
      <div class="td0">
        <?=$row['id']?>
      </div>
      <div class="td1">
        <?=$row['name']?>
      </div>
      <div class="td3">
        <?=$row['price']?>
      </div>
      <div class="td4">
        <?php
          if(!empty($row['image'])) {
            echo $row['image'];
          } else {
            echo 'NO IMAGE';
          }
        ?>
      </div>
      <br>
      <?php
    }
    echo '</table>';
  }
  
} else {
  //----------------------------------------- 一覧で表示する
  
    foreach ($pdo->query('select * from product') as $row) {
      ?>
      <div class="td0">
        <?=$row['id']?>
      </div>
      <div class="td1">
        <?=$row['name']?>
      </div>
      <div class="td3">
        <?=$row['price']?>
      </div>
      <div class="td4">
        <?php
          if(!empty($row['image'])) {
            echo $row['image'];
          } else {
            echo 'NO IMAGE';
          }
        ?>
      </div>
      <br>
      <?php
    }
  
  echo '</table>';
  
  //----------------------------------------- 一覧ここまで
}

?>

<br><p>
<form>
<input type="button" onclick="location.href='database_edit.php'" value="編集画面">
</form>

<?php include_once '../footer.php'; ?>
