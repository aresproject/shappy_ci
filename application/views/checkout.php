<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>Order Summary</h1>
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Product Name</th>
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
                        <td><?= $item['product_name'] ?></td>
                        <td><?= $item['item_price'] ?></td>
                        <td><?= $item['quantity'] ?></td>
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
                
                </tbody>
                </table>
            </div>
            <div class="col-md-4">
                <h4>Shipping & Billing Details</h4>
                <hr>
                <p>
                    For: <?= $user_data['first_name'] . " " . $user_data['last_name'] ?> <br>
                    Contact #: <?= $user_data['phone_number'] ?>
                </p>
                
                <address>
                    <span>Address</span> <br>
                    <?= $address_data['address_street'] ?> <br>
                    <?= $address_data['state_name'] .", " . $address_data['country_name']  ?> <br>
                    <?=  $address_data['address_zip'] ?>
                </address>
                
                <hr>
            </div>
    </div>
</div>


<!-- Payment Module -->
<div class="container">
  <div class="row">
    <div class="col-md-8">
        <h4>Select Method Of Payment...</h4>
        <div id="accordion">
        <div class="card">
            <div class="card-header" id="pay-credit-card">
                <h5 class="mb-0">
                    <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Pay via Credit Card
                    </button>
                </h5>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="pay-credit-card" data-parent="#accordion">
                <div class="card-body">
                    <form action="/products/checkout">
                        <input type="text" placeholder="Credit Card #">
                        <input type="text" placeholder="Exp">
                        <input type="number" placeholder="cvc">
                        <input type="hidden" name="checkout" value="credit">
                        <button class="btn btn-primary" type="submit">Place Order</button>
                     </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="pay-debit-card">
            <h5 class="mb-0">
                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                Pay via Debit Card
                </button>
            </h5>
            </div>
            <div id="collapseTwo" class="collapse" aria-labelledby="pay-debit-card" data-parent="#accordion">
            <div class="card-body">
                    <form action="/products/checkout">
                        <input type="text" placeholder="Debit Card #">
                        <input type="text" placeholder="Exp">
                        <input type="number" placeholder="cvc">
                        <input type="hidden" name="checkout" value="debit">
                        <button class="btn btn-primary" type="submit">Place Order</button>
                     </form>
            </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="pay-bank">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapseTwo">
                    Pay via Bank Transfer
                    </button>
                </h5>
            </div>
            <div id="collapse3" class="collapse" aria-labelledby="pay-bank" data-parent="#accordion">
                <div class="card-body">
                    Please pay to : 
                    <h5>Maze Bank</h5>
                    Bank Code: 12345 <br>
                    Account Number: SA098790790
                    <p>
                        Upon payment please send a screencapture of your bank deposit copy to mazebank@example.com <br>
                        Thank You!
                    </p>
                    <form action="/products/checkout">
                        <input type="hidden" name="checkout" value="bank">
                        <button class="btn btn-primary" type="submit">Place Order</button>
                     </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="pay-cod">
                <h5 class="mb-0">
                    <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapseTwo">
                    Pay via COD
                    </button>
                </h5>
            </div>
            <div id="collapse4" class="collapse" aria-labelledby="pay-cod" data-parent="#accordion">
                <div class="card-body">
                    <h5>Cash On Delivery</h5>
                    <p>Pay at your doorstep when the product/s arrive</p>
                    <form action="/products/checkout">
                        <input type="hidden" name="checkout" value=="cod">
                        <button class="btn btn-primary" type="submit">Place Order</button>
                     </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="col-md-4">
     
    </div>
  </div> <!-- END OF Accordion -->
</div>



