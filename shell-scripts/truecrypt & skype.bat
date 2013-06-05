@echo off
REM Helps securing Skype profile by storing it in a TrueCrypt drive
REM 1. Create the container if you don't have it
REM 2. Disable auto starting of Skype on Windows Start
REM 3. Log out and completely exit Skype
REM 4. Move %APPDATA%\Skype into the container, e.g. K:\AppData\Skype
REM 5. mklink /D "%APPDATA%\Skype" "K:\AppData\Skype"
REM 6. [Optional] Add this to startup e.g. make a shortcut in "%APPDATA%\Microsoft\Windows\Start Menu\Programs\Startup"
"%PROGRAMFILES%\TrueCrypt\TrueCrypt.exe" /v "<PATH TO CONTAINER>" /a /q /l K
start "" "C:\Program Files (x86)\Skype\Phone\Skype.exe"
