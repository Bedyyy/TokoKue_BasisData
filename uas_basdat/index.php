<?php
require_once('connect.php');
$result = mysqli_query($con, 'SELECT * FROM product');
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
                <span class="navbar-brand ms-5 mb-0 h1 text-white">Toko Kue</span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end me-5" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active text-white rounded" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white rounded" href="#">Cart</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="produk">
        <div class="container">
            <div class="row">
                <?php while ($product = mysqli_fetch_object($result)): ?>
                    <div class="col">
                        <div class="card">
                            <img src="images/<?= $product->gambar; ?>" height="250" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php echo $product->name; ?>
                                </h5>
                                <h6 class="card-text">Rp. <?php echo $product->price; ?></h6>
                                <p class="card-text">
                                    <?php echo $product->description; ?>
                                </p>
                                <a href="cart.php?id=<?php echo $product->id; ?>" class="btn btn-primary">Add To Cart</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

</body>

</html>