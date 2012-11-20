        <ul class="breadcrumb">
            <li><a href="#">Home</a><span class="divider">/</span></li>
            <li class="active">Account</li>
        </ul>

        <div class="row-fluid">
            <div class="span6">
                <div class="page-header register-header">
                    <h3>Login Account</h3>
                </div>
                <form action="{base_url}validate/login" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="username">Username:</label>
                        <div class="controls">
                            <input type="text" name="username" id="username" placeholder="Username">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">Password:</label>
                        <div class="controls">
                            <input type="password" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox"> Remember me
                            </label>
                            <button type="submit" class="btn">Login</button>
                            <br><br>
                            <a href="#">Forgot your password?</a>                           
                        </div>
                    </div>
                </form>
                <?php echo validation_errors(); ?>
            </div>
            <div class="span6">
                <div class="row-fluid">
                    <div>
                        <h3>Use your third party accounts<br><small>Login using facebook, twitter or google+</small></h3>
                        <a href="{base_url}validate/facebook">
                            <img src="http://www.indent.net.au/wp-content/uploads/2009/04/facebook-icon50x50.png" class="social-networking">
                        </a>
                        <a href="{base_url}validate/twitter">
                            <img src="http://www.indent.net.au/wp-content/uploads/2009/04/twitter-icon50x50.png" class="social-networking">
                        </a>
                        <a href="{base_url}validate/google">
                            <img src="http://www.kerrydean.com/pictures/icons-social/google-plus-50x50.png" class="social-networking">
                        </a>
                    </div>
                </div>
                <br><hr>
                <div class="row-fluid">
                    <div>
                        <h3>Don't have any social accounts?<br><small>Click the link and register directly here!</small></h3>
                        <a href="{base_url}register" class="btn btn-large btn-primary">Click here to register!</a>
                    </div>
                </div>
            </div>
        </div>
