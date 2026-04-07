# 🚀 Hydration Buddy - Render.com Deployment Guide

## Quick Deploy to Render.com

### Method 1: Using Render Dashboard (Recommended)

#### Step 1: Prepare Your Repository

1. **Push your code to GitHub/GitLab/Bitbucket**
   ```bash
   git init
   git add .
   git commit -m "Initial commit - Hydration Buddy"
   git remote add origin YOUR_REPO_URL
   git push -u origin main
   ```

#### Step 2: Create MySQL Database on Render

1. Go to [Render Dashboard](https://dashboard.render.com/)
2. Click **"New +"** → **"MySQL"**
3. Configure:
   - **Name**: `hydration-buddy-db`
   - **Database**: `hydration_buddy`
   - **User**: `hydration_user`
   - **Region**: Choose closest to you
   - **Plan**: Free
4. Click **"Create Database"**
5. **IMPORTANT**: Save the connection details (you'll need them)

#### Step 3: Create Web Service

1. Click **"New +"** → **"Web Service"**
2. Connect your repository
3. Configure:
   - **Name**: `hydration-buddy`
   - **Environment**: `Docker`
   - **Region**: Same as database
   - **Branch**: `main`
   - **Dockerfile Path**: `./Dockerfile.render`
   - **Plan**: Free

#### Step 4: Add Environment Variables

In the web service settings, add these environment variables:

**Required:**
```
APP_NAME=HydrationBuddy
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:EFF3glyjHJVf+nLirvaVwLn8H/BOPaW6QNNSnj2KvnE=
APP_URL=https://YOUR_APP_NAME.onrender.com

DB_CONNECTION=mysql
DB_HOST=<from database internal connection string>
DB_PORT=3306
DB_DATABASE=hydration_buddy
DB_USERNAME=hydration_user
DB_PASSWORD=<from database connection string>

SESSION_DRIVER=file
LOG_CHANNEL=stderr
```

**To get database connection info:**
1. Go to your database on Render
2. Copy the **Internal Connection String**
3. Extract: host, username, password

#### Step 5: Deploy

1. Click **"Create Web Service"**
2. Render will automatically build and deploy your app
3. Wait 5-10 minutes for the first build
4. Access your app at: `https://your-app-name.onrender.com`

---

### Method 2: Using render.yaml (Infrastructure as Code)

1. Keep the `render.yaml` file in your repository
2. Go to Render Dashboard
3. Click **"New +"** → **"Blueprint"**
4. Connect your repository
5. Render will automatically detect and use `render.yaml`
6. Click **"Apply"**

**Note:** You'll still need to set the `APP_KEY` environment variable manually.

---

## Generate New APP_KEY

For security, generate a new APP_KEY before deployment:

```bash
# Locally
php artisan key:generate --show

# Copy the output and use it as APP_KEY environment variable
```

---

## Important Render Configuration

### Free Tier Limitations

- ⚠️ **Sleep after inactivity**: Free services sleep after 15 minutes of inactivity
- ⚠️ **Cold starts**: First request after sleep takes 30-60 seconds
- ⚠️ **750 hours/month**: Enough if you have only one service

### Dockerfile Selection

Render needs to know which Dockerfile to use. Options:

**Option A: Rename Dockerfile.render to Dockerfile**
```bash
# Backup original
mv Dockerfile Dockerfile.compose

# Use Render version
mv Dockerfile.render Dockerfile
```

**Option B: Configure in Render Dashboard**
- Set **Dockerfile Path** to: `./Dockerfile.render`

---

## Troubleshooting

### Build Fails: "unknown instruction: version"

**Problem**: Render is trying to use `docker-compose.yml` as Dockerfile

**Solution**: 
1. Make sure you're using `Dockerfile.render` or `Dockerfile`
2. Set correct Dockerfile path in Render dashboard
3. Delete or rename `docker-compose.yml` temporarily

### Database Connection Failed

**Problem**: Can't connect to database

**Solutions**:
1. Use **Internal Connection String** (not External)
2. Verify all DB_* environment variables are correct
3. Check database is in the same region as web service
4. Wait for database to be fully provisioned (can take 5 min)

### Assets Not Loading (CSS/JS)

**Problem**: Vite assets return 404

**Solutions**:
1. Ensure `npm run build` ran successfully during Docker build
2. Check `public/build` directory exists in container
3. Set `APP_URL` environment variable correctly
4. Clear cache: Add `php artisan cache:clear` to startup

### Application Error 500

**Problem**: Laravel shows error 500

**Solutions**:
1. Check logs in Render dashboard
2. Verify `APP_KEY` is set correctly (must start with `base64:`)
3. Ensure all required environment variables are set
4. Run migrations: Add to `docker-entrypoint.sh`

### Long Build Times

**Problem**: Builds take 10-15 minutes

**Solutions**:
- First build is always slow (downloading dependencies)
- Subsequent builds use cache and are faster (2-3 min)
- Consider paid plan for faster builds

---

## Monitoring & Logs

### View Logs
1. Go to your web service in Render
2. Click **"Logs"** tab
3. Real-time streaming logs show:
   - Application errors
   - Nginx access logs
   - PHP errors

### View Metrics
1. Click **"Metrics"** tab
2. Monitor:
   - Memory usage
   - CPU usage
   - Response times

---

## Updating Your Application

### Auto-Deploy (Recommended)

1. Push changes to your repository:
   ```bash
   git add .
   git commit -m "Update feature"
   git push
   ```

2. Render automatically detects and deploys

### Manual Deploy

1. Go to your web service
2. Click **"Manual Deploy"** → **"Deploy latest commit"**

---

## Database Management

### Access Database

**Option 1: Using Render Shell**
```bash
# In Render web service shell
mysql -h DB_HOST -u DB_USERNAME -p DB_DATABASE
```

**Option 2: External Tool (MySQL Workbench, phpMyAdmin)**
- Use **External Connection String** from Render database
- Note: External connections may be slower

### Backup Database

1. Go to database in Render dashboard
2. Database is automatically backed up daily
3. Manual backup: Use MySQL dump via shell

### Run Migrations

Migrations run automatically on deploy (via `docker-entrypoint.sh`)

To run manually:
1. Open web service **Shell** tab in Render
2. Run: `php artisan migrate`

---

## Cost Optimization

### Free Tier Tips

1. **Combine services**: Run everything in one web service (we do this)
2. **Use file sessions**: Avoid Redis (we use `SESSION_DRIVER=file`)
3. **Optimize images**: Smaller Docker images = faster builds
4. **Use external database**: Free MySQL database from Render

### Upgrade to Paid ($7/month)

Benefits:
- No sleep/cold starts
- More memory (512MB → 2GB)
- Faster builds
- Better performance

---

## Security Checklist

Before going live:

- [ ] Generate new `APP_KEY`
- [ ] Set `APP_DEBUG=false`
- [ ] Use strong database password
- [ ] Set `APP_ENV=production`
- [ ] Configure `APP_URL` to your domain
- [ ] Review `.env` file (don't commit secrets!)
- [ ] Enable HTTPS (automatic on Render)

---

## Custom Domain (Optional)

1. Go to web service settings
2. Click **"Custom Domain"**
3. Add your domain: `hydration.yourdomain.com`
4. Update DNS:
   - Add CNAME record pointing to Render URL
5. Render automatically provisions SSL certificate

---

## Performance Tips

1. **Enable caching**: Already done in `docker-entrypoint.sh`
2. **Optimize images**: Use WebP format for static images
3. **CDN**: Use Cloudflare (free) in front of Render
4. **Database indexing**: Already configured in migration

---

## Support & Resources

- **Render Docs**: https://render.com/docs
- **Render Community**: https://community.render.com
- **Laravel Docs**: https://laravel.com/docs

---

## Quick Reference

**Service URLs:**
- Web App: `https://your-app-name.onrender.com`
- Database: Internal hostname from Render dashboard

**Common Commands (in Render Shell):**
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate

# Check database connection
php artisan tinker
>>> DB::connection()->getPdo();

# View application info
php artisan about
```

---

**Happy Hydrating on Render! 💧🚀**
