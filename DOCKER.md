# Hydration Buddy - Docker Deployment Guide

## 🐋 Docker Deployment

This guide will help you deploy the Hydration Buddy application using Docker and Docker Compose.

## Prerequisites

- Docker installed ([Get Docker](https://docs.docker.com/get-docker/))
- Docker Compose installed (usually comes with Docker Desktop)
- Git (optional, for cloning)

## Quick Start

### 1. Build and Run

```bash
# Build and start all containers
docker-compose up -d --build

# Check if containers are running
docker-compose ps

# View logs
docker-compose logs -f app
```

### 2. Access the Application

Open your browser and go to: **http://localhost:8080**

You should see the loading screen with "Hi welcome SEN" followed by the dashboard!

## Configuration

### Environment Variables

The application uses these key environment variables (configured in `docker-compose.yml`):

- `DB_HOST=mysql` - Database host (container name)
- `DB_DATABASE=hydration_buddy` - Database name
- `DB_USERNAME=hydration_user` - Database user
- `DB_PASSWORD=hydration_password_change_me` - **⚠️ CHANGE THIS!**

### Security: Change Default Passwords

**IMPORTANT:** Before deploying to production, update these in `docker-compose.yml`:

```yaml
# MySQL service
MYSQL_ROOT_PASSWORD: your_secure_root_password
MYSQL_PASSWORD: your_secure_user_password

# App service
DB_PASSWORD: your_secure_user_password
```

### Change Port

To use a different port, edit `docker-compose.yml`:

```yaml
ports:
  - "8080:80"  # Change 8080 to your desired port
```

## Docker Commands

### Start Services
```bash
docker-compose up -d
```

### Stop Services
```bash
docker-compose down
```

### Restart Services
```bash
docker-compose restart
```

### View Logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f app
docker-compose logs -f mysql
```

### Access Application Container
```bash
docker-compose exec app sh
```

### Access Database
```bash
docker-compose exec mysql mysql -u hydration_user -p hydration_buddy
# Enter password: hydration_password_change_me
```

### Rebuild After Code Changes
```bash
docker-compose down
docker-compose up -d --build
```

## Database Management

### Run Migrations Manually
```bash
docker-compose exec app php artisan migrate
```

### Reset Database
```bash
docker-compose exec app php artisan migrate:fresh
```

### Backup Database
```bash
docker-compose exec mysql mysqldump -u hydration_user -phydration_password_change_me hydration_buddy > backup.sql
```

### Restore Database
```bash
cat backup.sql | docker-compose exec -T mysql mysql -u hydration_user -phydration_password_change_me hydration_buddy
```

## Production Deployment

### 1. Update Environment Variables

Edit `docker-compose.yml` and change:
- All passwords
- `APP_DEBUG=false`
- `APP_ENV=production`
- `APP_URL` to your domain

### 2. Generate New APP_KEY

```bash
docker-compose exec app php artisan key:generate
```

### 3. Optimize for Production

```bash
docker-compose exec app php artisan config:cache
docker-compose exec app php artisan route:cache
docker-compose exec app php artisan view:cache
```

### 4. Set Up Reverse Proxy (Optional)

For production with HTTPS, use Nginx or Traefik as a reverse proxy.

Example Nginx configuration:

```nginx
server {
    listen 80;
    server_name yourdomain.com;

    location / {
        proxy_pass http://localhost:8080;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

## Troubleshooting

### Container Won't Start
```bash
# Check logs
docker-compose logs app

# Check MySQL connection
docker-compose exec app php artisan tinker
>>> DB::connection()->getPdo();
```

### Permission Issues
```bash
docker-compose exec app chown -R www-data:www-data /var/www/html/storage
docker-compose exec app chmod -R 755 /var/www/html/storage
```

### Database Connection Failed
1. Ensure MySQL container is healthy: `docker-compose ps`
2. Check environment variables in `docker-compose.yml`
3. Wait for MySQL to fully start (check logs: `docker-compose logs mysql`)

### Port Already in Use
```bash
# Change port in docker-compose.yml or stop conflicting service
# Windows: netstat -ano | findstr :8080
# Linux/Mac: lsof -i :8080
```

### Clear All Data and Restart
```bash
docker-compose down -v  # ⚠️ This deletes all database data!
docker-compose up -d --build
```

## Architecture

### Services

1. **app** - Laravel application with Nginx and PHP-FPM
   - Port: 8080 (external) → 80 (internal)
   - Runs migrations on startup
   - Serves the web application

2. **mysql** - MySQL 8.0 database
   - Port: 3306
   - Persistent storage via Docker volume
   - Health checks enabled

### Volumes

- `mysql_data` - Persists database data
- `./storage` - Application storage (uploaded files, logs)
- `./bootstrap/cache` - Laravel cache files

### Network

- `hydration_network` - Bridge network for container communication

## File Structure

```
hydration_buddy/
├── Dockerfile                          # Multi-stage build for app
├── docker-compose.yml                  # Orchestration file
├── .env.docker                         # Docker environment template
├── docker/
│   ├── nginx/
│   │   └── default.conf               # Nginx configuration
│   └── supervisor/
│       └── supervisord.conf           # Process manager config
└── ...
```

## Updates and Maintenance

### Update Application Code
```bash
# Pull latest code (if using Git)
git pull

# Rebuild and restart
docker-compose down
docker-compose up -d --build

# Run new migrations if any
docker-compose exec app php artisan migrate --force
```

### Monitor Resource Usage
```bash
docker stats
```

### Clean Up Unused Images
```bash
docker system prune -a
```

## Support

For issues related to:
- **Docker**: Check Docker documentation
- **Application**: See SETUP.md
- **Database**: Check MySQL logs: `docker-compose logs mysql`

---

**Happy Hydrating! 💧**
