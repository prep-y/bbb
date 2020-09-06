<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/tutro/core/init.php';
$parentID = (int)$_POST['parentID'];
$child_query = $mysqli->query("SELECT * FROM categories WHERE parent = '$parentID' ORDER BY category");
ob_start();?>

    <option value=""></option>
    <?php while($child = mysqli_fetch_assoc($child_query)): ?>
        <option value="<?=$child['id']; ?>"><?=$child['category']; ?></option>
    <?php endwhile;?>
<?php echo ob_get_clean();?>

