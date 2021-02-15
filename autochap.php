<?php
  $path = '../php-practice/';
  if (isset($_POST["file_select"])) {
    $select = $_POST["dir_select"];
    $select2 = $_POST["file_select"];
    if ($select2 == "cn_php") {
    } else {
    header("Location:".$path.$select."/".$select2);
    exit();
    }
  }
?>

<?php require './header.php'; ?>

<?php

//---------------------------------dir select

$dirlist = scandir($path);
for ($i=0; $i < count($dirlist); $i++) { 
  if ($dirlist[$i]=='..' or $dirlist[$i]=='.') {
    unset($dirlist[$i]) ;
  }
}

echo '
<p>「php-practice」からディレクトリを選択してください。</p>
<form action="autochap.php" method="post">
<select name="dir_select" id="dir_select">
';

foreach ($dirlist as $dir) {
  switch ($path.$dir) {
    case is_dir($path.$dir):
      echo '<option value="',$dir,'">',$dir,'</option>';
      break;
    case is_file($path.$dir):
      break;
    default:
      break;
  }
}

echo '<option value="cn_dir">【新規作成】</option>
</select>
<p><input type="submit" value="決定"></p>
</form>
';

//--------------------------------file select

if (isset($_POST["dir_select"])) {
  
  $select = $_POST["dir_select"];
  if ($select == "cn_dir") { 
    
    // ****************************cn dir ここから********************************
    echo '<hr>
    <p>「php-practice」にディレクトリを新規作成します。</p>';

      if (isset($_POST["cn_newdir"])) {
        $cn_newdir = $_POST["cn_newdir"] ;
      } else {
        $cn_newdir ='';
      }

      switch ($cn_newdir) {
      
        case 'dir_1': //入力されたディレクトリ名を精査して確認
          $dir_name = $_POST["dir_name"];
          $dir_name = preg_replace("/( |　)/", "", $dir_name);
          $dir_name = htmlspecialchars($dir_name,ENT_QUOTES) ;

          if (file_exists($path.$dir_name)) { //重複チェック
            echo $dir_name.'は同名のディレクトリが既に存在します。
            <form method="post">
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="submit" value="更新"></form>';

          } else { //重複してなければおｋ
          echo '
          <P>追加するディレクトリの名前は<br>
          【'.$dir_name.'】でよろしいですか？</P>
          <p><form method="post">
            <input type="hidden" name="cn_newdir" value="dir_2">
            <input type="hidden" name="dir_name" value="'.$dir_name.'">
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="submit" value="決定">
          </form></p>
          <p><form method="post">
            <input type="hidden" name="cn_newdir" value="">
            <input type="hidden" name="dir_name" value="'.$dir_name.'"> 
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="submit" value="やり直す">
          </form></p>
          ';
          }
          break;
    
        case 'dir_2': //ディレクトリを生成 †*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†* ★
          $dir_name = $_POST["dir_name"];
          $dir_name = preg_replace("/( |　)/", "", $dir_name);
          $dir_name = htmlspecialchars($dir_name,ENT_QUOTES) ;
          
          if (mkdir($path.$dir_name.'/')) { 
            chmod($dir_name,0777);
            echo 'ディレクトリ「'.$dir_name.'」を作成しました。
            <form method="post"><input type="submit" value="更新"></form>';

          } else { 
            echo 'ディレクトリ「'.$dir_name.'」の作成に失敗しました。
            <form method="post"><input type="submit" value="更新"></form>';

          }

          //†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*
          break;
          
        default:
        # ディレクトリ名を入力させる

        if (isset($_POST["dir_name"])) {
          $dir_name = $_POST["dir_name"];
          $dir_name = preg_replace("/( |　)/", "", $dir_name);
          $dir_name = htmlspecialchars($dir_name,ENT_QUOTES) ;
        } else {
          $dir_name = '';
        }

        echo '
        <p>ディレクトリ名を半角英数記号(ﾊｲﾌﾝ,ｱﾝﾀﾞｰﾊﾞｰ)で入力してください。</p>
        <form method="post">
        <input type="text" name="dir_name" pattern="^[-\w]+$" value="'.$dir_name.'" required>
        <input type="hidden" name="cn_newdir" value="dir_1">
        <input type="hidden" name="dir_select" value="'.$select.'">
        <input type="submit" value="決定">
        </form>
        ';
          break;
      }

    // ****************************cn dir ここまで********************************

  } else { //それ以外のときは当該ディレクトリの内容を表示
    $dir_select = "./".$_POST["dir_select"]."/" ;
    $filelist = scandir($dir_select) ;
    for ($i=0; $i < count($filelist); $i++) { 
      if ($filelist[$i]=='..' or $filelist[$i]=='.') {
        unset($filelist[$i]) ;
      }
    }
  
    echo '<hr>
    <p>「php-practice/'.$select.'」から開くファイルを選択してください。　※ディレクトリは表示されません</p>
    <form action="autochap.php" method="post">
    <select name="file_select" id="file_select">
    ';
    foreach ($filelist as $file) {
      switch ($dir_select.$file) {
        case is_dir($dir_select.$file):
          break;
        case is_file($dir_select.$file): //今度はファイルを取得する
          echo '<option value="',$file,'">',$file,'</option>';
          break;
        default: //cssとか画像は弾く
          break;
      }
    }
    echo '
    <option value="cn_php">【PHPファイル新規作成】</option>
    </select>
    <input type="hidden" name="dir_select" value="'.$select.'">
    <p><input type="submit" value="決定"></p> 
    </form>' ;
  }

}

//----------------------------------file cn

  if (isset($_POST["file_select"])) { //file選択がされたかどうか
    $select2 = $_POST["file_select"];
    if ($select2 == "cn_php") {
      // ****************************cn php ここから********************************
      echo '<hr>
      <p>「php-practice/'.$select.'/」にphp ファイルを新規作成します。</p>';

      // 入力フォーム file_selectとdir_selectをhiddenで飛ばす 
      // file_selectがcn_phpのとき、cn_newfileに進捗状態を保存して分岐する
      
      if (isset($_POST["cn_newfile"])) {
        $cn_newfile = $_POST["cn_newfile"] ;
      } else {
        $cn_newfile ='';
      }
      
      switch ($cn_newfile) {
      
        case 'file_1': //入力されたファイル名を精査して確認
          $file_name = $_POST["file_name"];
          $file_name = preg_replace("/( |　)/", "", $file_name);
          $file_name = htmlspecialchars($file_name,ENT_QUOTES) ;
      

          if (file_exists($path.$select.'/'.$file_name.'.php')) { //重複チェック
            echo $file_name.'は同名のファイルが既に存在します。
            <form method="post">
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="hidden" name="file_select" value="'.$select2.'">
            <input type="submit" value="更新"></form>';

          } else { //重複してなければおｋ
          
          echo $path.$select.'/'.$file_name;
          echo '
          <P>追加するphp ファイルの名前は<br>
          【'.$file_name.'】でよろしいですか？</P>
          <p><form method="post">
            <input type="hidden" name="cn_newfile" value="file_2">
            <input type="hidden" name="file_name" value="'.$file_name.'">
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="hidden" name="file_select" value="'.$select2.'">
            <input type="submit" value="決定">
          </form></p>
          <p><form method="post">
            <input type="hidden" name="cn_newfile" value="">
            <input type="hidden" name="file_name" value="'.$file_name.'">
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="hidden" name="file_select" value="'.$select2.'">
            <input type="submit" value="やり直す">
          </form></p>
          ';

          }
          break;
      
        case 'file_2': //php ファイルを生成 †*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†*†* ★
          $file_name = $_POST["file_name"];
          $file_name = preg_replace("/( |　)/", "", $file_name);
          $file_name = htmlspecialchars($file_name,ENT_QUOTES) ;
          $filepath = $path.$select.'/'.$file_name.'.php';
          
          if (touch($filepath)) {

            // 作成したphpファイルにheaderとfooterを書き込む
            chmod($filepath,0664);
            file_put_contents($filepath,"<?php include_once '../header.php'; ?>\n<?php include_once '../footer.php'; ?>");

            echo 'php ファイル「'.$file_name.'」を作成しました。
            <form method="post">
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="submit" value="更新">
            </form>';

          } else { 
            echo 'ディレクトリ「'.$file_name.'」の作成に失敗しました。
            <form method="post">
            <input type="hidden" name="dir_select" value="'.$select.'">
            <input type="submit" value="更新"></form>';

          }
          break;
          
        default:
        # php ファイル名を入力させる
      
        if (isset($_POST["file_name"])) {
          $file_name = $_POST["file_name"];
          $file_name = preg_replace("/( |　)/", "", $file_name);
          $file_name = htmlspecialchars($file_name,ENT_QUOTES) ;
        } else {
          $file_name = '';
        }
      
        echo '
        <p>php ファイル名を半角英数記号(ﾊｲﾌﾝ,ｱﾝﾀﾞｰﾊﾞｰ)で入力してください。</p>
        <form method="post">
        <input type="text" name="file_name" pattern="^[-\w]+$" value="'.$file_name.'" required>
        <input type="hidden" name="cn_newfile" value="file_1">
        <input type="hidden" name="dir_select" value="'.$select.'">
        <input type="hidden" name="file_select" value="'.$select2.'">
        <input type="submit" value="決定">
        </form>
        ';
          break;
      }

      // ****************************cn php ここまで********************************
    }
  } 

?>

<?php require './footer.php'; ?>