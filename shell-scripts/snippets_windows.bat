REM Tüm vhosts loglarını sil
del "C:\Inetpub\vhosts\*.log" /f /s /q

REM 30 gün ve daha eski .uzanti uzantılı dosyaları sil
FORFILES -p "C:\vesaire\yol" -s -m *.uzanti -d -30 -c "CMD /C del @FILE"

REM Ör. eski mailleri silmede vs kullanılabilir
FORFILES -p "C:\vesaire\mailroot yolu" -s -m *.MAI -d -30 -c "CMD /C del @FILE"

REM Yardım: forfiles /?

REM XP 'de;
REM     Yoksa ftp://ftp.microsoft.com/ResKit/y2kfix/x86/ adresinden edinilebilir
REM     Parametre harfi ve değeri arasındaki boşluklar olmamalı (-p "yol/..." değil de -p"yol/...")
REM     Yardım : sadece forfiles


REM Defrag C and D drives & shutdown - for Windows (save as *.cmd/*.bat)
REM Windows 7:
defrag C: D: /H /U /V /X > %userprofile%\desktop\defrag_%date%.log
shutdown /s

REM Exact match file/folder name search
REM Type name:="test.etc" into the search textbox in GUI (Türkçe Windows: ad:="test.etc")
forfiles /s /m "test.etc"