<?php
/** Copyright (C) 2015  miniOrange

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>
* @package 		miniOrange OAuth
* @license		http://www.gnu.org/copyleft/gpl.html GNU/GPL, see LICENSE.php
*
**/

class Mo_LLA_Recaptcha_Handler{

	function verify(){
		$isvalid = false;
		if(isset($_POST['g-recaptcha-response'])){
			$ip = Mo_LLA_Util::get_client_ip();
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$fields = array('response' => urlencode($_POST['g-recaptcha-response']),'secret' => get_option('mo_wpns_recaptcha_secret_key'),'remoteip' => $ip);
			$fields_string="";
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			if(!empty($result)){
				$content = json_decode($result, true);
				if(isset($content['success']) && $content['success']==1)
					$isvalid = true;
			}
		}
		return $isvalid;
	}
	
	function test_configuration(){
		if(isset($_POST['g-recaptcha-response'])){
			$ip = Mo_LLA_Util::get_client_ip();
			$url = 'https://www.google.com/recaptcha/api/siteverify';
			$fields = array('response' => urlencode($_POST['g-recaptcha-response']),'secret' => get_option('mo_wpns_recaptcha_secret_key'),'remoteip' => $ip);
			$fields_string="";
			foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
			rtrim($fields_string, '&');

			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
			$result = curl_exec($ch);
			curl_close($ch);
			if(!empty($result)){
				$content = json_decode($result, true);
				if(isset($content['error-codes']) && in_array("invalid-input-secret", $content['error-codes']))
					echo "<br><br><h2 style=color:red;text-align:center>Invalid Secret Key.</h2>";
				else if(isset($content['success']) && $content['success']==1)
					echo "<br><br><h2 style=color:green;text-align:center>Test was successful and captcha verified.</h2>";
				else
					echo "<br><br><h2 style=color:red;text-align:center>Invalid captcha. Please try again.</h2>";
			}
		} 
			?>
			<script src='https://www.google.com/recaptcha/api.js'></script>
			<div style="margin:0px auto;width:350px">
				<br><br><h2>Test google reCAPTCHA keys</h2>
				<form method="post">
					<div class="g-recaptcha" data-sitekey="<?php echo get_option('mo_wpns_recaptcha_site_key');?>"></div>
					<br><input type="submit" value="Test Keys" class="button button-primary button-large">
				</form>
			</div>
			<?php
		
		exit();
	}
	
}