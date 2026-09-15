# Changelog

All notable changes to egi-optics.com are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/) and the project uses
[Semantic Versioning](https://semver.org/).

## [Unreleased]

### Fixed
- Accessibility: footer column labels are paragraphs instead of `h6` headings (heading order), and the
  violet product accent is brighter (#A78BFA) to meet the 4.5:1 contrast ratio for small text.

## [1.1.0] - 2026-09-15

### Fixed
- Header and footer now use a constrained layout: on wide monitors the logo, menu and CTA line up with
  the 1400px content area instead of touching the screen edges.
- Hero content is centred with the rest of the page (the Cover block no longer pins it to the left).
- Paspampres article: officer names corrected to Brig. Gen. TNI Laode and Lt. Col. Inf. Denny Sopyan
  (text, photo alt/captions and photo file names).

### Changed
- Mobile-first theme CSS: base styles target phones and are enhanced at 600 / 782 / 1024px.
  Fluid side gutters (`clamp(1.25rem, 5vw, 2.5rem)`), compact 64px header with a 44px hamburger up to
  1023px, natural-height hero with stacked full-width buttons on phones, two-column stat tiles, larger
  mono labels (11px minimum), 44px minimum touch targets for buttons, links and form fields, spec
  tables with a fixed label column, product image shown before the copy on phones.
- "Request a briefing" is available inside the mobile menu overlay.
- Hero background served as WebP (156 KB instead of 480 KB).

## [1.0.0] - 2026-09-15

Complete redesign and re-platforming of egi-optics.com: from an Elementor/Solace template site to a
custom WordPress block theme, deployed from Git.

### Added
- **Theme `egi-optics`** (block theme): dark precision-engineering design system in `theme.json`
  (palette, fluid type scale, spacing, shadows), self-hosted Space Grotesk / DM Sans / JetBrains Mono,
  templates for home, pages, news index/articles, product archive/category/single, search and 404,
  header/footer parts with slug-resolved navigation, 17 block patterns (hero, stats, intro, products grid,
  competencies, why EGI, vision/mission, field-trial video, downloads, latest news, contact cards, CTA,
  full Home/About/Contact pages, product body), block styles (spec table, check/square/tag lists, outline
  and ghost buttons, card/panel groups, engineering frame, glow separator), scroll-reveal and header
  behaviour in plain JS with reduced-motion support.
- **Plugin `egi-optics-core`**: `egi_product` post type and `product_category` taxonomy, product meta with
  editor sidebar panel (tagline, datasheet, accent, badge), `egi/site` block-bindings source, 301 redirect
  map for legacy URLs (active only once the theme is live), hardening (XML-RPC off, comments off, author
  archives off, anonymous users endpoint hidden, security headers, generic login errors, SVG upload limits),
  Organization schema.
- **Content**: seven products merged from the EGI Resources holding site and the previous datasheets
  (Laser Weapon System, Fenix Mobile Counter-UAV Laser Complex, Remote Control Observation Unit, Laser
  Point LAD-21T, Thermal Vision Sight TVD-35, Night Vision Monocular NV/M-19 Gen 4 with NV/G-14 variant,
  Fusion TN-KS/2), four field-trial/R&D videos with posters, four datasheets, rebuilt Home/About/Contact,
  News index, and the article "EGI Optik Indonesia Demonstrates Counter-UAV Laser Gun to Paspampres"
  (7 September 2026) with photo gallery.
- **Tooling and process**: Composer (PHPCS + WordPress Coding Standards + PHPCompatibility), npm
  (`@wordpress/scripts`, `wp-env`, Playwright QA screenshots), idempotent WP-CLI content scripts,
  Cursor rules and docs for Git workflow, SDLC/CI-CD, development and content editing.
- **CI/CD**: GitHub Actions CI (PHP syntax, PHPCS, stylelint, eslint, JSON validation, packaging dry run)
  and production deploy (server backup -> rsync theme/plugin -> post-deploy -> health check) over SSH to
  Hostinger; Dependabot for actions, npm and composer.

### Changed
- Site identity: name "EGI Optik Indonesia", tagline, new logo (light variant for the dark UI), site icon,
  HTTPS `siteurl`/`home`, timezone Asia/Jakarta, permalinks `/news/%postname%/`, products at `/products/`.
- Rank Math: products and product categories in the sitemap, forms excluded and `noindex`, brand title on
  the home page.
- LiteSpeed Cache Guest Mode disabled (its vary request was blocked by Solid Security and produced a
  JavaScript error on every page).

### Removed
- Elementor, Pro Elements, Happy Elementor Addons, Spectra, Solace Extra, Classic Editor plugins; Solace,
  Astra, Twenty Twenty-Three/Four themes.
- Template demo content: placeholder posts, Clients/Career/Locations pages, demo menus, duplicate forms,
  Elementor library items (all trashed, recoverable; full pre-redesign snapshot in
  `~/backups/egi-optics/pre-overhaul-20260915-022900/`).

[Unreleased]: https://github.com/echestratus/egi-optics/compare/v1.1.0...HEAD
[1.1.0]: https://github.com/echestratus/egi-optics/compare/v1.0.0...v1.1.0
[1.0.0]: https://github.com/echestratus/egi-optics/releases/tag/v1.0.0
