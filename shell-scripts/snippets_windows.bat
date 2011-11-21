REM Tüm vhosts loglarýný sil
del "C:\Inetpub\vhosts\*.log" /f /s /q

REM 30 gün ve daha eski .uzanti uzantýlý dosyalarý sil
FORFILES -p "C:\vesaire\yol" -s -m *.uzanti -d -30 -c "CMD /C del @FILE"

REM Ör. eski mailleri silmede vs kullanýlabilir
FORFILES -p "C:\vesaire\mailroot yolu" -s -m *.MAI -d -30 -c "CMD /C del @FILE"

REM Yardým: forfiles /?

REM XP 'de;
REM     Yoksa ftp://ftp.microsoft.com/ResKit/y2kfix/x86/ adresinden edinilebilir
REM     Parametre harfi ve deðeri arasýndaki boþluklar olmamalý (-p "yol/..." deðil de -p"yol/...")
REM     Yardým : sadece forfiles


REM Defrag C and D drives & shutdown - for Windows (save as *.cmd/*.bat)
REM Windows 7:
defrag C: D: /H /U /V /X > %userprofile%\desktop\defrag_%date%.log
shutdown /s
