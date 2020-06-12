<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3>Personal Data</h3>
            <form>
                <div class="form-group row">
                    <label for="fname" class="col-sm-3 col-form-label">First Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="fname" name="fname" value="<?= $user_data['first_name'] ?>">
                    </div>
                    <label for="fname" class="col-sm-3 col-form-label">Last Name</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="lname" name="lname" value="<?= $user_data['last_name'] ?>">
                    </div>
                    
                    <label for="phone" class="col-sm-3 col-form-label">Phone</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="phone" name="phone" value="<?= $user_data['phone_number'] ?>">
                    </div>
                    <label for="phone" class="col-sm-3 col-form-label">Email</label>
                    <div class="col-md-9">
                        <input type="text" class="form-control" id="email" name="email" value="<?= $user_data['email'] ?>">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <img class="user-photo" src="<?= base_url()?>/assets/images/users/user-placeholder.png" alt="">
        </div>
    </div>
    <div class="row">
        <h3>Address</h3>
        <div class="col-md-12">
        <p>
            <?php
                echo $address_data['address_street'] . "<br>";
                echo $address_data['city_name'] . "<br>";
                echo $address_data['state_name'] . ", " . $address_data['country_name'] . "<br>";
                echo $address_data['address_zip'];
            ?>
        </p>
        </div>
    </div>
</div>