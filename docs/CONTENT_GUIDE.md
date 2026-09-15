# Content Guide - egi-optics.com

How editors add and maintain content in wp-admin. Everything below uses the standard WordPress block
editor; no page-builder plugin is required.

## Content model

| Type                | Where in wp-admin       | URL pattern                     | Notes                                                    |
| ------------------- | ----------------------- | ------------------------------- | -------------------------------------------------------- |
| Product             | **Products**            | `/products/<slug>/`             | custom post type `egi_product`; archive at `/products/`  |
| Product category    | Products -> Categories  | `/product-category/<slug>/`     | e.g. Laser Systems, Electro-Optics, Night Vision, Thermal |
| News article        | **Posts**               | `/news/<slug>/`                 | category *News*; listing at `/news/`                     |
| Page                | **Pages**               | `/<slug>/`                      | Home, About, Contact, Downloads                          |
| Navigation          | Appearance -> Editor -> Navigation | -                    | header menu and footer menus                             |

## Adding a product

1. Products -> *Add New*. The editor opens with the product template pre-filled (hero, key benefits,
   applications, stats, specification table, downloads, CTA). Replace the placeholder text.
2. Fill the sidebar fields in the **Product details** panel:
   - *Tagline* (short line under the name, e.g. "Man-portable - Anti-FPV drone").
   - *Datasheet URL* (upload the PDF in Media first and paste its URL).
   - *Accent* (optional colour name from the palette, used for highlights).
3. Set a **Featured image** (transparent PNG, min. 1200px wide, product on a neutral background).
4. Write an **Excerpt** (1-2 sentences); it becomes the card text and the SEO description.
5. Assign a **Product category**.
6. Specification tables are normal Table blocks with the *Spec table* block style. Use one table per
   group (Laser, Optics, Radar, ...) and keep units in the value column.
7. Videos: insert a Video block inside the *Field trial* pattern (Patterns -> EGI Optics -> Field trial video).
   Upload MP4 (H.264) <= 20 MB; set a poster image.
8. Publish. The product appears automatically on `/products/` and in the home page product grid.

## Adding a news article

1. Posts -> *Add New*; category **News**; set a featured image (landscape, min. 1600px wide).
2. Structure: lede paragraph (who/what/where/when), 2-4 short sections with `h2` headings, a gallery
   block for photos with captions, closing paragraph. Aim for 350-600 words.
3. Every image needs an *Alt text* describing what is shown (people, equipment, place).
4. Excerpt: one sentence used on cards and social previews.
5. Rank Math panel: check the title (<= 60 chars) and description (<= 155 chars).

## Editing the home page and other pages

Pages are built from **patterns** (Inserter -> Patterns -> *EGI Optics* category). Each section is a
Group block; open the *List View* to select sections. Do not change colours or fonts per block; the
design system lives in Appearance -> Editor -> Styles and in the theme's `theme.json`.

## Media guidelines

- Products: transparent PNG or WebP, 1600px wide, file name `product-slug.png`.
- Photos: JPG/WebP, 1920px wide max, quality 80. LiteSpeed generates WebP automatically.
- PDFs: max 10 MB, file name `EGI-<Product>-Datasheet.pdf`.
- Always fill *Alt text*; use *Caption* for photo credits and context.

## Do not

- Install page-builder plugins or paste HTML from other sites.
- Upload internal documents (reports, contracts) to the Media Library: everything there is public.
- Change permalinks/slugs of published products without asking a developer (redirects are needed).
