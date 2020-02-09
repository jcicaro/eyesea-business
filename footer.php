    
    <div class="row p-4">
        <div class="col-md-12">
            <footer class="footer text-center">
                <small>
                    <span>Eye Sea Studio © 2020</span>
                    
                    <?php if(!is_user_logged_in()) { ?>
                    <span><a class="nav-link" href="<?php echo wp_login_url(home_url()); ?>">Login</a></span>
                    <?php } ?>
                    
                </small>
            </footer>
        </div>
    </div>

    </div> <!-- container -->

    <?php 
    wp_footer(); 
    ?>
</body>
</html>