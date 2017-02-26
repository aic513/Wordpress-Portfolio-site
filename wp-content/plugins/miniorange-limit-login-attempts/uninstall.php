<?php

	//if uninstall not called from WordPress exit
	if ( !defined( 'WP_UNINSTALL_PLUGIN' ) ) 
		exit();

	
	delete_option('mo_wpns_enable_brute_force');
	delete_option('mo_wpns_show_remaining_attempts');
	delete_option('mo_wpns_enable_ip_blocked_email_to_admin');
	delete_option('mo_wpns_enable_unusual_activity_email_to_user');
	delete_option( 'mo_wpns_enable_htaccess_blocking');
	delete_option( 'mo_wpns_enable_user_agent_blocking');
	delete_option( 'mo_wpns_countrycodes');
	delete_option( 'mo_wpns_referrers');
	delete_option( 'protect_wp_config');
	delete_option( 'prevent_directory_browsing');
	delete_option( 'disable_file_editing');
	delete_option( 'mo_wpns_enable_comment_spam_blocking');
	delete_option( 'mo_wpns_enable_comment_recaptcha');

	delete_option( 'mo_wpns_slow_down_attacks');
	delete_option( 'mo_wpns_enforce_strong_passswords');
 	delete_option( 'mo_wpns_enforce_strong_passswords_for_accounts');
 	delete_option( 'mo_wpns_activate_recaptcha');
	delete_option( 'mo_wpns_activate_recaptcha_for_login');
	delete_option( 'mo_wpns_activate_recaptcha_for_registration');
	delete_option( 'mo_wpns_recaptcha_site_key');
 	delete_option( 'mo_wpns_recaptcha_secret_key');
	delete_option( 'mo_wpns_enable_fake_domain_blocking');
 	delete_option( 'mo_wpns_enable_advanced_user_verification');
 	
 	delete_option('mo_wpns_dbversion');

	
	delete_option('mo_wpns_countrycodes');
	delete_option('mo_wpns_enable_htaccess_blocking');
	delete_option('mo_wpns_enable_advanced_user_verification');
	delete_option('mo_wpns_enable_social_integration');
	delete_option('mo_wpns_risk_based_access');
	
	delete_option('mo_wpns_message');
	
	//drop custom db tables
	global $wpdb;
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpns_transactions" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpns_blocked_ips" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpns_whitelisted_ips" );
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}wpns_email_sent_audit" );

	
?>