<?php  
 // var_dump( $_POST['genre']) ;
  //これをループせずにカンマで区切って一行の文字列として表示する implode() 

  echo implode( " , ", $_POST['genre'] );
    // カンマ区切りにして｢カメラ , 時計｣
  