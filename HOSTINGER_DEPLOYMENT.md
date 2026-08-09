# Hostinger Shared Hosting Deployment Guide (Git)

This guide provides step-by-step instructions on deploying the **Shera Viva** Laravel API and Admin Panel backend to **Hostinger Shared Hosting** using the **Git Deployment** feature in the Hostinger panel.

---

## Deploying the Backend (Admin Panel & APIs)

Your target is to deploy the backend so that the mobile app can consume secure API endpoints and you can manage categories, question banks, and examiners from the Filament admin panel.

---

### Step 1: Prevent Search Engine Indexing (Already Configured)
To prevent search engines from index-crawling your staging/v1 site, a global `public/robots.txt` has been added:
```text
User-agent: *
Disallow: /
```
This blocks all crawlers (Googlebot, Bingbot, etc.) from indexing your APIs and admin dashboard.

---

### Step 2: Set up Git Deployment in Hostinger
1. Log in to your **Hostinger hPanel**.
2. Navigate to **Advanced -> Git** from the sidebar.
3. Configure the Git Repository:
   * **Repository URL**: `https://github.com/nadim-anamul/sheraVivaAdminApi.git` *(or your private clone URL)*
   * **Branch**: `main` *(or target release branch)*
   * **Install Directory**: Keep it as empty or set it to `/public_html` (if deploying directly to main domain).
4. Click **Create**.
5. Once created, click the **Deploy** button to pull the codebase onto Hostinger's server.

---

### Step 2b: Point the Domain Document Root at `public/` (Required)

Laravel’s web entrypoint is `public/index.php`. If the domain document root is the project root (`public_html`), Apache rewrites into `public/` and Filament admin URLs can leak `/public/...` into redirects, which causes `ERR_TOO_MANY_REDIRECTS` on `/admin/login`.

1. In hPanel go to **Domains → your-domain.com**.
2. Set **Document root** to `public_html/public` (path must end in `/public`).
3. Keep **Force HTTPS** enabled.
4. Save and wait a minute for the change to apply.

`public/.htaccess` also strips a leaked `/public` prefix from trailing-slash redirects as a safety net, but the document root must still be `public/`.

Verify after the change:
- `https://your-domain.com/admin/login/` must redirect to `/admin/login` (not `/public/admin/login`).

---

### Step 3: Database & Environment Configuration
1. Go to **Databases -> MySQL Databases** in your hPanel.
2. Create a new database:
   * **MySQL Database**: `u123456789_sheraviva`
   * **MySQL User**: `u123456789_nadim`
   * **Password**: `YourSecurePassword`
3. Open **Files -> File Manager** and go to your project root folder.
4. Create/Edit the `.env` file in the root directory:
   ```env
   APP_NAME="Shera Viva"
   APP_ENV=production
   APP_DEBUG=false
   # HTTPS, no trailing slash
   APP_URL=https://your-domain.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u123456789_sheraviva
   DB_USERNAME=u123456789_nadim
   DB_PASSWORD=YourSecurePassword

   SESSION_DRIVER=database
   SESSION_DOMAIN=null
   SESSION_SECURE_COOKIE=true

   # Security & AI Keys
   SHERA_VIVA_API_KEY="sv_secure_key_123456" # Key used by Mobile Client
   GEMINI_API_KEY="AIzaSy..."
   GEMINI_MODEL_CONVERSATION=gemini-3.6-flash
   GEMINI_MODEL_EVALUATION=gemini-3.6-pro

   # Default Admin Credentials
   ADMIN_EMAIL="admin@seraviva.com"
   ADMIN_PASSWORD="YourStrongAdminPasswordHere"
   ```

> [!IMPORTANT]
> - `APP_URL` must be `https://…` with **no trailing slash**.
> - `SESSION_SECURE_COOKIE=true` is required on HTTPS so Filament session cookies stick.
> - Leave `SESSION_DOMAIN=null` unless you intentionally share cookies across subdomains.
> - After any `.env` change, clear and rebuild config cache (Step 4), then clear browser cookies for the domain (or use a private window).

---

### Step 4: Run Post-Deployment Commands (via SSH)

> [!IMPORTANT]
> **PHP Version Requirements**: Laravel 13 and Symfony 8 require PHP **>= 8.3/8.4**.
> 1. Go to your Hostinger hPanel -> **Advanced -> PHP Configuration**.
> 2. Select **PHP 8.4** and save. This updates the web server.
> 3. In the SSH terminal, the default `php` and `composer` commands might still point to PHP 8.2. You **must** prefix commands with the PHP 8.4 binary path (`/usr/bin/php84`) as shown below.

1. Go to **Advanced -> SSH Access** in Hostinger, enable SSH, and copy the terminal connection command.
2. Open your terminal, connect via SSH, and navigate to the project directory:
   ```bash
   cd domains/your-domain.com/public_html
   ```
3. Install PHP production dependencies using PHP 8.4:
   ```bash
   /usr/bin/php84 /usr/local/bin/composer install --no-dev --optimize-autoloader
   ```
   *(If you run into issues, you can append `--ignore-platform-reqs` to force it: `/usr/bin/php84 /usr/local/bin/composer install --no-dev --optimize-autoloader --ignore-platform-reqs`)*
4. Generate the application cryptographic key:
   ```bash
   /usr/bin/php84 artisan key:generate
   ```
5. Run migrations and database seeders to populate initial question banks:
   ```bash
   /usr/bin/php84 artisan migrate:fresh --seed --force
   ```
6. Set correct directory read/write permissions for shared storage:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```
7. Cache routing and configuration settings for maximum speed:
   ```bash
   /usr/bin/php84 artisan config:clear
   /usr/bin/php84 artisan config:cache
   /usr/bin/php84 artisan route:cache
   ```

> [!TIP]
> **Permanent SSH Alias**:
> To make `php` point to `php84` permanently in your SSH terminal, run:
> ```bash
> echo "alias php='/usr/bin/php84'" >> ~/.bashrc
> echo "alias composer='/usr/bin/php84 /usr/local/bin/composer'" >> ~/.bashrc
> source ~/.bashrc
> ```
> After running this, you can use normal `php` and `composer` commands safely!

---

## Connecting the Mobile App
Your API endpoints are protected using the `X-Api-Key` middleware. When the Flutter/mobile client requests data from Hostinger, it must include the HTTP header:

* **Header Key**: `X-Api-Key`
* **Header Value**: `sv_secure_key_123456` *(matching `SHERA_VIVA_API_KEY` in Hostinger `.env`)*

**Root API Domain URL**:
`https://your-domain.com/api`

---

## Automated Deployment Webhook (Optional)
To automatically trigger a redeployment on Hostinger whenever you push code changes to GitHub:
1. In Hostinger **Advanced -> Git**, copy the **Webhook URL**.
2. Go to your repository on **GitHub -> Settings -> Webhooks**.
3. Click **Add webhook**:
   * **Payload URL**: Paste the Webhook URL from Hostinger.
   * **Content type**: `application/json`.
4. Click **Add webhook**. Now, pushes to your branch will auto-deploy immediately!

---

## Troubleshooting: Admin Login `ERR_TOO_MANY_REDIRECTS`

If `https://your-domain.com/admin/login` loops in the browser:

1. Confirm document root ends in `/public` (Step 2b).
2. Confirm `.env` has `APP_URL=https://your-domain.com` (no trailing slash) and `SESSION_SECURE_COOKIE=true`.
3. Rebuild config cache:
   ```bash
   /usr/bin/php84 artisan config:clear
   /usr/bin/php84 artisan config:cache
   ```
4. Clear cookies for the domain (or open a private window) and retry.
5. Quick checks:
   ```bash
   curl -sI https://your-domain.com/admin/login
   curl -sI https://your-domain.com/admin/login/
   ```
   Login should return `200`. Trailing-slash should redirect to `/admin/login`, never `/public/admin/login`.
