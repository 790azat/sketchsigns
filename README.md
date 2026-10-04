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
