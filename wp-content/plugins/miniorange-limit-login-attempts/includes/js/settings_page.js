jQuery(document).ready(function () {
	
	//show and hide instructions
    jQuery("#auth_help").click(function () {
        jQuery("#auth_troubleshoot").toggle();
    });
	jQuery("#conn_help").click(function () {
        jQuery("#conn_troubleshoot").toggle();
    });
	
	jQuery("#conn_help_user_mapping").click(function () {
        jQuery("#conn_user_mapping_troubleshoot").toggle();
    });
	
	//show and hide attribute mapping instructions
    jQuery("#toggle_am_content").click(function () {
        jQuery("#show_am_content").toggle();
    });

	 //Instructions
    jQuery("#mo_wpns_help_curl_title").click(function () {
    	jQuery("#mo_wpns_help_curl_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpns_help_mobile_auth_title").click(function () {
    	jQuery("#mo_wpns_help_mobile_auth_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpns_help_disposable_title").click(function () {
    	jQuery("#mo_wpns_help_disposable_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpns_help_strong_pass_title").click(function () {
    	jQuery("#mo_wpns_help_strong_pass_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpns_help_adv_user_ver_title").click(function () {
    	jQuery("#mo_wpns_help_adv_user_ver_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpns_help_social_login_title").click(function () {
    	jQuery("#mo_wpns_help_social_login_desc").slideToggle(400);
    });
	
	jQuery("#mo_wpns_help_custom_template_title").click(function () {
    	jQuery("#mo_wpns_help_custom_template_desc").slideToggle(400);
    });


});