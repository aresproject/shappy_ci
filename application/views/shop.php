
<div class="container">
    <nav>
        <?= $nav; ?></div>    
    </nav>
    <div class="row">
        <?php foreach($products as $items): ?>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="product_item">
                    <img src="<?= base_url()?>/assets/images/stores/products/placeholders.png" alt="">
                    <h3 class="product_name"><?= $items['product_name'] ?></h3>
                    <p class="price">$<?= $items['price'] ?></p>
                    <p class="ratings"><?= $items['ratings'] ?></p>
                    <a class="btn btn-primary" href="#" role="button">Add to cart</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
