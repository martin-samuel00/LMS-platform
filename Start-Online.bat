@echo off
title LMS Platform - Online Server Launcher
color 0a

echo ================================================================
echo           STARTING LMS PLATFORM - ONLINE CLOUD LAUNCHER
echo ================================================================
echo.
echo [1/3] Starting Laravel Local Server on port 8000...
start "Laravel Server" /B php artisan serve --host=127.0.0.1 --port=8000

echo [2/3] Starting Real-Time WebSocket Server (Reverb)...
start "Reverb WebSockets" /B php artisan reverb:start

echo [3/3] Creating Global Cloudflare HTTPS Tunnel...
echo.
echo ================================================================
echo  Your Public HTTPS link will appear in the lines below!
echo  Copy that link and send it to your friends to join from anywhere.
echo  Keep this window open while you want your friends to use it.
echo ================================================================
echo.

d:\laravel\cloudflared.exe tunnel --url http://127.0.0.1:8000
