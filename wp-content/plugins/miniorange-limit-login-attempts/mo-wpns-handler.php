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

class Mo_LLA_Handler{
	
	
	function create_db(){
		global $wpdb;
		$tableName = $wpdb->prefix.Mo_LLA_Constants::USER_TRANSCATIONS_TABLE;
		if($wpdb->get_var("show tables like '$tableName'") != $tableName) 
		{
			$sql = "CREATE TABLE " . $tableName . " (
			`id` bigint NOT NULL AUTO_INCREMENT, `ip_address` mediumtext NOT NULL ,  `username` mediumtext NOT NULL ,
			`type` mediumtext NOT NULL , `url` mediumtext NOT NULL , `status` mediumtext NOT NULL , `created_timestamp` int, UNIQUE KEY id (id) );";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		$tableName = $wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE;
		if($wpdb->get_var("show tables like '$tableName'") != $tableName) 
		{
			$sql = "CREATE TABLE " . $tableName . " (
			`id` int NOT NULL AUTO_INCREMENT, `ip_address` mediumtext NOT NULL , `reason` mediumtext, `blocked_for_time` int,
			`created_timestamp` int, UNIQUE KEY id (id) );";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		$tableName = $wpdb->prefix.Mo_LLA_Constants::WHITELISTED_IPS_TABLE;
		if($wpdb->get_var("show tables like '$tableName'") != $tableName) 
		{
			$sql = "CREATE TABLE " . $tableName . " (
			`id` int NOT NULL AUTO_INCREMENT, `ip_address` mediumtext NOT NULL , `created_timestamp` int, UNIQUE KEY id (id) );";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
		$tableName = $wpdb->prefix.Mo_LLA_Constants::EMAIL_SENT_AUDIT;
		if($wpdb->get_var("show tables like '$tableName'") != $tableName) 
		{
			$sql = "CREATE TABLE " . $tableName . " (
			`id` int NOT NULL AUTO_INCREMENT, `ip_address` mediumtext NOT NULL , `username` mediumtext NOT NULL, `reason` mediumtext, `created_timestamp` int, UNIQUE KEY id (id) );";
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			dbDelta($sql);
		}
	}
	
	function is_ip_blocked($ipAddress){
		if(empty($ipAddress))
			return false;
		global $wpdb;
		
		$myrows = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE." where ip_address = '".$ipAddress."'" );
		if($myrows){
			if(count($myrows)>0){
				$time_of_blocking = $myrows[0]->blocked_for_time;
				$currenttime = current_time( 'timestamp' );
				if($currenttime < $time_of_blocking){
					return true;
				} else{
					$wpdb->query( "DELETE FROM ".$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE." WHERE ip_address = '".$ipAddress."'");
					$wpdb->query( "UPDATE ".$wpdb->prefix.Mo_LLA_Constants::USER_TRANSCATIONS_TABLE." SET status='".Mo_LLA_Constants::PAST_FAILED."' WHERE ip_address = '".$ipAddress."' AND status='".Mo_LLA_Constants::FAILED."'");
				}
			}
		}
		return false;
	}
	
	function block_ip($ipAddress, $reason, $permenently){
		if(empty($ipAddress))
			return;
		if($this->is_ip_blocked($ipAddress))
			return;
		$blocked_for_time = null;
		if(!$permenently && get_option('mo_wpns_time_of_blocking_type')){
			$blocking_type = get_option('mo_wpns_time_of_blocking_type');
			$time_of_blocking_val = 3;
			if(get_option('mo_wpns_time_of_blocking_val'))
				$time_of_blocking_val = get_option('mo_wpns_time_of_blocking_val');
			if($blocking_type=="months")
				$blocked_for_time = current_time( 'timestamp' )+$time_of_blocking_val * 30 * 24 * 60 * 60;
			else if($blocking_type=="days")
				$blocked_for_time = current_time( 'timestamp' )+$time_of_blocking_val * 24 * 60 * 60;
			else if($blocking_type=="hours")
				$blocked_for_time = current_time( 'timestamp' )+$time_of_blocking_val * 60 * 60;
			else if($blocking_type=="minutes")
				$blocked_for_time = current_time( 'timestamp' )+$time_of_blocking_val * 60;
		}
		
		if(get_option('mo_wpns_enable_htaccess_blocking')){
			$base = dirname(dirname(dirname(dirname(__FILE__))));
			$f = fopen($base.DIRECTORY_SEPARATOR.".htaccess", "a");
			fwrite($f, "\ndeny from ".trim($ipAddress));
			fclose($f);
		}
		
		global $wpdb;
		$wpdb->insert( 
			$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE, 
			array( 
				'ip_address' => $ipAddress, 
				'reason' => $reason,
				'blocked_for_time' => $blocked_for_time,
				'created_timestamp' => current_time( 'timestamp' )
			)
		);
	}
	
	function unblock_ip_entry($entryid){
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT ip_address FROM ".$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE." where id=".$entryid );
		if(count($myrows)>0)
			if(get_option('mo_wpns_enable_htaccess_blocking')){
				$ip_address = $myrows[0]->ip_address;
				$base = dirname(dirname(dirname(dirname(__FILE__))));
				$hpath = $base.DIRECTORY_SEPARATOR.".htaccess";
				$contents = file_get_contents($hpath);
				if (strpos($contents, "\ndeny from ".trim($ip_address)) !== false) {
					$contents = str_replace("\ndeny from ".trim($ip_address), '', $contents);
					file_put_contents($hpath, $contents);
				}
			}
		
		$wpdb->query( 
			"DELETE FROM ".$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE."
			 WHERE id = ".$entryid
		);
	}
	
	function remove_htaccess_ips(){
		global $wpdb;
		$myrows = $wpdb->get_results("SELECT ip_address FROM ".$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE);
		$base = dirname(dirname(dirname(dirname(__FILE__))));
		$hpath = $base.DIRECTORY_SEPARATOR.".htaccess";
		$contents = file_get_contents($hpath);
		$changed = 0;
		foreach($myrows as $row){
			$ip_address = $row->ip_address;
			if (strpos($contents, "\ndeny from ".trim($ip_address)) !== false) {
				$contents = str_replace("\ndeny from ".trim($ip_address), '', $contents);
				$changed = 1;
			}
		}
		if($changed==1)
			file_put_contents($hpath, $contents);
	}
	
	function add_htaccess_ips(){
		global $wpdb;
		$myrows = $wpdb->get_results("SELECT ip_address FROM ".$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE);
		$base = dirname(dirname(dirname(dirname(__FILE__))));
		$hpath = $base.DIRECTORY_SEPARATOR.".htaccess";
		$contents = file_get_contents($hpath);
		$f = fopen($hpath, "a");
		foreach($myrows as $row){
			$ip_address = $row->ip_address;
			if (strpos($contents, "\ndeny from ".trim($ip_address)) !== false) {
			}else
				fwrite($f, "\ndeny from ".trim($ip_address));
		}
		fclose($f);
	}
	
	function get_blocked_ips(){
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT id, ip_address, reason, blocked_for_time, created_timestamp FROM ".$wpdb->prefix.Mo_LLA_Constants::BLOCKED_IPS_TABLE );
		return $myrows;
	}
	
	function is_whitelisted($ipAddress){
		if(empty($ipAddress))
			return false;
		global $wpdb;
		$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix.Mo_LLA_Constants::WHITELISTED_IPS_TABLE." where ip_address = '".$ipAddress."'" );
		if($user_count)
			$user_count = intval($user_count);
		if($user_count>0)
			return true;
		return false;
	}
	
	function whitelist_ip($ipAddress){
		
		if(get_option('mo_wpns_enable_htaccess_blocking')){
			$base = dirname(dirname(dirname(dirname(__FILE__))));
			$hpath = $base.DIRECTORY_SEPARATOR.".htaccess";
			$contents = file_get_contents($hpath);
			if (strpos($contents, "\ndeny from ".trim($ipAddress)) !== false) {
				$contents = str_replace("\ndeny from ".trim($ipAddress), '', $contents);
				file_put_contents($hpath, $contents);
			}
		}
		
		if(empty($ipAddress))
			return;
		if($this->is_whitelisted($ipAddress))
			return;
		global $wpdb;
		$wpdb->insert( 
			$wpdb->prefix.Mo_LLA_Constants::WHITELISTED_IPS_TABLE, 
			array( 
				'ip_address' => $ipAddress, 
				'created_timestamp' => current_time( 'timestamp' )
			)
		);
	}
	
	function remove_whitelist_entry($entryid){
		global $wpdb;
		$wpdb->query( 
			"DELETE FROM ".$wpdb->prefix.Mo_LLA_Constants::WHITELISTED_IPS_TABLE."
			 WHERE id = ".$entryid
		);
	}
	
	function get_whitelisted_ips(){
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT id, ip_address, created_timestamp FROM ".$wpdb->prefix.Mo_LLA_Constants::WHITELISTED_IPS_TABLE );
		return $myrows;
	}
	
	function is_email_sent_to_user($username, $ipAddress){
		if(empty($ipAddress))
			return false;
		global $wpdb;
		$sent_count = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix.Mo_LLA_Constants::EMAIL_SENT_AUDIT." where ip_address = '".$ipAddress."' AND 
		username='".$username."'" );
		if($sent_count)
			$sent_count = intval($sent_count);
		if($sent_count>0)
			return true;
		return false;
	}
	
	function audit_email_notification_sent_to_user($username, $ipAddress, $reason){
		if(empty($ipAddress) || empty($username))
			return;
		global $wpdb;
		$wpdb->insert( 
			$wpdb->prefix.Mo_LLA_Constants::EMAIL_SENT_AUDIT, 
			array( 
				'ip_address' => $ipAddress,
				'username' => $username,
				'reason' => $reason,
				'created_timestamp' => current_time( 'timestamp' )
			)
		);
	}
	
	function add_transactions($ipAddress, $username, $type, $status){
		global $wpdb;
		$wpdb->insert( 
			$wpdb->prefix.Mo_LLA_Constants::USER_TRANSCATIONS_TABLE, 
			array( 
				'ip_address' => $ipAddress, 
				'username' => $username,
				'type' => $type,
				'status' => $status,
				'created_timestamp' => current_time( 'timestamp' )
			)
		);
	}
	
	function get_all_transactions(){
		global $wpdb;
		$myrows = $wpdb->get_results( "SELECT ip_address, username, type, status, created_timestamp FROM ".$wpdb->prefix.Mo_LLA_Constants::USER_TRANSCATIONS_TABLE." order by id desc limit 5000" );
		return $myrows;
	}
	
	function move_failed_transactions_to_past_failed($ipAddress){
		global $wpdb;
		$wpdb->query( 
			"UPDATE ".$wpdb->prefix.Mo_LLA_Constants::USER_TRANSCATIONS_TABLE." SET status='".Mo_LLA_Constants::PAST_FAILED."'
			WHERE ip_address = '".$ipAddress."' AND status='".Mo_LLA_Constants::FAILED."'"
		);
	}
	
	function remove_failed_transactions($ipAddress){
		global $wpdb;
		$wpdb->query( 
			"DELETE FROM ".$wpdb->prefix.Mo_LLA_Constants::USER_TRANSCATIONS_TABLE." 
			WHERE ip_address = '".$ipAddress."' AND status='".Mo_LLA_Constants::FAILED."'"
		);
	}
	
	function get_failed_attempts_count($ipAddress){
		global $wpdb;
		$user_count = $wpdb->get_var( "SELECT COUNT(*) FROM ".$wpdb->prefix.Mo_LLA_Constants::USER_TRANSCATIONS_TABLE." where ip_address = '".$ipAddress."'
		AND status = '".Mo_LLA_Constants::FAILED."'" );
		if($user_count){
			$user_count = intval($user_count);
			return $user_count;
		}
		return 0;
	}
	
	function sendIpBlockedNotification($ipAddress, $reason){
	}
	
	
	function sendNotificationToUserForUnusualActivities($username, $ipAddress, $reason){
	}
	
} ?>