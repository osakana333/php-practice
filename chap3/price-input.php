<?php require '../header.php'; ?>

<?php

?>


<form action="price-output.php" method="post">
  <p>
    単価 <input type="number" name="price" id="price" min="0" value="0"> 円
  </p>
  <p>
    個数 <input type="number" name="count" id="count" min="0" value="0"> 個
  </p>
  <input type="submit" value="計算">
</form>


<?php require '../footer.php'; ?>