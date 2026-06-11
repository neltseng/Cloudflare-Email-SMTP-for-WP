<?php
/**
 * Cloudflare Email Service SMTP mailer for WordPress. See README for setup.
 * License: GPL-2.0-or-later
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class cw_cf_smtp_mailer {

	public static function init() {
		add_action( 'phpmailer_init', array( __CLASS__, 'phpmailer_init' ) );
		add_filter( 'wp_mail_from', array( __CLASS__, 'mail_from' ), 99 );
		add_filter( 'wp_mail_from_name', array( __CLASS__, 'mail_from_name' ), 99 );
	}

	public static function phpmailer_init( $phpmailer ) {
		if ( ! defined( 'CF_SMTP_TOKEN' ) || ! CF_SMTP_TOKEN ) {
			return;
		}
		$phpmailer->isSMTP();
		$phpmailer->Host       = 'smtp.mx.cloudflare.net';
		$phpmailer->Port       = 465;
		$phpmailer->SMTPSecure = 'ssl';
		$phpmailer->SMTPAuth   = true;
		$phpmailer->Username   = 'api_token';
		$phpmailer->Password   = CF_SMTP_TOKEN;
	}

	public static function mail_from( $from ) {
		return 'noreply@example.com';
	}

	public static function mail_from_name( $name ) {
		return $name ? $name : get_bloginfo( 'name' );
	}
}
cw_cf_smtp_mailer::init();
