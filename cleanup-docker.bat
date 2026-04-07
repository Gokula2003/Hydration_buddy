@echo off
echo Removing Docker files...
echo.

del /F /Q Dockerfile 2>nul
del /F /Q Dockerfile.render 2>nul
del /F /Q Dockerfile.local 2>nul
del /F /Q docker-compose.yml 2>nul
del /F /Q docker-compose.local.yml 2>nul
del /F /Q docker-compose.hidden.yml 2>nul
del /F /Q docker-entrypoint.sh 2>nul
del /F /Q nginx.conf 2>nul
del /F /Q supervisord.conf 2>nul
del /F /Q .dockerignore 2>nul
del /F /Q .dockerignore.bak 2>nul
del /F /Q prepare-render.bat 2>nul
del /F /Q create_docker_dirs.bat 2>nul
del /F /Q render.yaml 2>nul
del /F /Q .env.docker 2>nul
del /F /Q DOCKER.md 2>nul
del /F /Q RENDER_DEPLOY.md 2>nul
del /F /Q RENDER_FIX.md 2>nul
del /F /Q RENDER_QUICKSTART.md 2>nul
del /F /Q RENDER_SOLUTION.md 2>nul

echo.
echo ✓ All Docker files have been removed!
echo.
echo Your application now has only the Laravel files.
echo You can deploy using traditional hosting methods.
echo.
pause

rem Self-delete this cleanup script
del /F /Q "%~f0" 2>nul
