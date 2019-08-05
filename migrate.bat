@echo off
set param=
IF NOT "%~1"=="" (set param=:%1) ELSE (set param=:refresh)

php artisan migrate%param% --path=/database/migrations/UserManagement




