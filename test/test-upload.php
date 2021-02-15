<?php require '../header.php'; ?>
<?php
if (is_uploaded_file($_FILES['file']['tmp_name'])) {

	// ファイルタイプを調べる
	$mime = mime_content_type($_FILES['file']['tmp_name'] );
	//これらのタイプしか受け付けない
	if( $mime == 'image/jpeg' || $mime == 'image/png' || $mime == 'image/gif'){
		
		if (!file_exists('upload')) mkdir('upload'); //なければディレクトリを作る
		
		$file='upload/'.basename($_FILES['file']['name']);
		if ( move_uploaded_file($_FILES['file']['tmp_name'], $file) ) {
			echo $file, 'のアップロードに成功しました。';
			echo '<p><img src="', $file, '"></p>';
		} else {
			echo 'アップロードに失敗しました。';
		}
	}else{
		echo "アップできるファイルは jpg/png/gif のみです｡";
	}

} else {
	echo 'ファイルを選択してください。';
}



//許可するMIME
$cfg['ALLOW_MIME'] = array('image/jpeg', 'image/png');

//ファイルのMIMEタイプが許可されているかチェックする関数
function checkMIME($filename){
	global $cfg;
	$mime = mime_content_type($tmp_name);
	return in_array($mime, $cfg['ALLOW_MIME']);
}

?>
<?php require '../footer.php'; ?>