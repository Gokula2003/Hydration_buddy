# 🔧 QUICK FIX: Render "unknown instruction: version" Error

## The Problem
Render is detecting `docker-compose.yml` and trying to use it as a Dockerfile.

## ✅ Solution (Choose ONE):

### OPTION 1: Rename docker-compose.yml (Easiest)

**Run this command:**
```bash
# Windows
ren docker-compose.yml docker-compose.local.yml

# Mac/Linux
mv docker-compose.yml docker-compose.local.yml
```

**Or use the script:**
```bash
prepare-render.bat
```

Then commit and push:
```bash
git add .
git commit -m "Prepare for Render deployment"
git push
```

### OPTION 2: Use .gitignore (Alternative)

Add to `.gitignore`:
```
docker-compose.yml
```

Then commit without docker-compose.yml:
```bash
git rm --cached docker-compose.yml
git add .gitignore
git commit -m "Exclude docker-compose from Render"
git push
```

### OPTION 3: Tell Render to Use Specific Dockerfile

In Render Dashboard when creating the service:
1. Scroll to **Build Command** (Advanced)
2. Leave it empty (default)
3. Render will use `Dockerfile` automatically

---

## 📝 What Files Render Should Use:

✅ **Dockerfile** - Main Dockerfile (now configured for Render)
✅ **docker-entrypoint.sh** - Startup script
✅ **nginx.conf** - Web server config
✅ **supervisord.conf** - Process manager

❌ **docker-compose.yml** - Only for local development
❌ **docker-compose.local.yml** - Renamed local file

---

## 🚀 After Fixing:

1. **Push to GitHub**
2. **In Render:**
   - Create Web Service
   - Environment: **Docker**
   - It will automatically detect and use `Dockerfile`
3. **Add Environment Variables** (important!)
4. **Deploy**

---

## 🔑 Required Environment Variables for Render:

```
APP_NAME=HydrationBuddy
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:EFF3glyjHJVf+nLirvaVwLn8H/BOPaW6QNNSnj2KvnE=
APP_URL=https://YOUR-APP.onrender.com

DB_CONNECTION=mysql
DB_HOST=<from Render database>
DB_PORT=3306
DB_DATABASE=hydration_buddy
DB_USERNAME=<from Render database>
DB_PASSWORD=<from Render database>

SESSION_DRIVER=file
LOG_CHANNEL=stderr
```

---

## ✨ That's It!

Your app will now deploy successfully on Render! 🎉

For detailed instructions, see: **RENDER_DEPLOY.md**
