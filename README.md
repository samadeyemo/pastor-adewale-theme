# Pastor Adewale – Custom WordPress Theme

A complete custom WordPress theme for **Pastor Adewale Oluranti Ministry**.

Built for Bible teaching, series, books & downloads, Bible School, testimonies, prayer requests, questions, and Paystack giving — without needing a page builder.

**Version:** 1.0.0  
**Author:** Adeyemo Samuel / SamDlight  
**Requires:** WordPress 6.3+, PHP 7.4+

---

## Features

- **Teachings** – Video (YouTube/Vimeo) + Audio player with focus mode
- **Series** – Group teachings into ordered series
- **Books & Downloads** – Resources library
- **Bible School** – Courses
- **Testimonies**
- **Forms** – Prayer request, Ask a Bible Question, Share Your Story
- **Paystack Giving** – Secure online donations
- **Dark / Light mode**
- **Built-in SEO** (titles, meta, Open Graph, schema)
- **Ministry Settings** page in WordPress admin
- Multiple page templates (Start Here, Donate, Prayer, Question, Outreaches, etc.)

---

## Installation

1. Download or clone this repository.
2. Upload the `pastor-adewale` folder to `/wp-content/themes/`.
3. In WordPress admin go to **Appearance → Themes** and activate **Pastor Adewale**.
4. Go to **Settings → Permalinks** and click **Save Changes**.

### After activation

1. Create the important pages (Home, About, Contact, Donate, etc.) and assign the matching page templates where needed.
2. Go to **Settings → Reading** and set a static homepage.
3. Create a menu under **Appearance → Menus** and assign it to the Primary location.
4. Configure **Ministry Settings** (giving keys, contact emails, etc.).
5. Start adding content:
   - **Teachings → Add New**
   - Fill the teaching details (video URL, audio, duration, scripture, PDF)

---

## Recommended Setup

- Install a free SMTP plugin (e.g. WP Mail SMTP) so form notification emails work reliably.
- Add a caching plugin (LiteSpeed Cache, WP Super Cache, or Cloudflare).
- Keep uploaded images under ~300 KB.
- For Paystack: use test keys first, then switch to live keys. Prefer storing the secret key in `wp-config.php`:

```php
define( 'PA_PAYSTACK_SECRET', 'sk_live_xxxxxxxx' );
```

---

## Folder Structure

```
pastor-adewale/
├── style.css                 # All styles + theme header
├── functions.php             # Main theme bootstrap
├── header.php / footer.php
├── front-page.php
├── single-teaching.php
├── archive-*.php
├── screenshot.png
├── assets/
│   ├── images/pastor.jpg
│   └── js/main.js
├── inc/
│   ├── post-types.php
│   ├── meta-boxes.php
│   ├── forms.php
│   ├── paystack.php
│   ├── seo.php
│   ├── settings.php
│   ├── helpers.php
│   └── setup.php
├── template-parts/
├── templates/                # Page templates
└── README.md
```

---

## Development

Open the folder in **VS Code**.

Useful extensions:
- PHP Intelephense
- WordPress Snippets
- Prettier / ESLint (optional)

To push changes to GitHub, see the instructions below or in the project wiki.

---

## License

GNU General Public License v2 or later

---

Built for Pastor Adewale Oluranti Ministry.
