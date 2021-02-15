<?php include_once '../header.php'; ?>

<?php

if (is_uploaded_file($_FILES['file']['tmp_name'])) {

$tmpfile = $_FILES['file']['tmp_name'];  //一時ファイルの場所を取得

if (!file_exists('upload')) { //アップロードフォルダがなければ作成
  mkdir('upload');
}
$file='upload/'. basename($_FILES['file']['name']);  //ファイルを配置する場所を取得
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
        echo '
        <p>このファイルはアップロードできません。
        <p>jpg、gif、pngのいずれかの画像ファイルのみアップロード可能です。
        ';
        exit();
}

//最終確認、ちゃんとイメージが表示されるかをチェックする
if (@imagecreatefromstring(file_get_contents($filepath)) == false) {
  echo '
  <p>このファイルはアップロードできません。
  <p>jpg、gif、pngのいずれかの形式の画像ファイルのみアップロード可能です。
  ';
  exit();
}

  if(move_uploaded_file($tmpfile,$file)) {
    echo '「'.$file.'」のアップロードに成功しました。
    <p><img src="'.$file.'"></p>
    ';
  } else {
    echo 'ファイルのアップロードに失敗しました。';
  }
  //-------------------------------------------------
} else {
  echo 'ファイルを選択してください。';
}


?>

<?php include_once '../footer.php'; ?>