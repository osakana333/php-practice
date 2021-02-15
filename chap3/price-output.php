<?php require '../header.php'; ?>
<?php

$prise = $_REQUEST['price'] ;
$count = $_REQUEST['count'] ;
$resurt = $prise*$count ;
$taxin = ceil($resurt*1.08) ;

echo '<p>';
echo $prise, '円×' ;
echo $count, '個=' ;
echo $resurt, '円';
echo '　税込 ', $taxin, '円';
echo '</p>';

?>
<?php require '../footer.php'; ?>