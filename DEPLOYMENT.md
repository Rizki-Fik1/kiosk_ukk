# Deploying Lapak Kelontong to Vercel

## Prerequisites
1. Install Vercel CLI: `npm i -g vercel`
2. Have a Vercel account
3. Generate Laravel APP_KEY

## Steps to Deploy

### 1. Generate APP_KEY
Run this command locally to generate your app key:
```bash
php artisan key:generate --show
```
Copy the generated key for step 3.

### 2. Login to Vercel
```bash
vercel login
```

### 3. Build Assets First
```bash
npm install
npm run build
```

### 4. Deploy to Vercel
```bash
vercel
```

During setup:
- Choose your project directory
- Link to existing project or create new one
- When asked about build settings, choose "Other"
- Output Directory: leave empty or set to "public"
- Install Command: `npm install`
- Build Command: `npm run build`

### 5. Set Environment Variables in Vercel Dashboard
Go to your Vercel project dashboard → Settings → Environment Variables and add:

**Required Variables:**
- `APP_KEY`: base64:YOUR_GENERATED_KEY_HERE
- `APP_URL`: https://your-actual-vercel-url.vercel.app
- `APP_ENV`: production
- `APP_DEBUG`: false
- `LOG_CHANNEL`: stderr
- `CACHE_DRIVER`: array
- `SESSION_DRIVER`: array

**Example:**
```
APP_KEY=base64:abcd1234567890abcd1234567890abcd1234567890abcd==
APP_URL=https://lapak-kelontong.vercel.app
APP_ENV=production
APP_DEBUG=false
```

### 6. Deploy to Production
```bash
vercel --prod
```

## What's Deployed
- Only the coming soon page is accessible
- All other routes redirect to home
- Admin panel is hidden in production
- No database functionality (static site)

## Local Development vs Production
- Local: Shows admin panel link
- Production: Only shows coming soon page

## Files Created for Deployment
- `vercel.json` - Vercel configuration
- `api/index.php` - Entry point for Vercel
- `routes/web.production.php` - Production-only routes
- `.env.production` - Production environment template