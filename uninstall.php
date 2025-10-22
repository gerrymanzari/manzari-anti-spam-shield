<?php
/**
 * Uninstall script for Manzari Anti-Spam Shield
 *
 * Cleans up all plugin options from the database when deleted.
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    exit;
}

// Delete all stored options
delete_option('manzari_bad_words');
delete_option('manzari_enable_recaptcha');
delete_option('manzari_recaptcha_type');
delete_option('manzari_recaptcha_sitekey');
delete_option('manzari_recaptcha_secret');
delete_option('manzari_spam_blocked_total');
delete_option('manzari_email_alerts'); // reserved for future use
