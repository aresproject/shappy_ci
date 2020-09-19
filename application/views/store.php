<article>
    <div class="container">
        <div class="row">
            <a href="#">Pending Orders</a> | 
            <a href="#">Completed Orders</a> | 
            <a href="#">Cancelled/Refunded</a>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <table class="table">
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Line Price</th>
                <th>Actions</th>
            </tr>
            <?php foreach($orders as $order_data): ?>
            <tr>
                <td><?= $order_data['orderid']?></td>
                <td><?= $order_data['product_name']?></td>
                <td><?= $order_data['price']?></td>
                <td><?= $order_data['quantity']?></td>
                <td><?= $order_data['line_price']?></td>
                <td><button class="btn btn-success">Mark For Delivery</button></td>
            </tr>
             <?php endforeach; ?>    
            </table>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Ratings</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="datatable">
                </tbody>
            </table>
        </div>
    </div>
    
</article>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="product_update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Product Update</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="" method="post" id="update_form">
            <input type="hidden" id="modal_id">
            <div class="form-group">
                <label for="">Product Name</label>
                <input type="text" class="form-control" id="product_name">
            </div>
            <div class="form-group">
                <label for="">Description</label>
                <textarea name="product_description" id="product_description" cols="55" rows="10"></textarea>
            </div>
            <div class="form-group">
                <label for="">Price</label>
                <input type="number" class="form-control" id="product_price">
            </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script>

function fetchData(){
    $.post("<?php echo base_url("/store/store_products");?>",
        function(data){
            $('#datatable').html(data); 
        }
    );
}

$(document).ready(function() {  
    fetchData();
});

$(document).on('click', '.btn-delete', function(e){
    e.preventDefault();
    var $itemID = $(this).attr("data-id");
    $.post("<?php echo base_url("/store/delete_item");?>", {
        id: $itemID
    },
    function(data){
        fetchData();
    });
});

$(document).on('click', '.btn-edit', function(e){
    e.preventDefault();
    var $itemID = $(this).attr("data-id");
    $.post("<?php echo base_url("/store/fetch_product");?>", {
        id: $itemID
    },
    function(data){
        $('#product_update').modal('show');
        $("#product_name").val(data.post.product_name);
        $("#product_description").val(data.post.description);
        $("#product_price").val(data.post.price);
    });
});


</script>
    
    

