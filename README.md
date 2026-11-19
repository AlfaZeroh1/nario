# Nario Labs website + CMS

The origin point of software. An afro-futurist, space-themed company site with its own CMS.
The stack is vanilla **HTML, CSS, JS, PHP 8.1+ and MySQL/MariaDB**. The only libraries are Lenis (smooth scroll, from unpkg) and Google Fonts.

## Install (XAMPP, MAMP, Laragon or any Apache + PHP host)
1. Copy the `nario-labs` folder to your web root, for example `htdocs/nario-labs`.
2. Make `uploads/` writable by the web server. The installer also writes `config.php` to the project root.
3. Open `http://localhost/nario-labs/install.php`, then enter your database details and an admin username and password.
   Leave **Load demo content** ticked to start with sample partners, clients, products and games.
4. **Delete `install.php`** when it finishes.
5. Log in at `/admin/`.

Without a database the public site still runs on `data/demo.json`, so you can preview it before installing.
On a live server, turn on HTTPS. If you install in a subfolder, update the `ErrorDocument` path in `.htaccess`.

## The CMS (`/admin`)
| Section | What it controls |
|---|---|
| **Partners** | Spiral carousel on Home and Partners: name, website, logo, optional screenshot |
| **Clients** | Second spiral carousel on Home |
| **Products** | Bento grid on Home and Products: logo, tagline, status badge, category (used for the filters), tile size, accent colour |
| **Games** | Game cards on Home and Games: cover image, status, platforms, store link |
| **Messages** | Inbox for the contact form, filterable by interest |
| **Settings** | Email, phone, WhatsApp, socials, tagline, SEO description, password |

Drag rows to reorder items. Hidden items stay in the CMS but don't show on the site.

### The live website previews in the spirals
Each spiral card alternates between the logo and a live, scaled-down view of the partner's website. Click it to open the site in a new tab.
Many sites (Google, banks, most big brands) **block being shown in frames**, and for those the browser shows a blank or error box.
For those partners, either upload a **website screenshot** (it replaces the live frame) or untick **Show the live website**.

## Where things live
```
index.php about.php services.php products.php partners.php games.php contact.php 404.php
includes/   bootstrap (DB, settings, helpers), header, footer, contact form
api/        contact.php (contact form endpoint, JSON)
admin/      CMS
assets/css  style.css (site), admin.css
assets/js   main.js (all interactions), monkey.js (animated monkey + glyph script), admin.js
data/       schema.sql, demo.json
uploads/    logos and covers (scripts can't run here)
```

## The fun parts, and where to tweak them
- **Monkey**: `assets/js/monkey.js`. A vector rebuild of the logo. It blinks at random, and its pupils follow the pointer. Drop `<div data-monkey></div>` anywhere to add one.
- **Nario script**: `<span data-glyph="ANY TEXT"></span>` writes text in the Wakanda-inspired glyphs. The glyph shapes are in `monkey.js` under `G` and `KIT`.
- **Spotlight on ancient text**: the `.glyphs.dim` and `.glyphs.lit` layers. The lit layer is masked to a circle that follows the cursor glow.
- **Sound**: synthesised with Web Audio in `main.js` (`Sfx`), so there are no audio files. Pops on click, ticks on hover, a whoosh on fast scrolls, chimes, and a low space drone. Visitors choose sound on or off on the first visit.
- **Intro**: `.intro` on the home page. The name scatters as you scroll, then the monkey appears, blinks, and the tagline and CTAs follow.
- **Colours**: CSS variables at the top of `style.css`.

## Security notes
- Passwords are hashed with `password_hash`. Logins are rate-limited per session, and every form carries a CSRF token.
- Uploads are checked by MIME type and decoded as images. Only PNG, JPG, WEBP and GIF are accepted, with random filenames.
- `includes/`, `data/` and `config.php` are blocked from the web by `.htaccess`.
- Contact form: honeypot field plus a 30-second rate limit. To also get each message by email, set `'send_mail' => true` in `config.php` (needs a working PHP `mail()` or SMTP relay).

## Performance rules (keep these when adding effects)
The site is tuned to hold about 60fps on laptops and to stay inside iPhone memory limits.
- **One live website at a time.** The spirals load a live site in an iframe only on the card facing the viewer, after it settles at the front, and unload it when the card turns away. Every other card shows its screenshot or a branded site card. Low-end devices (data-saver, ≤2 GB RAM) never load live frames.
- **Animate only `transform` and `opacity`.** Animating blur, blend modes, masks, box-shadow, background-position, `top` or `height` repaints every frame.
- **No layout reads in the animation loop.** Positions are measured once and re-measured on resize. Nothing writes CSS variables on `<html>` per frame.
- **The cursor spotlight is a sliding window,** not a moving mask: two pre-painted layers move with transforms.
- **Stars** redraw at 30fps on a canvas capped at 1.5× pixel ratio (1× on phones).
- **Device tiers** are classes on `<html>`: `tier-2` desktop, `tier-1` phone/tablet (`lite`), `tier-0` low-end. Use them in CSS to tone effects down.
