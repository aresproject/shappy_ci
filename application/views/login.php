<article>
    <div class="container">
        <div class="row">
            <div class="col-md-6">   
                <h2>Register</h2>
            </div>
            <div class="col-md-6">
                <h2>Login</h2>
                <?php 
                
                if(isset($_SESSION['notice'])) {
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
    

    