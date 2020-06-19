<div class="container">
    <div class="row">
        <div class="col-md-8">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Item Description</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Cost</th>
                </tr>
            </thead>
            <tbody>
            <?php $line = 0; $cost_price = 0;?>
           
            <?php foreach($cart_items as $item): ?>
                <tr>
                    <td><?= $line += 1 ?></td>
                    <td><img class="cart-img" src="<?= base_url()?>/assets/images/stores/products/placeholders.png" alt="photo"><?= $item['product_name'] ?></td>
                    <td><?= $item['item_price'] ?></td>
                    <td><input type="number" name="line_qty" value="<?= $item['quantity'] ?>"></td>
                    <td class="num"><?= $item['line_price'] ?></td>
                </tr>
                <?php 
                    $cost_price += $item['line_price'];
                ?>
            <?php endforeach; ?>
            
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><b>Total cost</b></td>
                <td class="num"><b><?= $cost_price ?></b></td>
            </tr>
            <tr>
                <td colspan="5">
                <form class="form" action="/products/update" method="post">
                    <input type="hidden" name="update_cart">
                    <button class="btn btn-success" style="float: right;" type="submit" disabled>Update Cart</button>
                </form>
                </td>
            </tr>
            <tr>
                <td colspan="5">
               
                <form class="form" action="/products/checkout" method="post">
                    <input type="hidden" name="checkout">
                    <button class="btn btn-success" style="float: right;" type="submit">Proceed To Checkout</button>
                </form>
                </td>
            </tr>
            </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <h4>Location:</h4>
            <p>Lorem ipsum dolor sit amet</p>
            <hr>
        </div>
    </div>
</div>






 
