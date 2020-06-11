<div class="container">
    <div class="row">
        <div class="col-md-8">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Product Name</th>
                <th scope="col">Price</th>
                <th scope="col">Qty</th>
                <th scope="col">Price</th>
                </tr>
            </thead>
            <tbody>
            <?php $line = 0; $cost_price = 0;?>
            <?php foreach($cart_items as $item): ?>
                <tr>
                    <td><?= $line += 1 ?></td>
                    <td><?= $item['product_name'] ?></td>
                    <td><?= $item['item_price'] ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td><?= $item['line_price'] ?></td>
                </tr>
                <?php 
                    $cost_price += $item['line_price'];
                ?>
            <?php endforeach; ?>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>Total cost</td>
                <td><?= $cost_price ?></td>
            </tr>
            <tr>
                <td colspan="5">
                <div class="form">
                    <input type="hidden" name="checkout">
                    <button class="btn btn-success" style="float: right;" type="submit">Proceed To Checkout</button>
                </div>
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






 
