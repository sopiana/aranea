@echo off
set param=
IF NOT "%~1"=="" (set param=:%1) ELSE (set param=:refresh)

php artisan migrate%param% --path=database/migrations/UserManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/ProjectManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/StatusActionManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/RequestManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/RequirementManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/TestCaseManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/TestExecutionManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/BugsManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/ReleaseManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/TaskManagement
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/ForeignKeyAssignment
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/TriggerAssignment
if %errorlevel% neq 0 exit /b %errorlevel%

php artisan migrate%param% --path=database/migrations/ViewManagement
if %errorlevel% neq 0 exit /b %errorlevel%



