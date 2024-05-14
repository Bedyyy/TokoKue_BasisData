<?php
session_start();
require 'connect.php';
require 'item.php';

if (isset($_GET['id']) && !isset($_POST['update'])) {

    $result = mysqli_query($con, "SELECT * FROM product WHERE id = '$_GET[id]'");
    $product = mysqli_fetch_object($result);
    $item = new Item();
    $item->id = $product->id;
    $item->name = $product->name;
    $item->price = $product->price;
    $item->quantity = 1;
    $item->gambar = $product->gambar;
    // Check product is existing in cart
    $index = -1;
    if (isset($_SESSION['cart'])) {
        $cart = unserialize(serialize($_SESSION['cart']));
        for ($i = 0; $i < count($cart); $i++)
            if ($cart[$i]->id == $_GET['id']) {
                $index = $i;
                break;
            }
    }
    if ($index == -1)
        $_SESSION['cart'][] = $item;
    else {
        $cart[$index]->quantity++;
        $_SESSION['cart'] = $cart;
    }

    if (isset($_POST['bayar'])) {
        session_unset();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <title>UAS BASIS DATA</title>
</head>

<body>
<div class="container mt-3">
      <h1>Payment</h1>
    </div>

    <?php
    $cart = unserialize(serialize($_SESSION['cart']));
    $s = 0;
    $index = 0;
    for ($i = 0; $i < count($cart); $i++) {
        $s += $cart[$i]->price * $cart[$i]->quantity;
        ?>
        <div class="container bg-primary rounded-3 p-3">
      <div class="container">
        <div class="cart-item">
          <div class="cart-item-details" style="color: white">
            <h3><?php echo $cart[$i]->name; ?></h3>
            <p><?php echo $cart[$i]->price; ?></p>
        </div>
    </div>
    <?php
        $index++;
    }
    ?>
    <p>Total : <?php echo $s; ?></p>
    <h2 style="color: white">Payment Method</h2>
    <div class="form-check mt-3">
      <input
        class="form-check-input"
        type="radio"
        name="flexRadioDefault"
        id="flexRadioDefault1"
      />
      <label
        class="form-check-label"
        for="flexRadioDefault1"
        style="color: white"
      >
        Mandiri Virtual Account
      </label>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="flexRadioDefault"
        id="flexRadioDefault1"
      />
      <label
        class="form-check-label"
        for="flexRadioDefault1"
        style="color: white"
      >
        Ovo
      </label>
    </div>
    <div class="form-check">
      <input
        class="form-check-input"
        type="radio"
        name="flexRadioDefault"
        id="flexRadioDefault1"
      />
      <label
        class="form-check-label"
        for="flexRadioDefault1"
        style="color: white"
      >
        Gopay
      </label>
    </div>
    <br />
    <div class="d-flex flex-row gap-4">
      <button type="button" class="btn btn-light">
        <a
          href="checkout.html"
          style="text-decoration: none; color: rgb(56, 59, 245)"
          >Back</a
        >
      </button>
      <button type="button" class="btn btn-light">
        <a href="index.php" style="text-decoration: none; color: rgb(56, 59, 245)">Bayar</a>
      </button>
    </div>
  </div>
</div>
</body>

</html>