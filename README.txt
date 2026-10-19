Version 1.1.0 – Updated to mockup gold color scheme (warm gold + clean white) with light/dark mode support.

PASTOR ADEWALE THEME 1.0
Built by Adeyemo Samuel / SamDlight
Requires WordPress 6.3+, PHP 7.4+. No page builder and no extra plugins needed.

------------------------------------------------------------
1. INSTALL (5 minutes)
------------------------------------------------------------
1. Appearance > Themes > Add New > Upload Theme > choose "Pastor Adewale 1.0.zip" > Install > Activate.
2. On first activation the theme creates the pages (Start Here, Resources, About, Donate, Contact,
   Request Prayer, Ask a Bible Question, Share Your Story, Free eBook, Connect, Pray For Us, FAQs),
   the five menus, and sets the static front page. Existing pages are never overwritten.
   You can run this again any time: Settings > Ministry Settings > Tools.
3. Settings > General: set Site Title (Pastor Adewale Oluranti) and Tagline.
4. Settings > Permalinks: choose "Post name" and Save (also fixes any 404s on new content types).
5. Settings > Ministry Settings: add the pastor photo, contact email, phone, address, social links,
   bank details and Paystack keys (see section 4).
6. To preview the design with example content: Ministry Settings > Tools > "Load sample content".
   BEFORE LAUNCH: Tools > "Remove sample content" (deletes only what the sample loader created).

------------------------------------------------------------
2. ADD CONTENT
------------------------------------------------------------
TEACHINGS  (Teachings > Add New)
 - Title, short summary in Excerpt, longer notes in the editor.
 - "Teaching details" box: paste the YouTube link, duration, and the lesson number in the series.
 - Right sidebar: pick a Series, Topic and Speaker. Featured image is optional (used as thumbnail).
 - The publish date's year is used for the Year filter.
SERIES  (Teachings > Series)
 - Name and description. Add the study-notes PDF link and the free eBook PDF link on the series
   (upload PDFs in Media, then paste the file link). They appear on the series page and player.
 - Lessons are ordered by the lesson number you set on each teaching.
BOOKS & DOWNLOADS  (Books & Downloads > Add New): add the PDF link and a label such as "PDF · 18 pages".
BIBLE SCHOOL  (Bible School > Add New): course name, summary, size label, optional start link.
TESTIMONIES  (Testimonies): visitor stories arrive here as PENDING. Review, edit, then Publish.
ANSWERED QUESTIONS  (Answered Questions): the public Q&A shown on the Ask a Bible Question page.
OUTREACH STORIES  (Outreach Stories): shown on the Outreaches page.
HOME SLIDES  (Home Slides): the rotating hero. Title = headline, Excerpt = paragraph, plus the line
 above the title, button text and link. Tick "Show the pastor photo" on the portrait slide. Use
 Page Attributes > Order to set the sequence. With no slides, sensible defaults are shown.
NEWS: ordinary Posts, shown on the News page.
FAQs, Connect, Pray For Us, About, Outreaches: edit these as normal pages. For FAQs use the "Details" block.

------------------------------------------------------------
3. FORMS AND THE INBOX
------------------------------------------------------------
Contact, prayer, question and newsletter forms are saved in Inbox (admin sidebar) and emailed to the
notification email. "Share Your Story" creates a Pending testimony. Forms have a nonce, a hidden
honeypot, a minimum-time check and a 5-per-hour limit per visitor.
Export: Settings > Ministry Settings > Tools > Export (CSV) for subscribers, donations or everything.
IMPORTANT: many hosts block PHP mail. Install a free SMTP plugin (for example WP Mail SMTP) so the
notification emails are reliably delivered.

------------------------------------------------------------
4. GIVING WITH PAYSTACK
------------------------------------------------------------
1. Paystack dashboard > Settings > API Keys. Copy the public key and the secret key.
2. Ministry Settings > Giving: paste the public key. Safer for the secret key: add this line to
   wp-config.php instead of using the settings box:
       define( 'PA_PAYSTACK_SECRET', 'sk_live_xxxxxxxx' );
3. Test first with pk_test_ / sk_test_ keys and a Paystack test card, then switch to live keys.
4. Each payment is confirmed server-side with Paystack before it is recorded (Inbox > type Donation).
   The amount is read from Paystack's reply, not from the browser.
5. Edit "Gift amounts" (one per line: amount|what it does) so the impact statements match real costs.
Not included in v1: monthly recurring gifts (needs Paystack Plans) and a Paystack webhook.

------------------------------------------------------------
5. SEO AND SPEED
------------------------------------------------------------
 - The theme outputs unique titles, meta descriptions, Open Graph tags and structured data
   (Person and WebSite on the home page, VideoObject on a teaching with a YouTube video, Article on news).
 - If you install Yoast, Rank Math, AIOSEO or SEOPress, the theme's meta tags switch off automatically.
 - Settings > Reading > "Discourage search engines" must be UNTICKED at launch.
 - Fonts load from Google Fonts. For best privacy and speed, self-host Inter later.
 - Add a caching plugin and keep uploaded images under about 300 KB.
 - Language switching needs a plugin such as Polylang. The header shows its switcher when active.

------------------------------------------------------------
6. FILE MAP
------------------------------------------------------------
style.css               all styling (theme header at the top)
functions.php, inc/     setup, content types, meta boxes, settings, forms, Paystack, SEO, starter content
front-page.php          home page          templates/   page templates (start, resources, donate, forms...)
archive-teaching.php    teaching library   single-teaching.php  player      taxonomy-series.php  series page
assets/js/main.js       menu, carousel, search, focus mode, giving
