# Sketch Signs

The sketchsigns.com storefront rebuilt on **Laravel 13 + Livewire 4**, deployable to **Vercel**.

## What's inside

- Home, shop (live search / filter / sort), category, product, industry, about, contact, quote, FAQ, installation, design services, tracking and policy pages.
- Livewire product configurator with instant pricing (size presets, custom W×H, options, bulk discounts, design fee).
- Session cart (cookie driver — no database needed), checkout that emails the order to the shop, quote and newsletter forms.
- Old WordPress URLs (`/banners/`, `/product-category/...`, `/refund-policy/` …) redirect to the new pages.

## Editing content

| What | Where |
| --- | --- |
| Products, prices, options, categories | `config/catalog.php` |
| Contact info, FAQ, industries, projects | `config/site.php` |
| Page layouts | `resources/views` |

Images are served from the old WordPress media library (`MEDIA_URL`). Move them to your own storage and change `MEDIA_URL` before shutting the old site down.

## Local development

```bash
composer install && npm install
cp .env.example .env && php artisan key:generate
npm run build      # or: npm run dev
php artisan serve
```

## Deploying to Vercel

`vercel.json` uses the community `vercel-php` runtime (PHP 8.4). `api/index.php` boots Laravel; `npm run build` produces the Vite assets in `public/build`.

Required environment variables in Vercel (Project → Settings → Environment Variables):

- `APP_KEY` — run `php artisan key:generate --show`
- `APP_URL` — e.g. `https://sketchsigns.com`

To actually send order / quote emails, also set `MAIL_MAILER=smtp`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_FROM_ADDRESS` (or use Resend / Postmark). Without them, submissions are written to the function logs.

## Catalog and images

Products, categories and images come from the old WooCommerce site. On Vercel (no shell) the import runs through
token-protected URLs, each call doing one small batch: add `?token=<ADMIN_TOKEN>` to

- `/admin/sync/migrate`: run migrations
- `/admin/sync/categories`: import categories
- `/admin/sync/products?page=1&per_page=5`: import products; follow `next` until it is `null`
- `/admin/sync/site-media`: copy the logo and project photos
- `/admin/sync/remirror?page=1`: re-upload every image scaled to at most 1200px, to the same Blob paths
- `/admin/sync/status`: counts and anything missing

Locally, `php artisan catalog:import` does the same.

If the Blob store is unavailable, set `BLOB_SERVE_ORIGIN=true` to serve images from their original URLs.
