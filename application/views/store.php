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
            </tr>
            <?php foreach($orders as $order_data): ?>
            <tr>
                <td><?= $order_data['orderid']?></td>
                <td><?= $order_data['product_name']?></td>
                <td><?= $order_data['price']?></td>
                <td><?= $order_data['quantity']?></td>
                <td><?= $order_data['line_price']?></td>
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

<script>
$(document).ready(function() {
	$.ajax({
		url: "<?php echo base_url("/store/store_products");?>",
		type: "POST",
		cache: false,
		success: function(dataResult){
			$('#datatable').html(dataResult); 
		}
	});
	$(document).on("click", ".delete", function() { 
	//alert("Success");
		var $set = $(this).parent().parent();
		$.ajax({
			url: "<?php echo base_url("/store/delete_item");?>",
			type: "POST",
			cache: false,
			data:{
				type: 2,
				id: $(this).attr("data-id")
			},
			success: function(dataResult){
				alert(dataResult);
				var dataResult = JSON.parse(dataResult);
				if(dataResult.statusCode==200){
					$set.fadeOut().remove();
				}
			}
		});
	});
});
</script>
