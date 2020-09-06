<?php 
require_once $_SERVER['DOCUMENT_ROOT'].'/tutro/core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

if(isset($_GET['add'])){
$brandQuery = $mysqli->query("SELECT * FROM brand ORDER BY brand");
$parentQuery = $mysqli->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
if($_POST){
    $title = sanitize($_POST['title']);
    $brand = sanitize($_POST['brand']);
    $categories = sanitize($_POST['child']);
    $price = sanitize($_POST['price']);
    $list_price = sanitize($_POST['list_price']);
    $sizes = sanitize($_POST['sizes']);
    $description = sanitize($_POST['description']);
    $dbPath = '';
    $erros = array();
    if(!empty($_POST['sizes'])){
        $sizeString = sanitize($_POST['sizes']);
        $sizeString = rtrim($sizeString,',');
        $sizesArray = explode(',',$sizeString);
        $sArray = array();
        $qArray = array();
        foreach($sizesArray as $ss){
            $s = explode(':', $ss);
            $sArray[] = $s[0];
            $qArray[] = $s[1];
        }
    }else($sizesArray = array());
    $required = array('title', 'brand', 'price', 'parent', 'child', 'sizes');
    foreach($required as $feild){
        if($_POST[$feild] == ''){
            $errors[] = 'All fields with an Astrisk are required';
        break;
        }
    }



    //Image validation
    if(!empty($_FILES)){
        var_dump($_FILES);
        $photo = $_FILES['photo'];
        $name = $photo['name'];
        $nameArray = explode('.', $name);
        $filename = $nameArray[0];
       $fileExt = $nameArray[1];
       $mime = explode('/',$photo['type']);
       $mimeType = $mime[0]; 
       $mimeExt = $mime[1];
       $tmpLoc = $photo['tmp_name'];
       $fileSize = $photo['size'];
       $allowed = array('png','jpg', 'jpeg', 'gif');
       $uploadName = md5(microtime()).'.'.$fileExt;
       $uploadPath = BASEURL.'images/products/'.$uploadName;
       $dbPath = '/tutro/images/products/'.$uploadName;

       if($mimeType != 'image'){
           $errors[] = 'The file must be an image';
       }
    }
    if(!in_array($fileExt, $allowed)){
        $errors[] = 'The photo extension must be a png, jpeg, or gif.';
    }

    if($fileSize > 15000000){
        $errors[] = 'The files size must be under 15MB';
    }

    if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
        $errors[] = 'File extension does not match the file';
    }

    if(!empty($errors)){
        echo display_errors($errors);
    }else{
        //Upload file and insert into database
        move_uploaded_file($tmpLoc,$uploadPath);

        //Insert into database
        $insertSql = "INSERT INTO products ('title', 'price', 'list_price', 'brand', 'categories', 'sizes', 'image', 'description') 
        VALUES ('$title', '$price', '$list_price', '$brand', '$categories', '$sizes', '$dbPath', '$description' )";
        $mysqli->query($insertSql);
        header('Location: products.php');

    }
}
?>

<h2 class="text-center">Add a new product</h2><hr>
<div class="container">
    
    <form action="products.php?add=1" method="POST" enctype="multipart/form-data">
    
    <!--title category -->
    <div class="form-group col-md-12">
        <label for="title">Title*:</label>
        <input type="text" name="title" class="form-control" id="title" value="<?=((isset($_POST['title']))?sanitize($_POST['title']):'');?>">
    </div>
   
    
    <!--Brand category -->
    <div class="form-group col-md-12">
        <label for="brand">Brand*:</label>
        <select class="form-control" id="brand" name="brand">
        <option value=""<?=((isset($_POST['brand']) && $_POST['brand'] == '')?' selected':''); ?>></option>
        <?php while($brand = mysqli_fetch_assoc($brandQuery)): ?>
            <option value="<?=$brand['id'];?>"<?=((isset($_POST['brand']) && $_POST['brand'] == $brand['id'])?' selected':'');?>><?=$brand['brand'];?></option>
        <?php endwhile;?>
        </select>
    </div>
   
    <!-- Parent category -->
    <div class="form-group col-md-12">
        <label for="parent">Parent Category*:</label>
        <select class="form-control" id="parent" name="parent">
            <option value=""<?=((isset($_POST['parent']) && $_POST['parent'] == '')?' selected':''); ?>></option>
            <?php while($parent = mysqli_fetch_assoc($parentQuery)): ?>
                <option value="<?=$parent['id'];?>"<?=((isset($_POST['parent']) && $_POST['parent'] == $parent['id'])?' selected':'');?>><?=$parent['category']; ?></option>
            <?php endwhile;?>
        </select>
    </div>
    
    <!-- Child category -->            
    <div class="form-group col-md-12">
        <label for="child">Child category*:</label>
            <select id="child" name="child" class="form-control"></select>
    </div>
            
    <!--Price category-->      
    <div class="form-group col-md-12">
        <label for="price">Price*:</label>
        <input type="text" id ="price" name="price" class="form-control" value="<?=((isset($_POST['price']))?sanitize($_POST['price']):'');?>">
    </div>

    <!--List price category-->
    <div class="form-group col-md-12">
        <label for="list_price">List Price*:</label>
        <input type="text" id ="list_price" name="list_price" class="form-control" value="<?=((isset($_POST['list_price']))?sanitize($_POST['list_price']):'');?>">
    </div>

    <!--Quantity and sizes category-->
    <div class="form-group col-md-12">
        <label>Quanitity && Sizes:*</label>
        <button class="btn btn-success form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quanitity && Sizes</button>
    </div>
    
    <!--Sizes and quantity preview-->
    <div class="form-group col-md-12">
        <label for="sizes">Sizes & Quanitity Preview</label>
        <input type="text" class="form-control" name="sizes" id="sizes" value="<?=((isset($_POST['sizes']))?$_POST['sizes']:''); ?>" readonly>             
    </div>
    
    <!--Product photo-->
    <div class="form-group col-md-12">
        <label for="photo">Product photo:</label>
        <input type="file" name="photo" id="photo" class='form-control'>
    </div>
    
    <!--Description-->
    <div class="form-group col-md-12">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control" rows="6"><?=((isset($_POST['description']))?sanitize($_POST['description']):'');?></textarea>
    </div>

    <input type="submit" value="Add Product" class="form-control btn btn-success pull-right">
    </form>



    <!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Sizes and quantity</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
            <?php for($i = 1; $i <= 12; $i++): ?>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="size<?=$i;?>">Size</label>
                        <input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'') ?>" class="form-control">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group col-md-12">
                        <label for="qty<?=$i;?>">Quantity</label>
                        <input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'') ?>" min="0" class="form-control">
                    </div>
                </div>
            </div>
            <?php endfor;?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<?php }else{

$sql = "SELECT * FROM products WHERE deleted = 0";
$pResults = $mysqli->query($sql);
if(isset($_GET['featured'])){
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featured_sql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
    $mysqli->query($featured_sql);
    header('Location: products.php');
}

?>
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success float-md-right" id="add-product-btn">Add Product</a><div class="clearfix"></div>
<hr>

<table class="table table-bordered table-condensed table-striped">
    <thead>
        <th></th><th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th>
    </thead>
    <tbody>
        <?php while($product = mysqli_fetch_assoc($pResults)):
            $childID = $product['categories'];
            $catSql = "SELECT * FROM categories WHERE id = '$childID'";
            $result = $mysqli->query($catSql);
            $child = mysqli_fetch_assoc($result);
            $parentID = $child['parent'];
            $pSql = "SELECT * FROM categories WHERE id = '$parentID'";
            $presult = $mysqli->query($pSql);
            $parent = mysqli_fetch_assoc($presult);
            $category = $parent['category'].'-'.$child['category'];

            ?>
            <tr>
                <td>
                    <a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default"><i class="large material-icons">create</i></a>
                    <a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default"><i class="large material-icons">clear</i></a>
                </td>
                <td><?=$product['title'];?></td>
                <td><?=money($product['price']);?></td>
                <td><?=$category;?></td>
                <td><a href="products.php?featured=<?=(($product['featured'] == 0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-xs btn-default"><i class="large material-icons"><?=(($product['featured'] == 1)?'clear':'create');?></i></a>&nbsp <?=(($product['featured'] == 1)?'Featured product':''); ?> </td>
                <td>0</td>
            </tr>
        <?php endwhile;?>
    </tbody>
</table>


        <?php } include 'includes/footer.php'; ?>