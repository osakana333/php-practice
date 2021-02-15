<?php include_once '../header.php'; ?>

<?php

$array = [
  'カナダ' => ['オタワ','トロント','モントリオール'],
  'スイス' => ['ジュネーブ','チューリッヒ','ベルン'],
  'ドイツ' => ['ハンブルク','ブレーメン','ベルリン'],
  'スペイン' => ['バルセロナ','マドリード','リスボン'],
  'オーストラリア' => ['シドニー','メルボルン','キャンベラ'],
  'デンマーク' => ['コペンハーゲン','オーデンセ','コリング']
];

echo '<form name="radioB" method="post">';
$cnt = 0 ; //ここに最終的な問題数が入る

 //foreachのネストサンプル-----------------------------------------------------
foreach ($array as $key => $value) {
  $cnt++;
  echo $key.'の首都は？<br>';
  foreach ($value as $tmpkey => $tmpval) { //ここは仮想配列じゃないので$value as $tmpvalでも同じ動きをする
    //$arrayの各keyに保存した配列を取り出したいときは$valueを指定する
    //このときは仮想配列じゃないので$tmpkeyには数字が、$tmpvalには都市名が入っている
    echo '<input type="radio" name="Q'.$cnt.'" value="'.$tmpval.'">'.$tmpval.'<br>';
  }
  echo '<br>' ;
}
//foreach($array as $value)だと$valueには直接真下の配列が取り出される($value[数字]で取り出す)
//-----------------------------------------------------------------------------

echo '
<input type="hidden" name="saiten">
<input type="submit" value="採点" onClick="saiten()">
</form>';

if (isset($_POST['saiten'])) {

  //

  //-------------得点の表示
  echo '<hr>
  あなたの得点は「」点です。
  ';
}


?>


<?php include_once '../footer.php'; ?>