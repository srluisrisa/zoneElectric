<?php 
session_start();
$connect = mysqli_connect("localhost", "root", "", "pagar");

if(isset($_POST["add_to_cart"]))
{
  if(isset($_SESSION["shopping_cart"]))
  {
    $item_array_id = array_column($_SESSION["shopping_cart"], "item_id");
    if(!in_array($_GET["id"], $item_array_id))
    {
      $count = count($_SESSION["shopping_cart"]);
      $item_array = array(
        'item_id'     =>  $_GET["id"],
        'item_name'     =>  $_POST["hidden_name"],
        'item_price'    =>  $_POST["hidden_price"],
        'item_quantity'   =>  $_POST["quantity"]
      );
      $_SESSION["shopping_cart"][$count] = $item_array;
    }
    else
    {
      echo '<script>alert("Ya agregaste este producto una vez.")</script>';
    }
  }
  else
  {
    $item_array = array(
      'item_id'     =>  $_GET["id"],
      'item_name'     =>  $_POST["hidden_name"],
      'item_price'    =>  $_POST["hidden_price"],
      'item_quantity'   =>  $_POST["quantity"]
    );
    $_SESSION["shopping_cart"][0] = $item_array;
  }
}

if(isset($_GET["action"]))
{
  if($_GET["action"] == "delete")
  {
    foreach($_SESSION["shopping_cart"] as $keys => $values)
    {
      if($values["item_id"] == $_GET["id"])
      {
        unset($_SESSION["shopping_cart"][$keys]);
        echo '<script>alert("Producto quitado con exito!")</script>';
        echo '<script>window.location="carrito.php"</script>';
      }
    }
  }
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Zona Electrica - Carrito </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mukta:300,400,700"> 
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/jquery-ui.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="css/owl.theme.default.min.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="css/aos.css">

    <link rel="stylesheet" href="css/style.css">
    
  </head>
  <body>
  
  <div class="site-wrap">
    <header class="site-navbar" role="banner">
      <div class="site-navbar-top">
        <div class="container">
          <div class="row align-items-center">

            <div class="col-6 col-md-4 order-2 order-md-1 site-search-icon text-left">
              <form action="" class="site-block-top-search">
                <span class="icon icon-search2"></span>
                <input type="text" class="form-control border-0" placeholder="Search">
              </form>
            </div>

            <div class="col-12 mb-3 mb-md-0 col-md-4 order-1 order-md-2 text-center">
              <div class="site-logo">
                <a href="index2.php" class="js-logo-clone">Zona Electrica</a>
              </div>
            </div>

            <div class="col-6 col-md-4 order-3 order-md-3 text-right">
              <div class="site-top-icons">
                <ul>
                  <li><a href="login.php"><span class="icon icon-person"></span></a></li>
                  <li>
                    <a href="carrito.php" class="site-cart">
                      <span class="icon icon-shopping_cart"></span>
                    </a>
                  </li> 
                  <li class="d-inline-block d-md-none ml-md-0"><a href="#" class="site-menu-toggle js-menu-toggle"><span class="icon-menu"></span></a></li>
                </ul>
              </div> 
            </div>

          </div>
        </div>
      </div> 
      <nav class="site-navigation text-right text-md-center" role="navigation">
        <div class="container">
          <ul class="site-menu js-clone-nav d-none d-md-block">
            <li><a href="index2.php">Televisores</a></li>
            <li><a href="somos.php">¿Quienes Somos?</a></li>
            <li><a href="login.php">Login</a></li>
            <li><a href="contact.php">Contacto</a></li>
          </ul>
        </div>
      </nav>
    </header>

    <br/>
    <div class="container">
      <br />
      <br />
      <br />
      <br /><br />
      <?php
        $query = "SELECT * FROM productos ORDER BY id ASC";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) > 0)
        {
          while($row = mysqli_fetch_array($result))
          {
        ?>
      <div class="col-md-4">
        <form method="post" action="carrito.php?action=add&id=<?php echo $row["id"]; ?>">
          <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
            <img src="images/<?php echo $row["imagen"]; ?>" class="img-responsive" /><br />

            <h4 class="text-info"><?php echo $row["producto"]; ?></h4>

            <h4 class="text-danger">$ <?php echo $row["precio"]; ?></h4>

            <input type="text" name="quantity" value="1" class="form-control" />

            <input type="hidden" name="hidden_name" value="<?php echo $row["producto"]; ?>" />

            <input type="hidden" name="hidden_price" value="<?php echo $row["precio"]; ?>" />

            <input type="submit" name="add_to_cart" style="margin-top:7px; background: #7971ea;" class="buy-now btn btn-sm btn-primary" value="Add to Cart" />

          </div>
        </form>
      </div>
      <?php
          }
        }
      ?>
      <div style="clear:both"></div>
      <br />
      <h3>Detalle de la compra</h3>
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th width="40%">Producto</th>
            <th width="10%">Cantidad</th>
            <th width="20%">Precio</th>
            <th width="15%">Total</th>
            <th width="5%">Accion</th>
          </tr>
          <?php
          if(!empty($_SESSION["shopping_cart"]))
          {
            $total = 0;
            foreach($_SESSION["shopping_cart"] as $keys => $values)
            {
          ?>
          <tr>
            <td><?php echo $values["item_name"]; ?></td>
            <td><?php echo $values["item_quantity"]; ?></td>
            <td>$ <?php echo $values["item_price"]; ?></td>
            <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
            <td><a href="carrito.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Quitar</span></a></td>
          </tr>
          <?php
              $total = $total + ($values["item_quantity"] * $values["item_price"]);
            }
          ?>
          <tr>
            <td colspan="3" align="right">Total</td>
            <td align="right">$ <?php echo number_format($total, 2); ?></td>
            <td></td>
          </tr>
          <br><p align="right"><a href="datos.php" style="margin-top:7px; background: #7971ea;" class="buy-now btn btn-sm btn-primary">Finalizar compra</a></p>
          <?php
          }
          ?>
            
        </table>
      </div>
    </div>
  </div>
  <br>
  </body>



    <footer class="site-footer border-top">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 mb-5 mb-lg-0">
            <div class="row">
              <div class="col-md-12">
                <h3 class="footer-heading mb-4">Zona Electrica</h3>
              </div>
              <div class="col-md-6 col-lg-4">
                <img src="images/logo.png">
              </div>
            </div>
          </div>
          <div class="col-md-6 col-lg-3 mb-4 mb-lg-0">
            <h3 class="footer-heading mb-4">Elaborado por:</h3>
            <a href="#" class="block-6">
              <p>Araujo Urias Marcos Abraham</p><p>Valdez Sanchez Luis Emmanuel</p>
            </a>
          </div>
          <div class="col-md-6 col-lg-3">
            <div class="block-5 mb-5">
              <h3 class="footer-heading mb-4">Correos:</h3>
              <ul class="list-unstyled">
                <li class="email">marcos.araujo@uabc.edu.mx</li>
                <li class="email">emmanuel.valdez@uabc.edu.mx</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div>

  <script src="js/jquery-3.3.1.min.js"></script>
  <script src="js/jquery-ui.js"></script>
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/owl.carousel.min.js"></script>
  <script src="js/jquery.magnific-popup.min.js"></script>
  <script src="js/aos.js"></script>

  <script src="js/main.js"></script>
    
  </body>
</html>