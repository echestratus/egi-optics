=== EGI Optics Core ===
Contributors: egioptik
Requires at least: 6.7
Tested up to: 6.9
Requires PHP: 8.2
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Site-specific functionality for egi-optics.com.

== Description ==

* Registers the **Products** post type (`egi_product`, archive `/products/`) and the **Product Category** taxonomy.
* Registers product meta (tagline, datasheet URL/label, accent colour, card badge) with an editor sidebar panel; values are usable through Block Bindings (`core/post-meta`).
* Provides the `egi/site` Block Bindings source (copyright line, phone, e-mail, address, holding link).
* 301 redirects for URLs of the previous site (see `inc/redirects.php`).
* Hardening: XML-RPC off, no version disclosure, comments disabled, author archives disabled, anonymous users endpoint hidden, security headers, generic login errors, SVG uploads limited to administrators.

The `egi-optics` block theme expects this plugin to be active.

== Changelog ==

= 1.0.0 =
* Initial release with the 2026 redesign.
