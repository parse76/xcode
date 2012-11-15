		<ul class="breadcrumb">
  			<li><a href="home">Home</a><span class="divider">/</span></li>
  			<li class="active">Account</li>
		</ul>

		<div class="row-fluid">
			<div class="span6">
				<form action="{base_url}validate/login" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="inputEmail">Email</label>
                        <div class="controls">
                            <input type="text" name="email" id="inputEmail" placeholder="Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword">Password</label>
                        <div class="controls">
                            <input type="password" name="password" id="inputPassword" placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" name="submit" class="btn">Sign in</button>
                        </div>
                    </div>
                </form>
                <?php echo validation_errors(); ?>
			</div>
			<div class="span6">
                <a href="{base_url}register">Register Here!</a>
                <?php echo form_open('subok'); ?>
                <?php echo form_submit('name', 'value'); ?>
                <?php echo form_close(); ?>
                <?php echo anchor('validate/test', 'linkname'); ?>
            </div>
		</div>

        <?php echo anchor('account/facebook_login', 'fb'); ?>
		