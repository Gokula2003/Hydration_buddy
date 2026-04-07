@echo off
echo.
echo ================================================
echo   Preparing for Render.com Deployment
echo ================================================
echo.
echo This script will rename docker-compose.yml so Render doesn't use it.
echo.
pause

if exist docker-compose.yml (
    echo Renaming docker-compose.yml to docker-compose.local.yml...
    ren docker-compose.yml docker-compose.local.yml
    echo Done!
    echo.
    echo ✓ docker-compose.yml renamed to docker-compose.local.yml
    echo ✓ Render will now use Dockerfile instead
    echo.
) else (
    echo docker-compose.yml not found (already renamed or doesn't exist)
    echo.
)

echo ================================================
echo   Ready for Render Deployment!
echo ================================================
echo.
echo Next steps:
echo 1. Commit and push your code to GitHub
echo 2. Create Web Service on Render
echo 3. Select "Docker" environment
echo 4. Render will automatically use the Dockerfile
echo.
echo To restore docker-compose.yml for local development:
echo   ren docker-compose.local.yml docker-compose.yml
echo.
pause
