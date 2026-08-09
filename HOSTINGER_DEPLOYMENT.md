# Hostinger Shared Hosting Deployment Guide (Git)

This guide provides step-by-step instructions on deploying the **Shera Viva** Laravel API and Admin Panel backend to **Hostinger Shared Hosting** using the **Git Deployment** feature in the Hostinger panel.

---

## 🌟 Deploying the Backend (Admin Panel & APIs)

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
   APP_URL=https://your-domain.com

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=u123456789_sheraviva
   DB_USERNAME=u123456789_nadim
   DB_PASSWORD=YourSecurePassword

   # Security & AI Keys
   SHERA_VIVA_API_KEY="sv_secure_key_123456" # Key used by Mobile Client
   GEMINI_API_KEY="AIzaSy..."
   GEMINI_MODEL_CONVERSATION=gemini-3.6-flash
   GEMINI_MODEL_EVALUATION=gemini-3.6-pro

   # Default Admin Credentials
   ADMIN_EMAIL="admin@seraviva.com"
   ADMIN_PASSWORD="YourStrongAdminPasswordHere"
   ```

---

### Step 4: Run Post-Deployment Commands (via SSH)
1. Go to **Advanced -> SSH Access** in Hostinger, enable SSH, and copy the terminal connection command.
2. Open your terminal, connect via SSH, and navigate to the project directory:
   ```bash
   cd domains/your-domain.com/public_html
   ```
3. Install PHP production dependencies:
   ```bash
   composer install --no-dev --optimize-autoloader
   ```
4. Generate the application cryptographic key:
   ```bash
   php artisan key:generate
   ```
5. Run migrations and database seeders to populate initial question banks and establish default credentials:
   ```bash
   php artisan migrate:fresh --seed --force
   ```
6. Set correct directory read/write permissions for shared storage:
   ```bash
   chmod -R 775 storage bootstrap/cache
   ```
7. Cache routing and configuration settings for maximum speed:
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

---

## 📱 Connecting the Mobile App
Your API endpoints are protected using the `X-Api-Key` middleware. When the Flutter/mobile client requests data from Hostinger, it must include the HTTP header:

* **Header Key**: `X-Api-Key`
* **Header Value**: `sv_secure_key_123456` *(matching `SHERA_VIVA_API_KEY` in Hostinger `.env`)*

**Root API Domain URL**:
`https://your-domain.com/api`

---

## 🛠️ Automated Deployment Webhook (Optional)
To automatically trigger a redeployment on Hostinger whenever you push code changes to GitHub:
1. In Hostinger **Advanced -> Git**, copy the **Webhook URL**.
2. Go to your repository on **GitHub -> Settings -> Webhooks**.
3. Click **Add webhook**:
   * **Payload URL**: Paste the Webhook URL from Hostinger.
   * **Content type**: `application/json`.
4. Click **Add webhook**. Now, pushes to your branch will auto-deploy immediately!
