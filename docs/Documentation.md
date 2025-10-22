# 🧩 Manzari Anti-Spam Shield – Full Documentation

**Version:** 1.4 (Checkbox Edition)  
**Author:** Manzari Web Applications  
**Last Updated:** October 2025  

---

## 🏁 Introduction

**Manzari Anti-Spam Shield** is a lightweight, performance-oriented WordPress plugin that silently protects your comment forms from spam bots and automated submissions — without cluttering your database or slowing your site.

Designed with developers and everyday users in mind, it provides several layers of protection:
- 🧠 **Honeypot field** – invisible trap for automated spam bots.  
- ⏱️ **Timing detection** – blocks comments submitted unrealistically fast (<5 seconds).  
- 🔤 **Keyword filtering** – instantly rejects comments containing banned phrases.  
- 🔒 **Google reCAPTCHA v2 Checkbox** – adds the trusted “I’m not a robot” verification.  
- 📊 **Dashboard Widget** – tracks and displays the total spam attempts blocked.

All of this is achieved using clean, efficient code — no unnecessary assets, no intrusive ads, and no performance overhead.

---

## ⚙️ How It Works

Whenever a visitor submits a comment, **Manzari Anti-Spam Shield** runs several checks before WordPress accepts the submission.

1. **Honeypot Field**
   - A hidden field is added to every comment form.  
   - Real users never fill this out — but bots usually do.  
   - If it’s filled, the submission is flagged as spam and blocked.

2. **Timing Check**
   - When a comment form loads, the plugin records a timestamp.  
   - If the user submits too quickly (under 5 seconds), it’s considered automated.  
   - This eliminates “instant-submit” bot activity.

3. **Keyword Filter**
   - Admins can specify banned keywords (like “viagra”, “casino”, “loan”).  
   - Comments containing any of those are rejected with a message to the user.

4. **Google reCAPTCHA v2 Checkbox**
   - Adds an extra layer of verification for bots that can bypass the above.  
   - Users must check the “I’m not a robot” box before submitting their comment.  
   - Verification happens server-side for accuracy and security.

If any of these checks fail, the comment is blocked, logged (in `debug.log` if enabled), and the spam counter increases.

---

## 🚀 Installation & Activation

### Option 1: Manual Upload
1. Download or zip the plugin folder `manzari-anti-spam-shield`.  
2. Upload it to your WordPress installation under:  
   `/wp-content/plugins/`  
3. Log in to WordPress and navigate to **Plugins → Installed Plugins**.  
4. Find **Manzari Anti-Spam Shield** and click **Activate**.

### Option 2: WordPress Dashboard Upload
1. Go to **Plugins → Add New → Upload Plugin**.  
2. Upload the ZIP file and click **Install Now**.  
3. Once installed, click **Activate Plugin**.

After activation, the plugin immediately begins protecting your comment forms.  
You can configure additional options in the settings panel.

---

## 🔧 Plugin Configuration

### Accessing the Settings Page
- Go to **Dashboard → Settings → Anti-Spam Shield**

You’ll see two main sections:

#### 🧠 Keyword Blocking
- Enter comma-separated words or phrases that you want to block.  
- The check is **case-insensitive**.  
- Example:  loan, casino, viagra, click here, buy now


#### 🔒 Google reCAPTCHA (v2 Checkbox)
- Check **Enable reCAPTCHA** to turn on the “I’m not a robot” verification box.  
- Paste your **Site Key** and **Secret Key** from the [Google reCAPTCHA admin console](https://www.google.com/recaptcha/admin/create).  
- Be sure to select **reCAPTCHA v2 → “I’m not a robot” Checkbox** when generating keys.

Once saved, reCAPTCHA automatically appears on your comment forms.

---

## 🧩 Integration Details

**Manzari Anti-Spam Shield** integrates natively with the default WordPress comment form.  
It does not modify themes or templates — all integrations are handled using WordPress hooks.

| Hook | Purpose |
|------|----------|
| `comment_form` | Injects honeypot field, timestamp, and optional reCAPTCHA markup. |
| `preprocess_comment` | Validates incoming comment data before it’s stored in the database. |
| `wp_dashboard_setup` | Registers the admin dashboard widget. |
| `init` | Outputs debug log message during plugin load (if WP_DEBUG is enabled). |

If you use a custom form plugin, you may need to manually integrate reCAPTCHA by adding the shortcode `<div class="g-recaptcha">` to your form template.

---

## 📊 Viewing the Dashboard Widget

Once the plugin is activated, it automatically adds a new widget to your WordPress admin dashboard.

### 🧭 Location
1. Log in to your WordPress admin panel (e.g., `https://yourdomain.com/wp-admin`).  
2. Go to **Dashboard → Home**.  
3. Scroll down until you find a widget titled: 🛡️ Manzari Anti-Spam Shield

This widget displays:
[number] spam attempts blocked since activation.
Protection active on comment forms.


### ⚙️ If You Don’t See It
- Click the **Screen Options** tab in the upper-right corner of your dashboard.  
- Ensure **“Manzari Anti-Spam Shield”** is checked.  
- Refresh the page after the first spam attempt is blocked.

### 💡 Notes
- The counter value is stored in your database as `manzari_spam_blocked_total`.  
- It increments each time a honeypot, timing, keyword, or reCAPTCHA check blocks spam.  
- The widget is visible only to administrators with dashboard access.

---

## 🧹 Clean Uninstall

**Manzari Anti-Spam Shield** is designed for **100% clean removal.**  
When deleted via **Plugins → Delete**, it performs a full cleanup by removing the following:

| Option Name | Description |
|--------------|-------------|
| `manzari_enable_recaptcha` | Whether reCAPTCHA is active |
| `manzari_recaptcha_sitekey` | Your Google site key |
| `manzari_recaptcha_secret` | Your Google secret key |
| `manzari_bad_words` | Custom blocked keyword list |
| `manzari_spam_blocked_total` | Total spam counter |

No orphaned data or unused tables remain in your database — ensuring a clean uninstall every time.

---

## 🧠 Developer Notes

### Internal Function Reference

| Function | Description |
|-----------|-------------|
| `manzari_antispam_increment_counter()` | Increments the total spam-block counter. |
| `get_option( 'manzari_bad_words' )` | Retrieves the saved keyword blacklist. |
| `get_option( 'manzari_enable_recaptcha' )` | Checks if reCAPTCHA is enabled. |

### Debug Logging
If `WP_DEBUG` is enabled in `wp-config.php`, all spam-blocking events will be written to your `/wp-content/debug.log` file, including:
- Honeypot triggers
- Timing violations
- Keyword matches
- reCAPTCHA failures

---

## 🧱 Compatibility

✅ Fully compatible with:
- WordPress 5.0 and later  
- PHP 7.4 – 8.3  
- Default WordPress Comment Form  
- Most modern themes (Astra, OceanWP, GeneratePress, Twenty Twenty-Four, etc.)

⚠️ May require custom integration for:
- AJAX-based forms or custom-built comment systems.  

---

## 🧠 Troubleshooting

**reCAPTCHA isn’t showing?**
- Ensure the plugin’s “Enable reCAPTCHA” checkbox is turned on.  
- Confirm you’re using **v2 Checkbox** keys (not v3).  
- Clear cache if you’re using a caching plugin.

**All comments are being blocked?**
- Ensure your server’s time is accurate — the timing filter depends on PHP’s `time()` function.  
- Check if the honeypot field or timing field is being removed by your theme.

**Counter not updating?**
- The counter only increases when a spam event is detected.  
- Try submitting a comment with a banned keyword to test it.

**Debugging logs**
- Enable `WP_DEBUG` in your `wp-config.php` file:  
  ```php
  define('WP_DEBUG', true);
  define('WP_DEBUG_LOG', true);

📬 Support & Contact

Created by:
Manzari Web Applications

📧 support@manzari.com
🌐 https://manzari.com

⚖️ License

This plugin is licensed under the GNU General Public License v2 or later.
You are free to modify and redistribute it with attribution.

🏁 Summary

Manzari Anti-Spam Shield is built for creators who value performance, simplicity, and transparency.
It works silently in the background — keeping your comment sections clean while leaving your WordPress installation fast and clutter-free.

Lightweight protection with Manzari reliability.

