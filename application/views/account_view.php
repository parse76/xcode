		<ul class="breadcrumb">
  			<li><a href="home">Home</a><span class="divider">/</span></li>
  			<li class="active">Account</li>
		</ul>

		<div class="row-fluid">
			<div class="span6">
				<form action="<?php echo base_url(); ?>account/login" method="post" accept-charset="utf-8" class="form-horizontal">
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
                            <label class="checkbox">
                                <input type="checkbox"> Remember me
                            </label>
                            <button type="submit" name="submit" class="btn">Sign in</button>
                        </div>
                    </div>
                </form>
                <?php echo validation_errors(); ?>
			</div>
			<div class="span6">
                <?php echo validation_errors(); ?>
                <?php echo form_open('account/login'); ?>
                <?php echo form_input('email'); ?>
                <?php echo form_password('password'); ?>
                <?php echo form_submit('submit', 'Submit'); ?>
                <?php echo form_close(); ?>
            </div>
		</div>
		