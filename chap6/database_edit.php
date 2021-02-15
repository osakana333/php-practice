<?php
  include_once '../header.php';
  require_once '../database.php'; ?>

<p><b>

<?php

if (isset($_POST['command'])) { //------------------------POSTが届いたときの処理
  $command=$_POST['command'];
  $errmsg='';

  if (isset($_POST['id'])) { //id処理
    $id=$_POST['id'];
  } else {
    $id='新規';
  }

  if (!empty($_POST['name'])) { //name処理
    $name = $_POST['name'];
    $name = preg_replace("/( |　)/", "", $name);
    $name = htmlspecialchars($name,ENT_QUOTES);
    if ($name=='') {
      $command='error';
      $errmsg='【！】No.'.$id.'の名前が空白です。';
    }
  } else {
    $name = 'none';
  }

  if (isset($_POST['price'])) { //price処理
    $price = $_POST['price'];
    $price = preg_replace("/( |　)/", "", $price);
    $price = htmlspecialchars($price,ENT_QUOTES);
    if ($price=='' || $price<1 || preg_match("/[^0-9]/",$price)) {
      $command='error';
      $errmsg='【！】No.'.$id.'の値段は1以上の正の整数で入力してください。';
    }
  } else {
    $price = 'none';
  }

if (isset($_FILES['image']['name'])) {
  
  if (is_uploaded_file($_FILES['image']['tmp_name'])) { //file処理★

    $tmpfile = $_FILES['image']['tmp_name'];  //一時ファイルの場所を取得
  
    if (@imagecreatefromstring(file_get_contents($tmpfile)) == false) {
      $command='error';
      $errmsg='【！】No.'.$id.'のサムネイルはjpg、png、gif形式の画像ファイルを指定してください。';
  
    } else { //画像ファイル
  
      if (!file_exists('upload')) { //アップロードフォルダがなければ作成
        mkdir('upload');
      }
    
      $file='upload/'. basename($_FILES['image']['name']);  //ファイルを配置する場所を取得
      $file=preg_replace('/\\.[^.\\s]{3,4}$/', '', $file); //拡張子を取り除く
  
      switch (@exif_imagetype($tmpfile)) { //拡張子を正しく修正する
      case 1:
          $file .= '.gif';
          break;
      case 2:
          $file .= '.jpg';
          break;
      case 3:
          $file .= '.png';
          break;
      default:
          $command='error';
          $errmsg='【！】No.'.$id.'のサムネイルはjpg、png、gif形式の画像ファイルを指定してください。';
          break;
      }
  
      if (!$command=='error') { //ここまででエラーが出ていなければファイルをアップロード
        if(!move_uploaded_file($tmpfile,$file)) {
          $command='error';
          $errmsg='【！】No.'.$id.'のサムネイルをアップロードできませんでした。';
        }
      }
  
    }
  
  } else {
    $file = 'NO IMAGE';
  }
} else {  //画像ファイルが空欄の場合 差し替えや削除に対応する？
 $file = 'NO IMAGE';
}

//---------------------------------------------------------------POST時処理ここまで

  switch ($command) {
    
    case 'insert': //追加
      if ($name=='none') {
        echo '【！】新規商品の名前を入力してください。';
      } elseif ($price=='none') {
        echo '【！】新規商品の値段を入力してください。';
      } else { //-----------------------------------------DBへの追加処理


        
        echo '▼新規商品を追加処理しました。'; //--------------追加ここまで
      }
      break;

    case 'update': //更新
      if ($name=='none') {
        echo '【！】No.'.$id.'の名前を入力してください。';
      } elseif ($price=='none') {
        echo '【！】No.'.$id.'の値段を入力してください。';
      } else { //-----------------------------------------DBへの更新処理

        //画像ファイルが更新されるとき、元あったファイルは削除する

        echo '◆No.'.$id.'を更新処理しました。'; //---------------ここまで
      }
      break;

    case 'delete':  //------------------------------------DBから削除処理
      
        //復元とかさせないので画像ファイルも削除する

      echo '◇No.'.$id.'を削除処理しました。'; //-----------------ここまで
      break;
    
    case 'error': //エラー
      echo $errmsg;
      break;
  }
} else {
  echo '【商品一覧の編集】';
}
?>

</b></p>
<div class="th0">No</div>
<div class="th1">商品名</div>
<div class="th3">価格</div>
<div class="th4">画像ファイルの変更・追加</div>
<br>

<?php //------------------------------編集画面の表示
foreach ($pdo->query('select * from product') as $row) {
?>
<form class="ib" method="post" enctype="multipart/form-data">
  <input type="hidden" name="command" value="update">
  <input type="hidden" name="id" value="<?=$row['id']?>">
  <div class="td0">
    <?=$row['id']?>
  </div>
  <div class="td1">
    <input type="text" class="name" name="name" value="<?=$row['name']?>">
  </div>
  <div class="td3">
    <input type="text" class="price" name="price" value="<?=$row['price']?>">
  </div>
  <div class="td4">
    <input type="file" name="image">
  </div>
  <div class="td2">
    <input type="submit" value="更新" onclick="return update_button(<?=$row['id']?>)">
  </div>
</form>
<form class="ib" method="post">
  <input type="hidden" name="command" value="delete">
  <input type="hidden" name="id" value="<?=$row['id']?>">
  <input type="submit" value="削除" onclick="return delete_button(<?=$row['id']?>)">
</form>
<br>
<?php
}
?>

<form method="post">
  <input type="hidden" name="command" value="insert">
  <div class="td0">+</div>
  <div class="td1"><input class="name" type="text" name="name"></div>
  <div class="td3"><input class="price" type="text" name="price"></div>
  <div class="td2"><input type="submit" value="追加"></div>
</form>

<p>
  <form>
  <input type="button" onclick="location.href='database_menu.php'" value="一覧へ戻る">
  </form>
</p>

<?php include_once '../footer.php'; ?>