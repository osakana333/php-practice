<?php require '../header.php'; ?>

<p>アップロードするファイルを指定してください。</p>
<p>形式:画像(jpg/png/gif)</p>

<form action="test-upload.php" method="post" enctype="multipart/form-data">
<p><input type="file" name="file" id="file_upload" accept="image/png,image/jpeg,image/gif" required></p>
<p><input type="submit" value="アップロード"></p>
</form>

<?php require '../footer.php'; ?>