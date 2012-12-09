<div class="container">    
    <div class="row-fluid">
        <div class="span6">
            <div class="page-header register-header">
                <h3>Login Account</h3>
            </div>
            {login_error}
            <form action="{base_url}login" method="post" accept-charset="utf-8" class="form-horizontal">
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
        </div>
    </div>
</div>