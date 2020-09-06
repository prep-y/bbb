
<?php
$sql="SELECT * FROM categories WHERE parent = 0";
$pquery=$mysqli->query($sql);
?>




<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-fixed-top">
  <div class="container">
    <a href="index.php" class="navbar-brand">Gift Box Direct</a>
    <ul class="navbar-nav mr-auto">
      <?php while($parent=mysqli_fetch_assoc($pquery)) : ?>
        <?php 
          $parent_id=$parent['id'];
          $sql2="SELECT*FROM categories WHERE parent = '$parent_id'";
          $cquery=$mysqli->query($sql2);
        
        ?>
      <!--Menu items-->
      <li class="dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $parent['category']; ?> 
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <?php while($child=mysqli_fetch_assoc($cquery)) : ?>
          <a class="dropdown-item" href="#"><?php echo $child['category'];?></a>
          <?php endwhile; ?>
          
        </div>  
      </li>
      <?php endwhile; ?>
  </div>
</nav>