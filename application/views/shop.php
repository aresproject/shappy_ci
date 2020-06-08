
<article class="container">
    <nav>
        <?= isset($pager) ? $pager : ""; ?>
        <?= isset($pager_x) ? $pager_x : ""; ?>
    </nav>
    <div class="row">
        <div class="col-md-2">
            <p><b>Filter by Categories</b></p>
            <ul>
            <?php foreach($filters as $category): ?>
                <li><?= $category['category_name'] ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
        <div class="col-md-10">
            <div class="row">
            <?php foreach($products as $items): ?>
                <div class="col-lg-3 col-md-3 col-sm-12">
                    <a href="/products/view/<?= $items['id']?>">
                    <div class="product_item">
                        <img src="<?= base_url()?>/assets/images/stores/products/placeholders.png" alt="">
                        <h3 class="product_name"><?= $items['product_name'] ?></h3>
                        <p class="price">$<?= $items['price'] ?></p>
                        <p class="ratings"><?= $items['ratings'] ?></p>
                    </div>
                    </a>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
    </div>
</article>
