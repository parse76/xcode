        <div class="row-fluid">
            <div class="span6 register-adds">
                <div class="row-fluid register-add">
                    <div class="span6">
                        <img src="http://placehold.it/200x200" alt="">
                    </div>
                    <div class="span6 thumbnail-label">
                        <h3>Thumbnail label</h3>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </div>
                </div>
                <div class="row-fluid register-add">
                    <div class="span6 thumbnail-label">
                        <h3>Thumbnail label</h3>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </div>
                    <div class="span6">
                        <img src="http://placehold.it/200x200" alt="">
                    </div>
                </div>
                <div class="row-fluid register-add">
                    <div class="span6">
                        <img src="http://placehold.it/200x200" alt="">
                    </div>
                    <div class="span6 thumbnail-label">
                        <h3>Thumbnail label</h3>
                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
                    </div>
                </div>
            </div>
            <div class="span6 register-main">
                <div class="page-header register-header">
                    <h3>Creating new account
                        <br>
                        <small>Lorem ipsum</small>
                    </h3>
                </div>
                <form action="{base_url}validate/register" method="post" accept-charset="utf-8" class="form-horizontal">
                    <div class="control-group">
                        <label class="control-label" for="firstname">First Name:</label>
                        <div class="controls">
                            <input type="text" name="firstname" id="firstname" placeholder="First Name" value="{firstname}">
                            <label>{firstname_error}</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="lastname">Last Name:</label>
                        <div class="controls">
                            <input type="text" name="lastname" id="lastname" placeholder="Last Name" value="{lastname}">
                            <label>{lastname_error}</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="email">Email:</label>
                        <div class="controls">
                            <input type="text" name="email" id="email" placeholder="Email" value="{email}">
                            <label>{email_error}</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="username">Username:</label>
                        <div class="controls">
                            <input type="text" name="username" id="username" placeholder="Username" value="{username}">
                            <label>{username_error}</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password">Password:</label>
                        <div class="controls">
                            <input type="password" name="password" id="password" placeholder="Password">
                            <label>{password_error}</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="password2">Re-type Password:</label>
                        <div class="controls">
                            <input type="password" name="password2" id="password2" placeholder="Password">
                            <label>{password2_error}</label>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Birth Date:</label>
                        <div class="controls">
                            <select name="month" id="month" style="width:110px;">
                                <option value="0">Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                            <input type="text" name="day" id="day" placeholder="Date" style="width:35px;">
                            <input type="text" name="year" id="year" placeholder="Year" style="width:35px;">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="gender">Gender:</label>
                        <div class="controls">
                            <select name="gender" id="gender">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="recaptcha">
                            {recaptcha}
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="license-agreement">
                            <span>
                                <p>By clicking the “Create My Account” button below, I certify that I have read and agree to the
                                    <a href="#">License Agreement</a>.
                                </p>
                            </span>
                        </div>
                        <div class="controls">
                            <button type="submit" class="btn btn-large btn-primary">Create My Account</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>