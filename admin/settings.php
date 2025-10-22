<?php
/**
 * Admin Settings Page for Manzari Anti-Spam Shield (Checkbox-only)
 */

if (!defined('ABSPATH')) exit;

add_action('admin_init', function() {

    // ==============================
    // Keyword Blocking
    // ==============================
    register_setting('manzari_antispam_settings', 'manzari_bad_words', [
        'type' => 'string',
        'sanitize_callback' => 'sanitize_textarea_field',
        'default' => ''
    ]);

    add_settings_section(
        'manzari_antispam_main',
        'Keyword Blocking',
        function() {
            echo '<p>Enter comma-separated words or phrases that you want to automatically block in comments.</p>';
        },
        'manzari_antispam'
    );

    add_settings_field(
        'manzari_bad_words',
        'Blocked Words',
        function() {
            $value = get_option('manzari_bad_words', '');
            echo '<textarea name="manzari_bad_words" rows="5" cols="50" style="width:100%;">' . esc_textarea($value) . '</textarea>';
            echo '<p class="description">Example: viagra, casino, loan, buy now</p>';
        },
        'manzari_antispam',
        'manzari_antispam_main'
    );

    // ==============================
    // Google reCAPTCHA (v2 Checkbox)
    // ==============================
    register_setting('manzari_antispam_settings', 'manzari_enable_recaptcha');
    register_setting('manzari_antispam_settings', 'manzari_recaptcha_sitekey');
    register_setting('manzari_antispam_settings', 'manzari_recaptcha_secret');

    add_settings_section(
        'manzari_recaptcha_section',
        'Google reCAPTCHA (v2 Checkbox)',
        function() {
            echo '<p>Enable Google reCAPTCHA v2 ("I\'m not a robot" checkbox) to add an extra layer of protection on comment forms.</p>';
        },
        'manzari_antispam'
    );

    // Enable reCAPTCHA
    add_settings_field(
        'manzari_enable_recaptcha',
        'Enable reCAPTCHA',
        function() {
            $checked = checked(get_option('manzari_enable_recaptcha'), '1', false);
            echo '<input type="checkbox" name="manzari_enable_recaptcha" value="1" ' . $checked . ' />';
            echo '<p class="description">Check to enable Google reCAPTCHA v2 Checkbox on comment forms.</p>';
        },
        'manzari_antispam',
        'manzari_recaptcha_section'
    );

    // Site Key
    add_settings_field(
        'manzari_recaptcha_sitekey',
        'reCAPTCHA Site Key',
        function() {
            $value = get_option('manzari_recaptcha_sitekey', '');
            echo '<input type="text" name="manzari_recaptcha_sitekey" value="' . esc_attr($value) . '" style="width:100%;" />';
        },
        'manzari_antispam',
        'manzari_recaptcha_section'
    );

    // Secret Key
    add_settings_field(
        'manzari_recaptcha_secret',
        'reCAPTCHA Secret Key',
        function() {
            $value = get_option('manzari_recaptcha_secret', '');
            echo '<input type="text" name="manzari_recaptcha_secret" value="' . esc_attr($value) . '" style="width:100%;" />';
        },
        'manzari_antispam',
        'manzari_recaptcha_section'
    );
});

/**
 * Add menu item under "Settings"
 */
add_action('admin_menu', function() {
    add_options_page(
        'Manzari Anti-Spam Shield',
        'Anti-Spam Shield',
        'manage_options',
        'manzari-antispam',
        function() {
            ?>
            <div class="wrap">
                <h1>Manzari Anti-Spam Shield</h1>
                <form method="post" action="options.php">
                    <?php
                    settings_fields('manzari_antispam_settings');
                    do_settings_sections('manzari_antispam');
                    submit_button('Save Changes');
                    ?>
                </form>
            </div>
            <?php
        }
    );
});
