REM T�m vhosts loglar�n� sil
del "C:\Inetpub\vhosts\*.log" /f /s /q

REM 30 g�n ve daha eski .uzanti uzant�l� dosyalar� sil
FORFILES -p "C:\vesaire\yol" -s -m *.uzanti -d -30 -c "CMD /C del @FILE"

REM �r. eski mailleri silmede vs kullan�labilir
FORFILES -p "C:\vesaire\mailroot yolu" -s -m *.MAI -d -30 -c "CMD /C del @FILE"

REM Yard�m: forfiles /?

REM XP 'de;
REM     Yoksa ftp://ftp.microsoft.com/ResKit/y2kfix/x86/ adresinden edinilebilir
REM     Parametre harfi ve de�eri aras�ndaki bo�luklar olmamal� (-p "yol/..." de�il de -p"yol/...")
REM     Yard�m : sadece forfiles


REM Defrag C and D drives & shutdown - for Windows (save as *.cmd/*.bat)
REM Windows 7:
defrag C: D: /H /U /V /X > %userprofile%\desktop\defrag_%date%.log
shutdown /s
