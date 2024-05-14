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
	$item->description = $product->description;
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
}

// Delete product in cart
if (isset($_GET['index']) && !isset($_POST['update'])) {
	$cart = unserialize(serialize($_SESSION['cart']));
	unset($cart[$_GET['index']]);
	$cart = array_values($cart);
	$_SESSION['cart'] = $cart;
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
	<link rel="stylesheet" href="style.css" />
	<title>UAS BASIS DATA</title>
</head>

<body>
	<div class="nav-atas">
		<nav class="navbar navbar-expand-lg mb-3" id="navbar">
			<div class="container-fluid">
				<span class="navbar-brand ms-5 mb-0 h1 text-white">Toko Hadiid</span>
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
					aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="collapse navbar-collapse justify-content-end me-5" id="navbarNav">
					<ul class="navbar-nav">
						<li class="nav-item">
							<a class="nav-link active text-white rounded" aria-current="page" href="index.html">Home</a>
						</li>
						<li class="nav-item">
							<a class="nav-link text-white rounded" href="cart.html">Cart</a>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	</div>

	<?php echo isset($error) ? $error : ''; ?>
	<form method="post">

		<div class="container text-white rounded-3 p-3" style="background-color:  rgb(56, 59, 245);">
		<?php
		$cart = unserialize(serialize($_SESSION['cart']));
		$s = 0;
		$index = 0;
		for ($i = 0; $i < count($cart); $i++) {
			$s += $cart[$i]->price * $cart[$i]->quantity;
			?>
				<div class="form-check">
					<div class="cart-item">
						<img src="images/<?php echo $cart[$i]->gambar; ?>" width="100" height="100" alt="Product name" />
						<div class="cart-item-details">
							<h3>
								<?php echo $cart[$i]->name; ?>
							</h3>
							<h6><?php echo $cart[$i]->description; ?></h6>
							<p>
								<?php echo $cart[$i]->price; ?>
							</p>
							<button type="button" class="btn btn-light" id="checkout"><a href="cart.php?index=<?php echo $index; ?>"
								onclick="return confirm('Are you sure?')" style="text-decoration: none;">Delete</a></button>
						</div>
					</div>
					</label>
				</div>
			</body>
			<?php
	$index++;
}
?>
<center>
	<button type="button" class="btn btn-light" id="checkout"><a href="index.php"
			style="text-decoration: none;">Continue Shopping</a></button>
	<button type="button" class="btn btn-light" id="checkout"><a href="checkout.php"
			style="text-decoration: none;">Checkout</a></button>
</center>
</div>
</form>

</html>