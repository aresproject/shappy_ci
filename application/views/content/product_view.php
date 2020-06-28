<div class="article">
<div class="container">
    <?php
        if(isset($_SESSION['notice'])) {
            echo "<div class='alert alert-warning' role='alert'>";
            echo $_SESSION['notice'];
            echo "</div>";
        }
    ?>
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
            <?php echo form_open('/products/cart_add'); ?>
                <div class="form-row">
                    <div class="col-md-4">
                        <?php 
                            $_SESSION['current_product_id'] = $item['id'];
                            $_SESSION['current_product_price'] = $item['price'];
                        ?>
                        <div class="form-group">
                            <label for="qty">Quantity: </label>
                            <select class="form-control" name="qty">
                                <option>1</option>
                                <option>2</option>
                                <option>3</option>
                                <option>4</option>
                                <option>5</option>
                            </select>
                            <button class="btn btn-success" type="submit">Add to Cart</button>
                        </div>
                    </div>
                </div>    
            </form>
        </div>
        <?php endforeach; ?>
    </div>
        
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <h3>Related Products</h3>
            <?php foreach($related_products as $prod): ?>
                <div class="row">
                    <div class="col-md-12">
                        <img class="p150" src="<?= base_url()?>/assets/images/stores/products/placeholders.png" alt="photo">
                        <h4><?= $prod['product_name'] ?></h4>
                        <p><?= $prod['ratings'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="col-md-8 col-sm-12">
            <h2>Customer Reviews</h2>
            
            <a href="#" class="alignright" data-toggle="modal" data-target="#modal-review">Leave a review</a>
            <?php foreach($reviews as $review): ?>
                <div class="row">
                    <div class="col-md-2">
                        <img class="user-photo" src="<?= base_url()?>/assets/images/users/user-placeholder.png" alt="">
                    </div>
                    <div class="col-md-10">
                        <span><?= $review['rating'] ?></span>
                        <h3><?= $review['review_title']?></h3>
                        <p><?= $review['review_description'] ?></p>
                        <p style="text-align: right;"><b>-<?= $review['name'] ?></b></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- USER REVIEW -->
        <div class="modal fade" id="modal-review" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title aligncenter" id="myModalLabel">Review This Product</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="">
            <div class="modal-body">
               
                    <label for="rating">How Would You Rate This Product?</label>
                    <div class="form-group">
                        <input type="number" name="rating" placeholder="">
                    </div>

                    <label for="">Review Title</label>
                    <div class="form-group">
                        <input type="text" name="review_title" placeholder="What can you say about this?">
                    </div>

                    <label for="">How would you describe this product?</label>
                    <div class="form-group">
                        <textarea name="review" id="" cols="90" rows="5" ></textarea>
                    </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </form>
            </div>
        </div>
        </div>
    </div>
</div>
</div>