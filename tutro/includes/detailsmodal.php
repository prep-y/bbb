<?php
require_once '../core/init.php';
$id = $_POST['id'];
$id = (int)$id;
$sql="SELECT * FROM products WHERE id = '$id'";
$result = $mysqli->query($sql);
$product=mysqli_fetch_assoc($result);
$brand_id=$product['brand'];
$sql="SELECT brand FROM brand WHERE id='$brand_id'";
$brand_query = $mysqli->query($sql);
$brand = mysqli_fetch_assoc($brand_query);
$sizeString = $product['sizes'];
$sizeString = rtrim($sizeString,',');
$size_array = explode(',', $sizeString);




?>





<!--Details modal-->
<div class="modal fade details-1" id="details-1" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title text-center">Levis Jeans</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <img src="images/products/men4.png" alt="Levis Jeans" class="details img-responsive">
                            </div>


                        </div>
                        <div class="col-sm-6">
                            <h4>Details</h4>
                            <p>Get yourself a pair while in stock!</p>
                            <hr>
                            <p>Price: $<?=$product['price']; ?></p>
                            <p>Brand: <?=$product['brand']; ?></p>
                            <form action="add_cart.php" method="post">
                                <div class="form-group">
                                    <div class="col-xs-3">
                                        <label for="quantity">Quantity:</label>
                                        <input type="text" class="form-control" id="quantity" name="quantity">
                                    </div>
                                    <p>Available: 3</p>
                                </div><br>
                                <div class="form-group">
                                    <label for="size">Size:</label>
                                    <select name="size" id="size" class="form-control">
                                        <option value=""></option>
                                        <option value="28">28</option>
                                        <option value="32">32</option>
                                        <option value="36">36</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dimiss="modal">Close</button>
                <button class="btn btn-warning" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span>Add to cart</button>
            </div>
        </div>
    </div>
</div>