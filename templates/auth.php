<form id="niloy-auth-form" method="post" action="#" data-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">

    <div class="auth-btn">
    
        <input type="button" value="Login" id="niloy-show-auth-form" />

    </div>

    <div id="niloy-auth-container" class="auth-container">
    
        <a href="#" id="niloy-auth-close" class="close">&times;</a>

        <h2>Site Login</h2>

        <label for="username">User Name: </label>
        <input type="text" name="username" id="username">

        <label for="password">Password: </label>
        <input type="password" name="password" id="password">
        <input type="submit" value="Login" class="submit_button" name="submit">

        <p class="status" data-message="status"></p>

        <p class="actions">

            <a href="<?php echo wp_lostpassword_url(); ?>">Forget Password?</a> - <a href="<?php echo wp_registration_url(); ?>">Register</a>

        </p>

        <input type="hidden" name="action" value="niloy_login">

        <?php wp_nonce_field( 'ajax-login-nonce', 'niloy-auth' ); ?>
       

    </div>

</form>