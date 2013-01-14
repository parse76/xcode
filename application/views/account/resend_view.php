<form action="{base_url}resend" method="post" accept-charset="utf-8" class="form-horizontal">
	<div class="control-group">
        <label class="control-label" for="email">Email:</label>
        <div class="controls">
            <input type="text" name="email" id="email" placeholder="Email" value="{email}">
            <label>{email_error}</label>
        </div>
    </div>
    <div class="control-group">
        <div class="controls">
            <button type="submit" class="btn btn-small btn-primary">Resend Verification</button>
        </div>
    </div>
</form>