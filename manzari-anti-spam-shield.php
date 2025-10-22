<?php
/**
 * Plugin Name: Manzari Anti-Spam Shield
 * Description: Lightweight honeypot, timing, keyword, and Google reCAPTCHA v2 Checkbox protection for WordPress comments. Blocks bots silently while keeping UX clean.
 * Version: 1.4
 * Author: Manzari Web Applications
 * License: GPL2+
 */

defined('ABSPATH') || exit;

/**
 * Add hidden honeypot, timestamp, and reCAPTCHA checkbox to comment form
 */
add_action('comment_form', function () {
    // Honeypot field
    echo '<p class="manzari-anti-spam" style="display:none !important;">
            <label for="extra_field">Leave this empty</label>
            <input type="text" name="extra_field" id="extra_field" value="" tabindex="-1" autocomplete="off" />
          </p>';

    // Timestamp field
    echo '<input type="hidden" name="manzari_form_time" value="' . time() . '" />';

    // reCAPTCHA checkbox
    $enabled = get_option('manzari_enable_recaptcha', false);
    $sitekey = get_option('manzari_recaptcha_sitekey', '');
    if ($enabled && $sitekey) {
        echo '<div class="g-recaptcha" data-sitekey="' . esc_attr($sitekey) . '"></div>';
        echo '<script src="https://www.google.com/recaptcha/api.js" async defer></script>';
    }
});

/**
 * Validate comment before WordPress saves it
 */
add_filter('preprocess_comment', function ($data) {

    // Step 1: reCAPTCHA verification
    $enabled = get_option('manzari_enable_recaptcha', false);
    $secret  = get_option('manzari_recaptcha_secret', '');

    if ($enabled && $secret) {
        $response = isset($_POST['g-recaptcha-response']) ? sanitize_text_field($_POST['g-recaptcha-response']) : '';
        if (empty($response)) {
            manzari_antispam_increment_counter();
            wp_die(__('Please complete the reCAPTCHA verification.', 'manzari-anti-spam-shield'), 'Captcha Required', ['response' => 403]);
        }

        $verify = wp_remote_post('https://www.google.com/recaptcha/api/siteverify', [
            'body' => [
                'secret'   => $secret,
                'response' => $response,
                'remoteip' => $_SERVER['REMOTE_ADDR'],
            ],
        ]);

        if (is_wp_error($verify)) {
            manzari_antispam_increment_counter();
            wp_die(__('Could not contact reCAPTCHA server.', 'manzari-anti-spam-shield'), 'Captcha Error', ['response' => 403]);
        }

        $result = json_decode(wp_remote_retrieve_body($verify));
        if (empty($result->success)) {
            manzari_antispam_increment_counter();
            wp_die(__('Failed reCAPTCHA verification.', 'manzari-anti-spam-shield'), 'Spam Blocked', ['response' => 403]);
        }
    }

    // Step 2: Honeypot
    if (!empty($_POST['extra_field'])) {
        if (defined('WP_DEBUG') && WP_DEBUG)
            error_log('Manzari Anti-Spam: Honeypot triggered from IP ' . $_SERVER['REMOTE_ADDR']);
        manzari_antispam_increment_counter();
        wp_die(__('Spam detected (honeypot filled).', 'manzari-anti-spam-shield'), 'Spam Blocked', ['response' => 403]);
    }

    // Step 3: Timing
    $submitted = intval($_POST['manzari_form_time'] ?? 0);
    $elapsed = time() - $submitted;
    if ($submitted === 0 || $elapsed < 5) {
        if (defined('WP_DEBUG') && WP_DEBUG)
            error_log('Manzari Anti-Spam: Too fast submission (' . $elapsed . 's) from IP ' . $_SERVER['REMOTE_ADDR']);
        manzari_antispam_increment_counter();
        wp_die(sprintf(__('Spam detected (submitted too quickly: %d s).', 'manzari-anti-spam-shield'), $elapsed),
            'Spam Blocked', ['response' => 403]);
    }

    // Step 4: Keyword filter
    $badwords = get_option('manzari_bad_words', '');
    if ($badwords) {
        $phrases = array_filter(array_map('trim', explode(',', strtolower($badwords))));
        $text = strtolower($data['comment_content']);
        foreach ($phrases as $p) {
            if ($p && strpos($text, $p) !== false) {
                if (defined('WP_DEBUG') && WP_DEBUG)
                    error_log('Manzari Anti-Spam: Blocked word "' . $p . '" from IP ' . $_SERVER['REMOTE_ADDR']);
                manzari_antispam_increment_counter();
                wp_die(__('Comment blocked: contains restricted terms.', 'manzari-anti-spam-shield'),
                    'Spam Blocked', ['response' => 403]);
            }
        }
    }

    return $data;
}, 1);

/**
 * Increment spam counter
 */
function manzari_antispam_increment_counter() {
    update_option('manzari_spam_blocked_total',
        (int)get_option('manzari_spam_blocked_total', 0) + 1);
}

/**
 * Dashboard widget
 */
add_action('wp_dashboard_setup', function() {
    wp_add_dashboard_widget('manzari_antispam_widget', '🛡️ Manzari Anti-Spam Shield', function() {
        $count = (int)get_option('manzari_spam_blocked_total', 0);
        echo '<p style="font-size:16px;"><strong>' . $count . '</strong> spam attempts blocked since activation.</p>
              <p style="color:#777;">Protection active on comment forms.</p>';
    });
});

/**
 * Dev log message
 */
add_action('init', function () {
    if (defined('WP_DEBUG') && WP_DEBUG)
        error_log('Manzari Anti-Spam Shield v1.4 (Checkbox Only) initialized.');
});

/**
 * Include admin settings page
 */
if (is_admin())
    require_once plugin_dir_path(__FILE__) . 'admin/settings.php';
