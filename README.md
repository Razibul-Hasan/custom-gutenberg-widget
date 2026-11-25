# Best Web Expert Gutenberg Widget

Custom Gutenberg blocks for the BestWebExpert site. Each block prints exactly the markup the site's CSS was written
for, both in the editor and on the live page, so what you see while editing is what visitors get.

All blocks are **dynamic** (rendered in PHP by `render.php`), so changing a block's design never breaks saved content.

| | |
|---|---|
| Requires WordPress | 6.5+ |
| Requires PHP | 8.0+ |
| Requires plugin | None. The plugin is self-contained |
| Text domain | `bestwebexpert` |
| License | GPL-2.0-or-later |

## Installation

**From a release zip** (recommended for live sites): run `npm run plugin-zip`, then upload
`bestwebexpert-gutenberg-widget.zip` under *Plugins → Add New → Upload Plugin*.

**From git:** the compiled `build/` folder is committed, so a clone works as soon as it's in place:

```bash
cd wp-content/plugins
git clone https://github.com/Razibul-Hasan/custom-gutenberg-widget.git bestwebexpert-gutenberg-widget
```

Then activate **Best Web Expert Gutenberg Widget**. No other plugin is needed.

### Site design layer (`site/`)

The styles and scripts the blocks' markup was written for ship inside the plugin, in `site/`. They used to live in a
separate plugin, BestWebExpert Home. This covers the design CSS and its bundle, the GSAP motion scripts, the render
filters for buttons, images, the hero and video testimonials, the blog templates, Rank Math schema (FAQPage, Service,
SoftwareApplication), redirects and GA4 event tracking. Front-end assets load only on pages that use them.

- `site/` loads only when **BestWebExpert Home is not active**. If Home is still active, Home serves all of this
  itself, because loading both would define the same functions twice. Deactivating or deleting Home switches the
  plugin's own copy on, and the site looks exactly the same.
- After editing CSS in `site/assets/`, rebuild the one-file bundle with `npm run site-bundle`. Until you do, pages
  still look right but load the individual stylesheets.

> **Deploying to another site:** install and activate this plugin **before** you move the database. Pages saved with
> these blocks show "unsupported block" on a site where the plugin isn't active.

## Blocks

All blocks live in the `bwe/` namespace. Nested blocks (marked ↳) can only be inserted inside their parent.

### Page sections

| Block | Name | What it is |
|---|---|---|
| Hero | `bwe/hero` | Big dark hero: kicker, heading (italic = highlight), text, buttons, jump links, scroll cue |
| Section | `bwe/section` | White / Soft / Dark section, plus ready layouts in the inserter (long text, showcase, text + image, big screenshot, demo bar, guide with contents, screenshot tour) |
| Section header | `bwe/section-head` | Eyebrow, heading (italic = lime highlight), optional intro |
| Services | `bwe/services` | Services band with a grid of linked tiles<br>↳ Service tile `bwe/service-tile` |
| Why us | `bwe/why-us` | Label, heading, intro and feature cards |
| Feature cards | `bwe/spec-list` | Grid of feature cards<br>↳ Feature card `bwe/spec-card` |
| Who we build for | `bwe/who-list` | Linked audience cards<br>↳ Audience card `bwe/who-card` |
| Platform cards | `bwe/platforms` | Platform / package cards with image, chip, service list, price, button, badge<br>↳ Platform card `bwe/platform-card` |
| Our products | `bwe/products` | Product cards with animated mockups or your own image<br>↳ Product card `bwe/product-card` |
| Plugin mockup | `bwe/product-mockup` | The animated plugin mockups (reels, boxes, lift) on their own |
| How it works | `bwe/process` | Heading and numbered steps |
| Numbered steps | `bwe/steps` | Steps with big outlined numbers<br>↳ Step `bwe/step` (also used in *How it works* and *Guide*) |
| Guide / checklist | `bwe/guide` | Numbered guide or checklist with step cards |
| Selected work | `bwe/work` | Portfolio list with hover screenshot previews<br>↳ Project `bwe/work-item` |
| Testimonials | `bwe/testimonials` | YouTube / Shorts video testimonials with click-to-play thumbnails<br>↳ Video testimonial `bwe/video-card` |
| About (text + card) | `bwe/about` | Text beside a card with title, checklist and button |
| FAQ | `bwe/faq` | Heading + "ask a question" button beside numbered questions<br>↳ FAQ question `bwe/faq-item` |
| Contact form section | `bwe/contact-form` | Intro text beside a Contact Form 7 form (pick the form in the sidebar) |
| Call to action | `bwe/cta` | The dark closing box: label, heading, text, two buttons, live-chat line |

### Pricing

| Block | Name | What it is |
|---|---|---|
| Pricing | `bwe/pricing` | Full pricing section: plans, starting prices and cost explainer |
| Price plans | `bwe/plans` | Row of plan cards, one can be featured<br>↳ Price plan `bwe/price-plan` |
| Starting prices | `bwe/starting-prices` | "Service — from $X" rows with a note and link |
| Cost explainer | `bwe/cost-panel` | Heading and short explainer points |
| Price list section | `bwe/price-section` | Service price cards, 2 or 3 per row<br>↳ Price card `bwe/price-card` |
| Price list | `bwe/price-list` | Service + turnaround on the left, price on the right<br>↳ Price row `bwe/price-row` |

### General-purpose building blocks

| Block | Name | What it is |
|---|---|---|
| Buttons | `bwe/buttons` | 1–6 buttons (lime, outline, dark, light, text link), rel / new-tab per button, per-device alignment |
| Image / screenshot | `bwe/media` | Media-library image with srcset, lazy or above-the-fold loading, frames, per-device aspect ratio, caption, link |
| Grid / columns | `bwe/grid` | Any blocks side by side: 1–6 columns per device, 2-column ratios, card styles |
| Gap / divider | `bwe/gap` | Spacing with its own height per device and an optional divider line |

## Editor features

- **Styles tab:** section blocks have a Styles tab for spacing, backgrounds, colours, headings, cards and buttons.
  An item's own Styles tab ("This card", "This project") overrides the grid's settings for that item only.
- **Items per row:** blocks that hold a row of items get an *Items per row* panel: desktop / tablet / phone
  (1–6), "All on one row", and "+ Add item".
- **Visibility:** hide any block on desktop (1025px+), tablet (782–1024px) or phone (≤781px). Hidden blocks are
  shown faded in the editor.
- **Heading tag (SEO):** print a block's main heading as `h1`–`h6`, `p` or `div` without changing how it looks.
- **Icons:** Service tile, Step and Section can use the site icon, any of ~2,100 [Lucide](https://lucide.dev) icons,
  an uploaded image, pasted SVG, or no icon.
- **Starter content:** newly inserted blocks arrive filled with sample text in the site's own words.
- **Inserter previews:** hovering a block in the inserter shows a picture of it on the live site.
- **Page layout:** *Page settings → Page layout* chooses the wrappers around a page's sections, so pages don't need
  wrapper groups with CSS classes. Pages built from these blocks get the Home look automatically.
- **Section parts:** core blocks inside a section keep a named role instead of hand-typed CSS classes.
- **Rank Math:** block text is passed to Rank Math's analysis and the front-end content readers (reading time,
  og:image).

> Inside a **synced pattern**, WordPress shows content only. Use *Edit original* on the pattern to reach the Styles
> tab and icon settings.

Front-end CSS (`assets/css/blocks.css`, `heading-compat.css`) loads only on pages that use these blocks.

## Development

```bash
npm install --include=dev   # --include=dev is needed if NODE_ENV=production is set on your machine
npm run start               # watch mode: rebuilds build/ on every save
npm run build               # production build: run this before committing or zipping
```

`npm run build` also regenerates `src/blocks/shared/style-labels.js`, `assets/css/heading-compat.css`,
`build/blocks-manifest.php` and `build/icons/lucide.json`.

> `build/` is committed to git. Run `npm run build` before each commit so it matches `src/`.

| Script | What it does |
|---|---|
| `npm run build` | Production build |
| `npm run start` | Development build in watch mode |
| `npm run plugin-zip` | Release zip (plugin files and `build/`, no `node_modules`) |
| `npm run lint:js` | Lint `src/` |
| `npm test` | PHP tests (`tools/tests`) |
| `npm run verify` | Build, tests, live HTML of the site's pages vs. the baseline, and an editor check of all pages |
| `npm run editor -- <ids>` | Editor check of chosen pages (`bNNN` = synced pattern NNN) |
| `npm run audit` | Checks that every Styles-tab setting visibly changes the live Home page |
| `npm run icons` | Rebuild the Lucide icon set |
| `npm run site-bundle` | Rebuild the site CSS bundle (`site/assets/home-2/bundle/`) after editing CSS in `site/` |

The `verify`, `editor` and `audit` scripts run against a local WordPress install and need admin login cookies from
`tools/cookie.php`. The output of that script is a secret: keep it out of the web root and out of git.

### Project layout

```
bestwebexpert-gutenberg-widget.php   plugin bootstrap
includes/                            PHP: block registration, style engine, global controls, page layout, …
src/editor.js                        single editor entry point for every block
src/blocks/<name>/                   block.json, index.js / edit.js, render.php
src/blocks/shared/                   shared editor code (style controls, row controls, icons, …)
build/                               compiled output (committed)
assets/css/                          front-end CSS
assets/previews/                     inserter preview images
languages/                           translations
site/                                site design layer: CSS/JS, render filters, blog templates, schema
tools/                               CLI-only build scripts, converters, tests and checks
```

### Adding a block

1. Create `src/blocks/<name>/` with `block.json`, `index.js` and `render.php`.
2. Set `"editorScript": "bwe-gw-editor"` in `block.json`. All blocks share one editor bundle, and new folders are
   picked up automatically.
3. Run `npm run build`.

## Translation

All editor strings use the `bestwebexpert` text domain. Translations are loaded from `languages/` first, then from
`wp-content/languages/plugins/` (where Loco Translate and translate.wordpress.org put them).

```bash
wp i18n make-pot . languages/bestwebexpert.pot
wp i18n make-json languages --no-purge
```

## License

GPL-2.0-or-later. Bundled Lucide icons are under the ISC licence (`build/icons/LICENSE-lucide.txt`).
