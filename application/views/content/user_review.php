<article>
    
<?php echo form_open('main/sign_up'); ?>
        <div class="row">
            <div class="col">
                <input type="number" class="form-control" name="rating" >
                <small><?php echo form_error('rating'); ?></small>
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
</article>