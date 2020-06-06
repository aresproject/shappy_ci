<div class="article">
<div class="container">
        <div class="row">
            <?php foreach($product as $item): ?>
            <div class="col-sm-12 col-md-4">
                <img src="<?= base_url()?>/assets/images/stores/products/placeholders.png" alt="photo">
            </div>
            <div class="col-sm-12 col-md-8">
                
                <h1><?= $item['product_name']?></h1>
                <h4>$<?= $item['price']?></h4>
                <span><?= $item['ratings'] ?></span>
                <p><?= $item['description']?></p>
                <p>qty</p>
                <p><a class="btn btn-success" href="#">Add To Cart</a></p>
                
            </div>
            <?php endforeach; ?>
        </div>
        
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <h3>Related Products</h3>
            </div>
            <div class="col-md-8 col-sm-12">
                <h2>Customer Reviews</h2>
                <?php foreach($reviews as $review): ?>
                    <div class="row">
                        <div class="col-md-2">
                            <img class="user-photo" src="<?= base_url()?>/assets/images/users/user-placeholder.png" alt="">
                        </div>
                        <div class="col-md-10">
                            <span><?= $review['rating'] ?></span>
                            <h3><?= $review['review_title']?></h3>
                            <p><?= $review['review_description'] ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>