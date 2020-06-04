
<div class="container">
    <nav aria-label="Page navigation example">
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="#">Previous</a></li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item"><a class="page-link" href="#">Next</a></li>
    </ul>
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
