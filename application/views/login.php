<article>
    <div class="container">
        <div class="row">
            <div class="col-md-6">   
                <h2>Register</h2>
                <small>Sign up its quick and easy</small>
 
                <?php echo form_open('main/sign_up'); ?>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" name="fname" placeholder="First name">
                            <small><?php echo form_error('fname'); ?></small>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="lname" placeholder="Last name">
                            <small><?= form_error('lname') ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" name="email" placeholder="Email">
                            <small><?= form_error('email') ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control" name="phone" placeholder="Phone">
                            <small><?= form_error('phone') ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="password" class="form-control" name="password" placeholder="password">
                            <small><?= form_error('password') ?></small>
                        </div>
                        <div class="col">
                            <input type="password" class="form-control" name="cpassword" placeholder="confirm password">
                            <small><?= form_error('cpassword') ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <label for="date">Birthdate</label>
                            <input type="date" class="form-control" name="date" placeholder="">
                            <small><?= form_error('date') ?></small>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                        <button type="submit" class="btn btn-primary">Sign Up</button>  
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <h2>Login</h2>
                <small>Already have an account? </small>
                <?php 
                
                if(isset($_SESSION['login_notice'])) {
                    echo "<div class='alert alert-warning' role='alert'>";
                    echo $_SESSION['notice'];
                    echo "</div>";
                }
                
                ?>
                <?php echo form_open('/main/login'); ?>
                <div class="form-group">
                    <label for="login_email">Email address</label>
                    <input type="email" class="form-control" id="login_email" name="login_email" placeholder="Enter email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
                </div>
                <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</article>
    

    