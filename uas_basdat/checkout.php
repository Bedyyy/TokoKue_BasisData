<?php
session_start();
require 'connect.php';
require 'item.php';

// Update quantity in cart
if (isset($_POST['update'])) {
	$arrQuantity = $_POST['quantity'];

	// Check validate quantity
	$valid = 1;
	for ($i = 0; $i < count($arrQuantity); $i++)
		if (!is_numeric($arrQuantity[$i]) || $arrQuantity[$i] < 1) {
			$valid = 0;
			break;
		}
	if ($valid == 1) {
		$cart = unserialize(serialize($_SESSION['cart']));
		for ($i = 0; $i < count($cart); $i++) {
			$cart[$i]->quantity = $arrQuantity[$i];
		}
		$_SESSION['cart'] = $cart;
	} else
		$error = 'Tidak Boleh 0';
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
	<div class="container fw-bold">
		<h1>Checkout</h1>
	</div>


	<?php echo isset($error) ? $error : ''; ?>
	<form method="post">
		<div class="container text-white rounded-3 p-3" style="background-color: rgb(56, 59, 245)">
			<?php
			$cart = unserialize(serialize($_SESSION['cart']));
			$s = 0;
			$index = 0;
			for ($i = 0; $i < count($cart); $i++) {
				$s += $cart[$i]->price * $cart[$i]->quantity;
				?>
				<div class="container">
					<div class="cart-item">
						<img src="images/<?php echo $cart[$i]->gambar; ?>" width="100" height="100" alt="Product name" />
						<div class="cart-item-details">
							<h3>
								<?php echo $cart[$i]->name; ?>
							</h3>
							<p><?php echo $cart[$i]->price; ?></p>
							<input type="text" value="<?php echo $cart[$i]->quantity; ?>" style="width: 50px;"
								name="quantity[]">
							</div>
						</div>
						
						
					</div>
					<?php
				$index++;
			}
			?>
			<input type="submit" name="update">
			<h3>Total Harga = <?php echo $s; ?></h3>
			<br />
			<div class="d-flex flex-row gap-3">
				<button type="button" class="btn btn-primary">
					<a href="cart.php" style="text-decoration: none; color: white">Back</a>
				</button>
				<button type="button" class="btn btn-primary">
					<a href="payment.php" style="text-decoration: none; color: white">Payment</a>
				</button>
			</div>
		</div>
	</form>
</body>

</html>