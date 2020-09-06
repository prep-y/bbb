<?php 
 require_once('core/init.php');

 include 'includes/head.php';

 include 'includes/navigation.php';

 include 'includes/headerfull.php';  

 include 'includes/leftbar.php';

 include 'includes/detailsmodal.php';


 $sql = "SELECT * FROM products WHERE featured = 1";
 $featured = $mysqli->query($sql);


 ?>

<!--main content-->
    <div class="col-md-12">
        <div class="row">
            <h2 class="text-center m-auto">Feature Products</h2>
            <?php while($product = mysqli_fetch_assoc($featured)) : ?>
                <div class="col-md-2">
                    <h4><?= $product['title']; ?></h4>
                    <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="img-thumb"/>
                    <p class="list-price text-danger">List Price <s><?= $product['list_price']; ?></s></p>
                    <p class="price">Our Price: $<?= $product['price']; ?></p>
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#details-1">Details</button>
                </div>
            <?php endwhile; ?>
        </div>
    </div>



<footer class="text-center" id="footer">&copy; Copyright 2020 Gift Box Direct</footer> 




<script>
jQuery(window).scroll(function(){
    var vscroll = jQuery(this).scrollTop();
   jQuery('#logoText').css({
       "transform" : "translate(0px, "+vscroll/2+"px)"
   })

   var vscroll = jQuery(this).scrollTop();
   jQuery('#back-flower').css({
       "transform" : "translate("+vscroll/5+"px, -"+vscroll/12+"px)"
   })

   var vscroll = jQuery(this).scrollTop();
   jQuery('#for-flower').css({
       "transform" : "translate(0px, -"+vscroll/2+"px)"
   })
});


function detailsModal(id){
      var data = {"id" : id};
      jQuery.ajax({
          url : +'/tutro/includes/detailsmodal.php',
          method : "post",
          data : data,
          success : function(data){
              jQuery('body').append(data);
              jQuery('#details-modal').modal('toggle');
          },
          error : function(){
              alert("Something went wrong!");
          }
      });
  }
</script>
</body>
</html>
 
      




