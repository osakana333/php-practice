<?php include_once '../header.php'; ?>

<?php


$array = [ //配列の１要素目を正解、残りを問題にする
  'カナダ' => ['オタワ','オタワ','トロント','モントリオール','バンクーバー'],
  'スイス' => ['ベルン','ジュネーブ','チューリッヒ','ベルン'],
  'ドイツ' => ['ベルリン','ハンブルク','ブレーメン','ベルリン'],
  'スペイン' => ['マドリード','バルセロナ','マドリード','リスボン'],
  'オーストラリア' => ['キャンベラ','シドニー','メルボルン','キャンベラ'],
  'デンマーク' => ['コペンハーゲン','コペンハーゲン','オーデンセ','コリング'],
  'アメリカ' => ['ワシントンD.C','ニューヨーク','ロサンゼルス','フィラデルフィア','ワシントンD.C']
];

echo '<form name="radioB" method="post">';
$cnt = 0 ; //ここに最終的な問題数が入る

foreach ($array as $key => $value) {
  $cnt++;
  echo $key.'の首都は？<br>';
  foreach ($value as $tmpkey => $tmpval) {
    if ($tmpkey==0) {
      continue;
    }
    echo '<label><input type="radio" name="Q'.$cnt.'" value="'.$tmpval.'"';
    //ここにポストで分岐してcheckedをつけられたら送信された値を引き継げる
    echo '>'.$tmpval.'</label><br>';
  }
  echo '<br>' ;
}

echo '
<input type="hidden" name="saiten">
<input type="submit" value="採点" onClick="saiten()">
</form>';

if (isset($_POST['saiten'])) {

  //----------------------------------拾ってきた比率計算の関数
  function num2per($number, $total, $precision = 0) {
    if ($number < 0) {
      return 0;
    }
    try {
        $percent = ($number / $total) * 100;
        return round($percent, $precision);
      } catch (Exception $e) {
        return 0;
      }
    }
  //------------------------------------------------ここまで

  $i = 0; //foreachのループ数を一時的にカウントする
  $ans = 0; //正解した数
  $noans = 0; //未回答数

  //----------------正解数チェック
  foreach ($array as $key => $value) {
    $i++;
    if (isset($_POST['Q'.$i])) {
      if ($value[0] == $_POST['Q'.$i]) {
      $ans++;
    }
    } else {
      $noans++;
    }
  }

  //-------------得点の表示
  echo '<hr>
  <p>あなたの得点は「'.num2per($ans,$cnt,0).'」点です。
  <p>('.$cnt.'問中'.$ans.'問正解、未回答'.$noans.'問)
  ';
}


?>


<?php include_once '../footer.php'; ?>