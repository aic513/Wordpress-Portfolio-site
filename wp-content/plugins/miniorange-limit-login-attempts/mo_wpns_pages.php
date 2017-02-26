<?php

/*Main function*/
function mo_lla_show_settings() {
	if( isset( $_GET[ 'tab' ] ) ) {
		$active_tab = $_GET[ 'tab' ];
	} else {
		$active_tab = 'default';
	}
	
	?>
	<h2>miniOrange Limit Login Attempts</h2>
	<?php
		if(!Mo_LLA_Util::is_curl_installed()) {
			?>
			
			<div id="help_curl_warning_title" class="mo_wpns_title_panel">
				<p><a target="_blank" style="cursor: pointer;"><font color="#FF0000">Warning: PHP cURL extension is not installed or disabled. <span style="color:blue">Click here</span> for instructions to enable it.</font></a></p>
			</div>
			<div hidden="" id="help_curl_warning_desc" class="mo_wpns_help_desc">
					<ul>
						<li>Step 1:&nbsp;&nbsp;&nbsp;&nbsp;Open php.ini file located under php installation folder.</li>
						<li>Step 2:&nbsp;&nbsp;&nbsp;&nbsp;Search for <b>extension=php_curl.dll</b> </li>
						<li>Step 3:&nbsp;&nbsp;&nbsp;&nbsp;Uncomment it by removing the semi-colon(<b>;</b>) in front of it.</li>
						<li>Step 4:&nbsp;&nbsp;&nbsp;&nbsp;Restart the Apache Server.</li>
					</ul>
					For any further queries, please <a href="mailto:info@miniorange.com">contact us</a>.								
			</div>
					
			<?php
		}
		
		if(!Mo_LLA_Util::is_extension_installed('mcrypt')) {
			?>
			<p><font color="#FF0000">(Warning: <a target="_blank" href="http://php.net/manual/en/mcrypt.installation.php">PHP mcrypt extension</a> is not installed or disabled)</font></p>
			<?php
		}
		
	?>
	<div class="mo2f_container">
		<h2 class="nav-tab-wrapper">
			
			<a class="nav-tab <?php echo $active_tab == 'default' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'default'), $_SERVER['REQUEST_URI'] ); ?>">Login Security</a>
			<a class="nav-tab <?php echo $active_tab == 'blockedips' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'blockedips'), $_SERVER['REQUEST_URI'] ); ?>">IP Blocking</a>
			<a class="nav-tab <?php echo $active_tab == 'reports' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'reports'), $_SERVER['REQUEST_URI'] ); ?>">Reports</a>
			<a class="nav-tab <?php echo $active_tab == 'licencing' ? 'nav-tab-active' : ''; ?>" href="<?php echo add_query_arg( array('tab' => 'licencing'), $_SERVER['REQUEST_URI'] ); ?>">Licensing</a>
					
		</h2>
		<table style="width:100%;">
			<tr>
				<td style="width:75%;vertical-align:top;" id="configurationForm">
					<?php
							if($active_tab == 'blockedips'){ 
								mo_lla_blockedips();
							} else if($active_tab == 'reports'){ 
								mo_lla_reports();
							}  else if($active_tab == 'licencing'){ 
								mo_lla_licencing();
							} else if($active_tab == 'account'){ 
								if (get_option ( 'mo_wpns_verify_customer' ) == 'true') {
									mo_lla_login_page();
								} else if(get_option('mo_wpns_registration_status') == 'MO_OTP_DELIVERED_SUCCESS' || get_option('mo_wpns_registration_status') == 'MO_OTP_VALIDATION_FAILURE' || get_option('mo_wpns_registration_status') == 'MO_OTP_DELIVERED_FAILURE'){
									mo_lla_show_otp_verification();
								} else if (! Mo_LLA_Util::is_customer_registered()) {
									mo_lla_registration_page();
								} else{
									mo_lla_account_page();
								}
							} else{
									mo_lla_configuration_page();
							}
					?>
				</td>
				<td style="vertical-align:top;padding-left:1%;">
					<?php echo mo_lla_support(); ?>
				</td>
			</tr>
		</table>
	</div>
	<?php
}
/*End of main function*/

/* Create Customer function */
function mo_lla_registration_page(){
	
	?>

<!--Register with miniOrange-->
<form name="f" method="post" action="">
	<input type="hidden" name="option" value="mo_wpns_register_customer" />
	<p>Just complete the short registration below to configure WP Security Pro plugin. Please enter a valid email id that you have access to. You will be able to move forward after verifying an OTP that we will send to this email.</p>
	<div class="mo_wpns_table_layout" style="min-height: 274px;">
		<h3>Register with miniOrange</h3>
		<div id="panel1">
			<table class="mo_wpns_settings_table">
				<tr>
					<td><b><font color="#FF0000">*</font>Email:</b></td>
					<td>
					<?php 	$current_user = wp_get_current_user();
							if(get_option('mo_wpns_admin_email'))
								$admin_email = esc_html(get_option('mo_wpns_admin_email'));
							else
								$admin_email = $current_user->user_email; ?>
					<input class="mo_wpns_table_textbox" type="email" name="email"
						required placeholder="person@example.com"
						value="<?php echo $admin_email;?>" /></td>
				</tr>

				<tr>
					<td><b>Phone number:</b></td>
					<td><input class="mo_wpns_table_textbox" type="tel" id="phone"
						pattern="[\+]\d{11,14}|[\+]\d{1,4}([\s]{0,1})(\d{0}|\d{9,10})" name="phone"
						title="Phone with country code eg. +1xxxxxxxxxx"
						placeholder="Phone with country code eg. +1xxxxxxxxxx"
						value="<?php echo esc_html(get_option('mo_wpns_admin_phone'));?>" />
						<i>We will call only if you call for support</i><br><br></td>
				</tr>
				<tr>
					<td><b><font color="#FF0000">*</font>Password:</b></td>
					<td><input class="mo_wpns_table_textbox" required type="password"
						name="password" placeholder="Choose your password (Min. length 6)" />
					</td>
				</tr>
				<tr>
					<td><b><font color="#FF0000">*</font>Confirm Password:</b></td>
					<td><input class="mo_wpns_table_textbox" required type="password"
						name="confirmPassword" placeholder="Confirm your password" /></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td><input type="submit" value="Save"
						class="button button-primary button-large" /></td>
				</tr>
			</table>
		</div>
	</div>
</form>
<!--<script>
	jQuery("#phone").intlTelInput();
</script> -->
<?php
}
/* End of Create Customer function */

/* Login for customer*/
function mo_lla_login_page() {
	?>
		<!--Verify password with miniOrange-->
		<form name="f" method="post" action="">
			<input type="hidden" name="option" value="mo_wpns_verify_customer" />
			<div class="mo_wpns_table_layout">
				<h3>Login with miniOrange</h3>
				<div id="panel1">
					<table class="mo_wpns_settings_table">
						<tr>
							<td><b><font color="#FF0000">*</font>Email:</b></td>
							<td><input class="mo_wpns_table_textbox" type="email" name="email"
								required placeholder="person@example.com"
								value="<?php echo esc_html(get_option('mo_wpns_admin_email'));?>" /></td>
						</tr>
						<tr>
							<td><b><font color="#FF0000">*</font>Password:</b></td>
							<td><input class="mo_wpns_table_textbox" required type="password"
								name="password" placeholder="Enter your miniOrange password" /></td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td><input type="submit" class="button button-primary button-large" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a
								href="#cancel_link">Cancel</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a href="#mo_wpns_forgot_password_link">Forgot
									your password?</a></td>
						</tr>
					</table>
				</div>
			</div>
		</form>
		<form id="forgot_password_form" method="post" action="">
			<input type="hidden" name="option" value="mo_wpns_user_forgot_password" />
		</form>
		<form id="cancel_form" method="post" action="">
			<input type="hidden" name="option" value="mo_wpns_cancel" />
		</form>
		<script>

			jQuery('a[href="#cancel_link"]').click(function(){
				jQuery('#cancel_form').submit();
			});

			jQuery('a[href="#mo_wpns_forgot_password_link"]').click(function(){
				jQuery('#forgot_password_form').submit();
			});
		</script>
	<?php
}
/* End of Login for customer*/

/* Account for customer*/
function mo_lla_account_page() {
	?>

			<div style="background-color:#FFFFFF; border:1px solid #CCCCCC; padding:0px 0px 0px 10px; width:98%;height:344px">
				<div>
					<h4>Thank You for registering with miniOrange.</h4>
					<h3>Your Profile</h3>
					<table border="1" style="background-color:#FFFFFF; border:1px solid #CCCCCC; border-collapse: collapse; padding:0px 0px 0px 10px; margin:2px; width:85%">
						<tr>
							<td style="width:45%; padding: 10px;">Username/Email</td>
							<td style="width:55%; padding: 10px;"><?php echo esc_html(get_option('mo_wpns_admin_email'));?></td>
						</tr>
						<tr>
							<td style="width:45%; padding: 10px;">Customer ID</td>
							<td style="width:55%; padding: 10px;"><?php echo esc_html(get_option('mo_wpns_admin_customer_key'));?></td>
						</tr>
						<tr>
							<td style="width:45%; padding: 10px;">API Key</td>
							<td style="width:55%; padding: 10px;"><?php echo esc_html(get_option('mo_wpns_admin_api_key'));?></td>
						</tr>
						<tr>
							<td style="width:45%; padding: 10px;">Token Key</td>
							<td style="width:55%; padding: 10px;"><?php echo esc_html(get_option('mo_wpns_customer_token'));?></td>
						</tr>
					</table>
					<br/>
					<p><a href="#mo_wpns_forgot_password_link">Click here</a> if you forgot your password to your miniOrange account.</p>
				</div>
			</div>

			<form id="forgot_password_form" method="post" action="">
				<input type="hidden" name="option" value="mo_wpns_reset_password" />
			</form>
			
			<script>
				jQuery('a[href="#mo_wpns_forgot_password_link"]').click(function(){
					jQuery('#forgot_password_form').submit();
				});
			</script>			
			
			<?php
			if( isset($_POST['option']) && ($_POST['option'] == "mo_wpns_verify_customer" ||
					$_POST['option'] == "mo_wpns_register_customer") ){ ?>
				<script>
					//window.location.href = "<?php echo add_query_arg( array('tab' => 'licencing'), $_SERVER['REQUEST_URI'] ); ?>";
				</script>
			<?php }
}
/* End of Account for customer*/



/* Configure WPNS function */
function mo_lla_configuration_page(){
?>
	<div class="mo_wpns_small_layout">		
	
		<?php if (!Mo_LLA_Util::is_customer_registered()) { ?>
				<div class="warning_div">Please <a href="<?php echo add_query_arg( array('tab' => 'account'), $_SERVER['REQUEST_URI'] ); ?>">Register or Login with miniOrange</a> to configure the WP Security Pro Plugin.</div>
		<?php } ?>
		
		<!-- Brute Force Configuration -->
		<h3>Brute Force Protection ( Login Protection )</h3>
		<div class="mo_wpns_subheading">This protects your site from attacks which tries to gain access / login to a site with random usernames and passwords.</div>
		
		<form id="mo_wpns_enable_brute_force_form" method="post" action="">
			<input type="hidden" name="option" value="mo_wpns_enable_brute_force">
			<input type="checkbox" name="enable_brute_force_protection" <?php if(get_option('mo_wpns_enable_brute_force')) echo "checked";?> onchange="document.getElementById('mo_wpns_enable_brute_force_form').submit();"> Enable Brute force protection
		</form>
		<br>
		<?php if(get_option('mo_wpns_enable_brute_force')){ 
			
			$allwed_login_attempts = 10;
			$time_of_blocking_type = "permanent";
			$time_of_blocking_val = 3;
			if(get_option('mo_wpns_allwed_login_attempts'))
				$allwed_login_attempts = get_option('mo_wpns_allwed_login_attempts');
			if(get_option('mo_wpns_time_of_blocking_type'))
				$time_of_blocking_type = get_option('mo_wpns_time_of_blocking_type');
			if(get_option('mo_wpns_time_of_blocking_val'))
				$time_of_blocking_val = get_option('mo_wpns_time_of_blocking_val');
			
		?>
			<form id="mo_wpns_enable_brute_force_form" method="post" action="">
			<input type="hidden" name="option" value="mo_wpns_brute_force_configuration">
			<table class="mo_wpns_settings_table">
				<tr>
					<td style="width:30%">Allowed login attempts before blocking an IP  : </td>
					<td style="width:25%"><input class="mo_wpns_table_textbox" type="number" id="allwed_login_attempts" name="allwed_login_attempts" required placeholder="10" value="<?php echo $allwed_login_attempts?>" /></td>
					<td style="width:25%"></td>
				</tr>
				<tr>
					<td>Time period for which IP should be blocked  : </td>
					<td>
						<select id="time_of_blocking_type" name="time_of_blocking_type" style="width:100%;">
						  <option value="permanent" <?php if($time_of_blocking_type=="permanent") echo "selected";?>>Permanently</option>
						  <option value="months" <?php if($time_of_blocking_type=="months") echo "selected";?>>Months</option>
						  <option value="days" <?php if($time_of_blocking_type=="days") echo "selected";?>>Days</option>
						  <option value="hours" <?php if($time_of_blocking_type=="hours") echo "selected";?>>Hours</option>
						  <option value="minutes" <?php if($time_of_blocking_type=="minutes") echo "selected";?>>Minutes</option>
						</select>
					</td>
					<td><input class="mo_wpns_table_textbox <?php if($time_of_blocking_type=="permanent") echo "hidden";?>" type="number" id="time_of_blocking_val" name="time_of_blocking_val" value="<?php echo $time_of_blocking_val?>" placeholder="How many?" /></td>
				</tr>
				<tr>
					<td>Show remaining login attempts to user : </td>
					<td><input type="checkbox" name="show_remaining_attempts" <?php if(get_option('mo_wpns_show_remaining_attempts')) echo "checked";?> ></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td><br><input type="submit" name="submit" style="width:100px;" value="Save" class="button button-primary button-large"></td>
					<td></td>
				</tr>
			</table>
			</form>
		<?php } ?>
	</div>
	

	
	<div class="mo_wpns_small_layout">		
		<h3>Google reCAPTCHA</h3>
		<div class="mo_wpns_subheading">Google reCAPTCHA protects your website from spam and abuse. reCAPTCHA uses an advanced risk analysis engine and adaptive CAPTCHAs to keep automated software from engaging in abusive activities on your site. It does this while letting your valid users pass through with ease.</div>
		<form id="mo_wpns_activate_recaptcha" method="post" action="">
			<input type="hidden" name="option" value="mo_wpns_activate_recaptcha">
			<input type="checkbox" name="mo_wpns_activate_recaptcha" <?php if(get_option('mo_wpns_activate_recaptcha')) echo "checked";?> onchange="document.getElementById('mo_wpns_activate_recaptcha').submit();"> Enable Google reCAPTCHA
		</form>
		<?php if(get_option('mo_wpns_activate_recaptcha')){ ?>
			<p>Before you can use reCAPTCHA, you must need to register your domain/webiste <a href="https://www.google.com/recaptcha/admin#list">here</a>.</p>
			<p>Enter Site key and Secret key that you get after registration.</p>
			<form id="mo_wpns_recaptcha_settings" method="post" action="">
				<input type="hidden" name="option" value="mo_wpns_recaptcha_settings">
				<table class="mo_wpns_settings_table">
					<tr>
						<td style="width:30%">Site key  : </td>
						<td style="width:25%"><input class="mo_wpns_table_textbox" type="text" name="mo_wpns_recaptcha_site_key" required placeholder="site key" value="<?php echo esc_html(get_option('mo_wpns_recaptcha_site_key'));?>" /></td>
						<td style="width:25%"></td>
					</tr>
					<tr>
						<td>Secret key  : </td>
						<td><input class="mo_wpns_table_textbox" type="text"  name="mo_wpns_recaptcha_secret_key" required placeholder="secret key" value="<?php echo esc_html(get_option('mo_wpns_recaptcha_secret_key'));?>" /></td>
					</tr>
					<tr>
						<td style="vertical-align:top;">Enable reCAPTCHA for :</td>
						<td><input type="checkbox" name="mo_wpns_activate_recaptcha_for_login" <?php if(get_option('mo_wpns_activate_recaptcha_for_login')) echo "checked";?>> Login form<br>
						<input type="checkbox" name="mo_wpns_activate_recaptcha_for_registration" <?php if(get_option('mo_wpns_activate_recaptcha_for_registration')) echo "checked";?>> Registeration form</td>
					</tr>
				</table>
				<input type="submit" value="Save Settings" class="button button-primary button-large" />
				<input type="button" value="Test reCAPTCHA Configuration" onclick="testRecaptchaConfiguration()" class="button button-primary button-large" />
			</form>
		<?php } ?>
		
		
	</div>
	
	<script>	
		<?php if (!Mo_LLA_Util::is_customer_registered()) { ?>
			jQuery( document ).ready(function() {
				jQuery(".mo_wpns_small_layout :input").prop("disabled", true);
				jQuery(".mo_wpns_small_layout :input[type=text]").val("");
				jQuery(".mo_wpns_small_layout :input[type=url]").val("");
			});
		<?php } ?>
		
		jQuery("#time_of_blocking_type").change(function() {
			if(jQuery(this).val()=="permanent")
				jQuery("#time_of_blocking_val").addClass("hidden");
			else
				jQuery("#time_of_blocking_val").removeClass("hidden");	
		});
		function testRecaptchaConfiguration(){
			var myWindow = window.open('<?php echo site_url(); ?>' + '/?option=testrecaptchaconfig', "Test Google reCAPTCHA Configuration", "width=600, height=600");	
		}
	</script>
	
	
<?php
}
/* End of Configure function */




function mo_lla_blockedips(){
	$mo_wpns_handler = new Mo_LLA_Handler();
	$blockedips = $mo_wpns_handler->get_blocked_ips(); ?>
	<div class="mo_wpns_small_layout">
	
		<?php if (!Mo_LLA_Util::is_customer_registered()) { ?>
				<div class="warning_div">Please <a href="<?php echo add_query_arg( array('tab' => 'account'), $_SERVER['REQUEST_URI'] ); ?>">Register or Login with miniOrange</a> to configure the WP Security Pro Plugin.</div><br>
		<?php } ?>
		<h2>Manual Block IP's</h2>
		<form name="f" method="post" action="" id="manualblockipform" >
			<input type="hidden" name="option" value="mo_wpns_manual_block_ip" />
			<table><tr><td>You can manually block an IP address here: </td>
			<td style="padding:0px 10px"><input class="mo_wpns_table_textbox" type="text" name="ip"
				required placeholder="IP address" value=""  pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}" /></td>
			<td><input type="submit" class="button button-primary button-large" value="Manual Block IP" /></td></tr></table>
		</form>
		<h2>Blocked IP's</h2>
		<table id="blockedips_table" class="display">
		<thead><tr><th width="15%">IP Address</th><th width="25%">Reason</th><th width="24%">Blocked Until</th><th width="24%">Blocked Date</th><th width="20%">Action</th></tr></thead>
		<tbody>
		<?php foreach($blockedips as $blockedip){
			echo "<tr><td>".$blockedip->ip_address."</td><td>".$blockedip->reason."</td><td>";
			if(empty($blockedip->blocked_for_time)) echo "<span class=redtext>Permanently</span>"; else echo date("M j, Y, g:i:s a",$blockedip->blocked_for_time);
			echo "</td><td>".date("M j, Y, g:i:s a",$blockedip->created_timestamp)."</td><td><a onclick=unblockip('".$blockedip->id."')>Unblock IP</a></td></tr>";
		} ?>
		</tbody>
		</table>
	</div>
	<form class="hidden" id="unblockipform" method="POST">
		<input type="hidden" name="option" value="mo_wpns_unblock_ip" />
		<input type="hidden" name="entryid" value="" id="unblockipvalue" />
	</form>
	
	<?php $whitelisted_ips = $mo_wpns_handler->get_whitelisted_ips(); ?>
	<div class="mo_wpns_small_layout">
		<?php if (!Mo_LLA_Util::is_customer_registered()) { ?>
				<div class="warning_div">Please <a href="<?php echo add_query_arg( array('tab' => 'account'), $_SERVER['REQUEST_URI'] ); ?>">Register or Login with miniOrange</a> to configure the WP Security Pro Plugin.</div><br>
		<?php } ?>
		<h2>Whitelist IP's</h2>
		<form name="f" method="post" action="" id="whitelistipform">
			<input type="hidden" name="option" value="mo_wpns_whitelist_ip" />
			<table><tr><td>Add new IP address to whitelist : </td>
			<td style="padding:0px 10px"><input class="mo_wpns_table_textbox" type="text" name="ip"
				required placeholder="IP address" value=""  pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){4}" /></td>
			<td><input type="submit" class="button button-primary button-large" value="Whitelist IP" /></td></tr></table>
		</form>
		<h2>Whitelisted IP's</h2>
		<table id="whitelistedips_table" class="display">
		<thead><tr><th width="30%">IP Address</th><th width="40%">Whitelisted Date</th><th width="30%">Remove from Whitelist</th></tr></thead>
		<tbody><?php foreach($whitelisted_ips as $whitelisted_ip){
			echo "<tr><td>".$whitelisted_ip->ip_address."</td><td>".date("M j, Y, g:i:s a",$whitelisted_ip->created_timestamp)."</td><td><a onclick=removefromwhitelist('".$whitelisted_ip->id."')>Remove</a></td></tr>";
		} ?></tbody>
		</table>
	</div>
	<form class="hidden" id="removefromwhitelistform" method="POST">
		<input type="hidden" name="option" value="mo_wpns_remove_whitelist" />
		<input type="hidden" name="entryid" value="" id="removefromwhitelistentry" />
	</form>

	<script>
		<?php if (!Mo_LLA_Util::is_customer_registered()) { ?>
			jQuery( document ).ready(function() {
				jQuery("#manualblockipform :input").prop("disabled", true);
				jQuery("#manualblockipform :input[type=text]").val("");
				jQuery("#whitelistipform :input").prop("disabled", true);
				jQuery("#whitelistipform :input[type=text]").val("");
			});
		<?php } ?>
		function unblockip(entryid){
			jQuery("#unblockipvalue").val(entryid);
			jQuery("#unblockipform").submit();
		}
	</script>
	<script>
		jQuery(document).ready(function() {
			jQuery('#blockedips_table').DataTable({
				"order": [[ 3, "desc" ]]
			});
		} );
	</script>
	<script>
		function removefromwhitelist(entryid){
			jQuery("#removefromwhitelistentry").val(entryid);
			jQuery("#removefromwhitelistform").submit();
		}
	</script>
	<script>
		jQuery(document).ready(function() {
			jQuery('#whitelistedips_table').DataTable({
				"order": [[ 1, "desc" ]]
			});
		} );
	</script>
	<?php
}



function mo_lla_licencing(){
?>
	<div class="mo_wpns_table_layout">
		<table class="mo_wpns_local_pricing_table">
		<h2>Licensing Plans
		<span style="float:right"><input type="button" name="ok_btn" id="ok_btn" class="button button-primary button-large" value="OK, Got It" onclick="window.location.href='admin.php?page=wp_security_pro&tab=default'" /></span>
		</h2><hr>
		<tr style="vertical-align:top;">
	
				<td>
				<div class="mo_wpns_local_thumbnail mo_wpns_local_pricing_paid_tab" >
				
				<h3 class="mo_wpns_local_pricing_header">Do it yourself</h3>
				<p></p>
				
				
				<hr>
				<p class="mo_wpns_pricing_text" >$29 / year<br>+ <br>
				<span style="font-size:12px">( Additional Discounts available for <br>multiple instances and years)</span><br></p>
				<p></p>
				<h4 class="mo_wpns_local_pricing_sub_header" style="padding-bottom:8px !important;"><a class="button button-primary button-large" onclick="upgradeform('wp_security_pro_basic_plan')" >Click here to upgrade</a> *</h4>
				<hr>
				<p class="mo_wpns_pricing_text" >
					Brute Force Protection ( Login Security and Monitoring - Limit Login Attempts and track user logins. )<br><br>
					User Registration Security - Disallow Disposable / Fake email addresses<br><br>
					IP Blocking:(manual and automatic) [Blaclisting and whitelisting included]<br><br>
					Advanced Blocking - Block users based on: IP range, Country Blocking<br><br>
					Mobile authentication based on QR code, OTP over SMS and email, Push, Soft token (15+ methods to choose from)<br>For Unlimited Users<br><br>
					Notification to admin and end users - Send Email Alerts for IP blocking and unusual activities with user account<br><br>
					Advanced activity logs	auditing and reporting<br><br>
					DOS protection - Process Delays - Delays responses in case of an attack	<br><br>
					Password protection - Enforce Strong Password : Check Password strength for all users<br><br>
					Risk based access - Contextual authentication based on device, location, time of access and user behavior<br><br>
					Icon based Authentication<br><br>
					Honeypot - Divert hackers and bots away from your assets<br><br>
					Advanced User Verification<br><br>
					Social Login Integration<br><br>
					Customized Email Templates<br><br>
					Advanced Reporting<br><br><br>
					<hr>
				</p>

				
				<p class="mo_wpns_pricing_text" >Basic Support by Email</p>
				</div></td>
				<td>
				<div class="mo_wpns_local_thumbnail mo_wpns_local_pricing_free_tab" >
				<h3 class="mo_wpns_local_pricing_header">Premium</h3>
				<p></p>
				
				 
				<hr>
				<p class="mo_wpns_pricing_text">$29 / year + One Time Setup Fees <br>
				( $45 per hour )<br>
				<span style="font-size:12px">( Additional Discounts available for <br>multiple instances and years)</span><br></p>
				<h4 class="mo_wpns_local_pricing_sub_header" style="padding-bottom:8px !important;"><a class="button button-primary button-large" onclick="upgradeform('wp_security_pro_premium_plan')" >Click here to upgrade</a> *</h4>
				<hr>
				
				<p class="mo_wpns_pricing_text">
					Brute Force Protection ( Login Security and Monitoring - Limit Login Attempts and track user logins. )<br><br>
					User Registration Security - Disallow Disposable / Fake email addresses<br><br>
					IP Blocking:(manual and automatic) [Blaclisting and whitelisting included]<br><br>
					Advanced Blocking - Block users based on: IP range, Country Blocking<br><br>
					Mobile authentication based on QR code, OTP over SMS and email, Push, Soft token (15+ methods to choose from)<br>For Unlimited Users<br><br>
					Notification to admin and end users - Send Email Alerts for IP blocking and unusual activities with user account<br><br>
					Advanced activity logs	auditing and reporting<br><br>
					DOS protection - Process Delays - Delays responses in case of an attack	<br><br>
					Password protection - Enforce Strong Password : Check Password strength for all users<br><br>
					Risk based access - Contextual authentication based on device, location, time of access and user behavior<br><br>
					Icon based Authentication<br><br>
					Honeypot - Divert hackers and bots away from your assets<br><br>
					Advanced User Verification<br><br>
					Social Login Integration<br><br>
					Customized Email Templates<br><br>
					Advanced Reporting<br><br>
					End to End Integration Support<br>
					<hr>
				</p>
				
				
				
				<p class="mo_wpns_pricing_text">Premium Support Plans Available</p>
				
				</div></td>
			
		</tr>	
		</table>
		<form style="display:none;" id="loginform" action="<?php echo esc_html(get_option( 'mo_wpns_host_name')).'/moas/login'; ?>" 
		target="_blank" method="post">
		<input type="email" name="username" value="<?php echo esc_html(get_option('mo_wpns_admin_email')); ?>" />
		<input type="text" name="redirectUrl" value="<?php echo esc_html(get_option( 'mo_wpns_host_name')).'/moas/initializepayment'; ?>" />
		<input type="text" name="requestOrigin" id="requestOrigin"  />
		</form>
		<script>
			function upgradeform(planType){
				jQuery('#requestOrigin').val(planType);
				jQuery('#loginform').submit();
			}
		</script>
		<br>
		<h3>* Steps to upgrade to premium plugin -</h3>
		<p>1. You will be redirected to miniOrange Login Console. Enter your password with which you created an account with us. After that you will be redirected to payment page.</p>
		<p>2. Enter you card details and complete the payment. On successful payment completion, you will see the link to download the premium plugin.</p>
		<p>3. Once you download the premium plugin, just unzip it and replace the folder with existing plugin. </p>
		<b>Note: Do not delete the plugin from the Wordpress Admin Panel and upload the plugin using zip. Your saved settings will get lost.</b>
		<p>4. From this point on, do not update the plugin from the Wordpress store. We will notify you when we upload a new version of the plugin.</p>
		
		<h3>** End to End Integration - We will setup a conference and do end to end configuration for you. We provide services to do the configuration on your behalf. </h3>
		
		<h3>10 Days Return Policy -</h3>
		<p>At miniOrange, we want to ensure you are 100% happy with your purchase. If you feel that the premium plugin you purchased is not the best fit for your requirements or you’ve attempted to resolve any feature issues with our support team, which couldn't get resolved. We will refund the whole amount within 10 days of the purchase. Please email us at <a href="mailto:info@miniorange.com">info@miniorange.com</a> for any queries regarding the return policy.<br><br>
If you have any doubts regarding the licensing plans, you can mail us at <a href="mailto:info@miniorange.com">info@miniorange.com</a> or submit a query using the support form.</p>
		<br>
		
		
<br><br>	

		</div>
		</div>
		<form style="display:none;" id="loginform" action="<?php echo esc_html(get_option( 'mo_wpns_host_name')).'/moas/login'; ?>" 
		target="_blank" method="post">
		<input type="email" name="username" value="<?php echo esc_html(get_option('mo_wpns_admin_email')); ?>" />
		<input type="text" name="redirectUrl" value="<?php echo esc_html(get_option( 'mo_wpns_host_name')).'/moas/initializepayment'; ?>" />
		<input type="text" name="requestOrigin" id="requestOrigin"  />
		</form>
		<script>
			function upgradeform(planType){
				jQuery('#requestOrigin').val(planType);
				jQuery('#loginform').submit();
			}
		</script>
		<script>
			jQuery(document).ready(function() {
				//jQuery('.mo_wpns_support_layout').hide();
				//jQuery('#configurationForm').css("width","100%");
			});
		</script>
<?php
}

function mo_lla_reports(){
	$mo_wpns_handler = new Mo_LLA_Handler();
	$usertranscations = $mo_wpns_handler->get_all_transactions(); ?>
<div class="mo_wpns_small_layout">	
	<h2>User Transactions Report</h2>
	
	<div class="mo_wpns_small_layout hidden">	
		
		<div style="float:right;margin-top:10px">
		<input type="submit" name="printcsv" style="width:100px;" value="Print PDF" class="button button-success button-large">
		<input type="submit" name="printpdf" style="width:100px;" value="Print CSV" class="button button-success button-large">
		</div>
		<h3>Advanced Report</h3>
		
		<form id="mo_wpns_advanced_reports" method="post" action="">
			<input type="hidden" name="option" value="mo_wpns_advanced_reports">
			<table style="width:100%">
			<tr>
			<td width="33%">WordPress Username : <input class="mo_wpns_table_textbox" type="text"  name="username" required="" placeholder="Search by username" value=""></td>
			<td width="33%">IP Address :<input class="mo_wpns_table_textbox" type="text"  name="ip" required="" placeholder="Search by IP" value=""></td>
			<td width="33%">Status : <select name="status" style="width:100%;">
				  <option value="success" selected="">Success</option>
				  <option value="failed">Failed</option>
				</select>
			</td>
			</tr>
			<tr><td><br></td></tr>
			<tr>
			<td width="33%">User Action : <select name="action" style="width:100%;">
				  <option value="login" selected="">User Login</option>
				  <option value="register">User Registeration</option>
				</select>
			</td>
			<td width="33%">From Date : <input class="mo_wpns_table_textbox" type="date"  name="fromdate"></td>
			<td width="33%">To Date :<input class="mo_wpns_table_textbox" type="date"  name="todate"></td>
			</tr>
			</table>
			<br><input type="submit" name="Search" style="width:100px;" value="Search" class="button button-primary button-large">
		</form>
		<br>
	</div>
	
	<table id="reports_table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>IP Address</th>
				<th>Username</th>
				<th>User Action</th>
				<th>Status</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($usertranscations as $usertranscation){
			echo "<tr><td>".$usertranscation->ip_address."</td><td>".$usertranscation->username."</td><td>".$usertranscation->type."</td><td>";
			if($usertranscation->status==Mo_LLA_Constants::FAILED || $usertranscation->status==Mo_LLA_Constants::PAST_FAILED)
				echo "<span style=color:red>".Mo_LLA_Constants::FAILED."</span>";
			else if($usertranscation->status==Mo_LLA_Constants::SUCCESS)
				echo "<span style=color:green>".Mo_LLA_Constants::SUCCESS."</span>";
			else
				echo "N/A";
			echo "</td><td>".date("M j, Y, g:i:s a",$usertranscation->created_timestamp)."</td></tr>";
			} ?>
        </tbody>
    </table>
</div>
<script>
	jQuery(document).ready(function() {
		jQuery('#reports_table').DataTable({
			"order": [[ 4, "desc" ]]
		});
	} );
</script>
<?php	
}


/* Show OTP verification page*/
function mo_lla_show_otp_verification(){
	?>
		<div class="mo_wpns_table_layout">
			<div id="panel2">
				<table class="mo_wpns_settings_table">
		<!-- Enter otp -->
				<form name="f" id="back_registration_form" method="post" action="">
							<td>
							<input type="hidden" name="option" value="mo_wpns_registeration_back"/>
							</td>
						</tr>
					</form>
					<form name="f" method="post" id="wpns_form" action="">
						<input type="hidden" name="option" value="mo_wpns_validate_otp" />
						<h3>Verify Your Email</h3>
						<tr>
							<td><b><font color="#FF0000">*</font>Enter OTP:</b></td>
							<td colspan="2"><input class="mo_wpns_table_textbox" autofocus="true" type="text" name="otp_token" required placeholder="Enter OTP" style="width:61%;" />
							 &nbsp;&nbsp;<a style="cursor:pointer;" onclick="document.getElementById('resend_otp_form').submit();">Resend OTP over Email</a></td>
						</tr>
						<tr><td colspan="3"></td></tr>
						<tr><td></td><td>
						<a style="cursor:pointer;" onclick="document.getElementById('back_registration_form').submit();"><input type="button" value="Back" id="back_btn" class="button button-primary button-large" /></a>
						<input type="submit" value="Validate OTP" class="button button-primary button-large" />
						</td>
						</form>
						<td><form method="post" action="" id="mo_wpns_cancel_form">
							<input type="hidden" name="option" value="mo_wpns_cancel" />
						</form></td></tr>
					<form name="f" id="resend_otp_form" method="post" action="">
							<td>
							<input type="hidden" name="option" value="mo_wpns_resend_otp"/>
							</td>
						</tr>
					</form>
				</table>
				<br>
				<hr>

				<h3>I did not recieve any email with OTP . What should I do ?</h3>
				<form id="phone_verification" method="post" action="">
					<input type="hidden" name="option" value="mo_wpns_phone_verification" />
					 If you can't see the email from miniOrange in your mails, please check your <b>SPAM Folder</b>. If you don't see an email even in SPAM folder, verify your identity with our alternate method.
					 <br><br>
						<b>Enter your valid phone number here and verify your identity using one time passcode sent to your phone.</b><br><br><input class="mo_wpns_table_textbox" required="true" pattern="[\+]\d{1,3}\d{10}" autofocus="true" type="text" name="phone_number" id="phone" placeholder="Enter Phone Number" style="width:40%;" value="<?php echo esc_html(get_option('mo_wpns_admin_phone'));  ?>" title="Enter phone number without any space or dashes."/>
						<br><input type="submit" value="Send OTP" class="button button-primary button-large" />
				
				</form>
			</div>
		</div>
		<script>
	jQuery("#phone").intlTelInput();
	jQuery('#back_btn').click(function(){
			jQuery('#mo_wpns_cancel_form').submit();
	});
	
</script>
<?php
}
/* End Show OTP verification page*/



?>