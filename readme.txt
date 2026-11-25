=== Best Web Expert Gutenberg Widget ===
Requires at least: 6.5
Requires PHP: 8.0
Stable tag: 1.1.0
License: GPL-2.0-or-later

BestWebExpert's own Gutenberg blocks. Each block prints exactly the markup the site's CSS was written for, in the
editor and on the live page, so the editor looks like the site.

Self-contained since 1.1.0: the site design layer that used to be the BestWebExpert Home plugin lives in site/
(styles, GSAP motion scripts, render filters, blog templates, schema, redirects, GA4 events). It loads only when
BestWebExpert Home is NOT active; with Home active, Home keeps serving it (both would define the same functions).
Its CSS bundle (site/assets/home-2/bundle/) is rebuilt with: npm run site-bundle — run it after editing site CSS
(until then the changed side simply loads the individual files).

== Blocks ==

* FAQ question (bwe/faq-item) – numbered question + answer; numbers renumber themselves when questions move.
* Spec cards / Spec card (bwe/spec-list, bwe/spec-card) – name, short text, optional tag.
* Price list / Price row (bwe/price-list, bwe/price-row) – service + turnaround left, price + unit right.
* Who we build for / Who card (bwe/who-list, bwe/who-card) – linked audience cards.
* Numbered steps / Step (bwe/steps, bwe/step) – "how it works" steps; numbers follow the order.
* Section header (bwe/section-head) – eyebrow, heading (italic = lime highlight), optional intro.
* Hero, Services / Service tile, Section (bwe/hero, bwe/services, bwe/service-tile, bwe/section) – Home's sections,
  with a Styles tab (space, background, colours, heading, cards, buttons…).
* Platform cards / Platform card (bwe/platforms, bwe/platform-card) – Home's "WordPress & Shopify experts" cards:
  image, chip, linked title, text, service list (a normal List block), price, button and an optional badge.
  "+ Add a card (new pack)" adds a package; the grid's Styles tab styles every card, a card's own Styles tab
  ("This card") overrides it for that card only.
* Fixes & services / Price card (bwe/price-section, bwe/price-card) – the Pricing page's service prices: heading,
  then cards with chip, linked title, text, price rows (Price list), "from" price and button. Add, remove or move
  cards; Styles → Cards layout sets 2 or 3 cards per row (tablet and phone too). Two cards with no setting keep the
  site's own two-column look; any other number of cards, or a per-row setting, switches to equal columns with a
  line between the cards (includes/price-section.php). A card's own Styles tab ("This card") overrides its colours.
* Selected work / Project (bwe/work, bwe/work-item) – the Portfolio page's numbered project list: heading, then
  projects with screenshot, number (follows the order), title, tag and text, all linking to the project. On desktop
  a row shows its screenshot on hover and the others fade (BestWebExpert Home's work.css); the Styles tab sets rows,
  number, title, text, tag, arrow and screenshot looks, and can turn the fading, the preview or the tablet/phone
  thumbnails off. A project's own Styles tab ("This project") overrides its colours.
* Contact form section (bwe/contact-form) – eyebrow, heading and intro beside a Contact Form 7 form in its card;
  pick the form in the sidebar (the editor shows the real form). Styles: layout (widths, form on the left, sticky
  text), card, fields, choice buttons, send button. Its layout CSS needs the page class .bwe-wfu: the block adds
  its own .bwe-wfu wrapper ("scope", on by default; off on Contact / Write for Us, whose pages have it).
* About split (bwe/about) – text (eyebrow, heading, lead, more paragraphs) beside a card (title, checklist = a
  normal List block, button). Styles: layout (widths, card on the left, card height), lead, more text, card,
  checklist, button.

Pages built straight from these blocks (no synced patterns) give Rank Math the blocks' text too (reading time,
og:image), as BestWebExpert Home already did for pattern pages (includes/content-readers.php).

General-purpose blocks (2026-11-24) — build any section from these instead of new one-off widgets:

* Buttons (bwe/buttons) – 1–6 buttons: lime, outline, dark, light (on dark backgrounds) or text link; new tab and
  nofollow / sponsored / ugc per button; alignment on desktop, tablet and phone; stack or full width on phones.
* Image / screenshot (bwe/media) – media-library image with srcset, width/height, alt text (falls back to the media
  library's) and lazy loading, or "Above the fold" (eager + fetchpriority high); frame plain / rounded / screenshot /
  browser window; shape (16:9, 1:1, 9:16 …) per device; caption; link.
* Grid / columns (bwe/grid) – any blocks side by side: 1–6 columns with their own count on tablet and phone, 2-column
  ratios (2:1, 3:2 …), vertical alignment, reverse order on phones, items as white / soft / dark / outlined cards.
* Gap / divider (bwe/gap) – space with its own height per device, optional line (colour, thickness, length, style).
* Section (bwe/section) ready layouts in the inserter: Long text (legal), Showcase, Showcase beside text, Text + image,
  Big screenshot, Demo bar, Guide with contents, Screenshot tour — each starts with the structure the site's CSS
  and scripts already style. Section also has an HTML tag setting and tablet spacing.
* Hero: kicker line above the heading, buttons in a new tab, numbered jump links.

Items per row (2026-11-24, src/blocks/shared/row-controls.js): blocks that hold a row of items — Price plans, Services,
Platform cards, Products, Testimonials, How it works / Steps, Why us / Spec cards, Who list, Starting prices, Cost
panel, Fixes & services — have an "Items per row" panel in the Settings sidebar: Desktop / Tablet / Phone (site
default or 1–6), "All on one row" on desktop (every item side by side while each stays at least 200px wide; more
wrap instead of overflowing) and "+ Add item" (adds the item with its starter text). Selecting the Pricing section
shows the panel for its plans. It stores the blocks' own style keys (columns, columnsTablet, columnsMobile, oneRow),
so the Styles tab no longer lists them. With a row setting, item buttons may wrap to two lines instead of sticking
out of narrower cards. Keys added by tools/add-row-keys.mjs and tools/add-row-button-wrap.mjs (one-off, idempotent).

Every block also has (includes/global-controls.php, src/blocks/shared/global-controls.js):
* Visibility – hide on desktop (1025px+), tablet (782–1024px) or phone (781px and less); faded in the editor.
* Heading tag (SEO) – blocks with a main heading print it as h1–h6, p or div; the look stays (headings the site styles
  by tag are covered by assets/css/heading-compat.css, generated by tools/build-heading-compat.mjs).
assets/css/blocks.css (and heading-compat.css) load only on pages that use these blocks or settings.

Translation: every editor text uses __() with the text domain "bestwebexpert" (Styles-tab labels too:
src/blocks/shared/style-labels.js is generated from the block.json files by tools/build-labels.mjs), starter content
is translatable, and translations are read from languages/ first, then wp-content/languages/plugins/.
Make the template with: wp i18n make-pot . languages/bestwebexpert.pot  (then wp i18n make-json for the editor).

Icons: Service tile, Step and Section (eyebrow) have an Icon panel — keep the site's icon, pick one of 2,100
Lucide icons (ISC licence, build/icons/), upload/choose an image, paste SVG code, or show no icon.

Styles and icons are only shown where the block itself is edited: inside a synced pattern on a page, WordPress
shows content only — use "Edit original" on the pattern to reach the Styles tab.

All blocks are dynamic (PHP renders them), so changing a block's design never breaks saved content.

== Development ==

From this folder:

* npm install --include=dev   (this machine sets NODE_ENV=production, which would skip the build tools)
* npm run start               watch mode: rebuilds build/ on every save (development build)
* npm run build               production build (+ build/icons/lucide.json, style-labels.js, heading-compat.css) — run
                              this before uploading the plugin
* npm run audit               every Styles-tab setting on the live Home page: does it visibly change anything?
* npm test                    PHP tests (tools/tests)
* npm run verify              build + tests + live HTML of 31 pages vs. the baseline + editor check of all pages
* npm run editor -- 1104 b1347   editor check of chosen pages (bNNN = synced pattern NNN)
* node tools/editor-check.mjs --cookies <file> --scenario controls --timeout 1400 1104
                              the same control audit inside the editor (scenarios: controls, icons, page-ui, platforms)
* npm run plugin-zip          zip for upload (contains only the plugin files and build/, no node_modules)

Source: src/blocks/<name>/ (block.json, index.js / edit.js, render.php). Output: build/blocks/<name>/.

Build layout (2026-11-24, faster editor and site):
* One editor bundle for all blocks: src/editor.js -> build/blocks/editor/index.js (script handle "bwe-gw-editor",
  registered in includes/blocks.php; every block.json says "editorScript": "bwe-gw-editor"). A new block folder with an
  index.js is picked up automatically. Before: 39 bundles, ~1.1 MB, shared code copied into each; now ~320 KB.
* build/blocks-manifest.php (wp-scripts build-blocks-manifest): blocks register from it in one go and the Styles-tab
  style maps are read from it, instead of decoding every block.json on each request.
* Starter content (inserter variations) is only built for editor / REST / AJAX requests, and once per request.
Tools (CLI only): tools/ — converters, snapshot/compare, editor check, tests.

== Deploying ==

Upload this plugin (with build/, without node_modules) BEFORE moving the database: pages saved with these blocks show
"unsupported block" on a site where this plugin is not active.
