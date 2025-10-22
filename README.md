# 🛡️ Manzari Anti-Spam Shield

**Version:** 1.4  
**Author:** Manzari Web Applications  
**License:** GPL2+  
**Requires WordPress:** 5.0 or higher  
**Tested up to:** 6.7  

---

### 💡 Overview

**Manzari Anti-Spam Shield** is a lightweight, privacy-friendly plugin that protects your WordPress comments from bots — without slowing your site down.

It combines multiple layers of intelligent defense:
- 🧠 **Honeypot trap** – silently detects spam bots that fill hidden fields.  
- ⏱️ **Timing check** – blocks suspiciously fast form submissions (<5 seconds).  
- 🔤 **Keyword filter** – rejects comments containing blacklisted words.  
- 🔒 **Google reCAPTCHA v2 Checkbox** – stops automated spam submissions.  
- 📊 **Dashboard widget** – shows the total number of blocked spam attempts.

No trackers. No bloat. Just a clean, focused layer of protection.

---

### 🚀 Installation

1. Upload the folder `manzari-anti-spam-shield` to `/wp-content/plugins/`.
2. In your WordPress admin panel, go to **Plugins → Installed Plugins**.
3. Click **Activate** under *Manzari Anti-Spam Shield*.
4. Go to **Settings → Anti-Spam Shield** to configure your preferences:
   - Enable Google reCAPTCHA (optional)
   - Enter your **Site Key** and **Secret Key**
   - Add comma-separated banned words or phrases

That’s it — the plugin immediately begins protecting your comment forms.

---

### ⚙️ Features

| Feature | Description |
|----------|--------------|
| 🧠 Honeypot Field | Stops bots by adding a hidden trap field. |
| ⏱️ Timing Check | Blocks comments posted too quickly (<5s). |
| 🔤 Keyword Filter | Rejects messages containing specific words. |
| 🔒 Google reCAPTCHA v2 | Adds “I’m not a robot” checkbox protection. |
| 📊 Dashboard Widget | Displays total spam attempts blocked. |
| 🧹 Clean Uninstall | Removes all plugin data and settings upon deletion. |

---

### 🧰 Settings

**Navigation Path:**  
➡️ WordPress Dashboard → **Settings → Anti-Spam Shield**

**Available Options:**
- ✅ Enable reCAPTCHA checkbox  
- 🔑 reCAPTCHA Site Key  
- 🔑 reCAPTCHA Secret Key  
- 🚫 Blocked Words (comma-separated list)

---

### 📊 Dashboard Widget

You’ll find a “🛡️ Manzari Anti-Spam Shield” widget in your **WordPress Dashboard**.  
It shows the total number of spam attempts blocked since activation.

---

### 🧹 Uninstall Cleanup

When you delete the plugin from WordPress, it performs a **clean uninstall**:  
- All options (keys, settings, counters) are removed automatically.  
- No database clutter is left behind.

---

### 🧩 Changelog

**v1.4 (Current)**
- Simplified plugin to Google reCAPTCHA v2 Checkbox only.  
- Improved keyword and timing filters.  
- Added clean uninstall and spam counter.  
- Optimized performance and removed unnecessary code.  

**v1.3.2**
- Experimental Invisible reCAPTCHA mode (now deprecated).  

**v1.2**
- Added keyword filter and honeypot detection.  

---

### 💬 Support

**Created by:**  
Manzari Web Applications  

**Contact:**  
📧 support@manzari.com  
🌐 [https://manzari.com](https://manzari.com)

---

### ⚖️ License
This plugin is licensed under the **GPL2+** license.  
Copyright © 2025 Manzari Web Applications.
