# More
# * http://www.pixelbeat.org/cmdline.html

# !!!NOT: * -> . ile baþlayanlarý içermez (ör. .htaccess)

#Apache restart
/etc/init.d/httpd restart

# Klasör ya da dosyanýn owner/group'unu deðiþtirmek
chown [OPTION]... [OWNER][:[GROUP]] FILE..

# Örnekler
chown 33:33 dosya.vs
# -> dosya.vs nin owner ve group'u 33 uid'li kullanýcý

chown -R vs_com:apache deneme/
# -> deneme klasörü ve tüm içindekiler owner vs_com, group apache

find '!' -name '.' -exec chown client:psacln {} \+
# -> bulunulan klasörün içindeki her þey owner client, group psacln
# eski: chown -R client:psacln * -> .* dosyalarý dahil etmiyordu (ör. .htaccess)

# chmod Örnekleri

chmod -R 0777 cache/
# -> cache dizini ve içindekileri recursive olarak 0777 yap

find '!' -name '.' -exec chmod og-w {} \+
# -> Bulunulan klasördeki her þeyde sahip hariç yazma izinlerini kaldýr
# (u: user (you), g: group, o: other, a:all)

find . -type d -exec chmod 755 {} \+
# -> Tüm klasörleri 0777 yap

# unix numeric file modes (dosya/klasör izinleri)
 
# USER     GROUP    OTHER
# r w x    r w x    r w x
# 4 2 1    4 2 1    4 2 1
# r: read, w: write, x:execute

# örnekler : 0775, 0440 etc
# baþtaki 0 önemli, octal olduðunu gösterir (octal olmasý gerekir)
# klasörlerde x izni verilmezse klasör açýlamaz (listelenemez)


# En çok iþlemci yiyen iþlemler
top

# Debian version
cat /etc/debian_version

# Centos 32 mi 64 mü
uname -a
# (çýktýda _64 ler geçiyorsa 64'tür)


# root yetkili kullanýcý ekle
adduser -u 0 -o -g 0 -G 0,1,2,3,4,6,10 -M kullanici_adi
# http://labtestproject.com/create_root_user_account


# .tgz sýkýþtýrýlmýþlarýný çýkartmak
tar zxvf <dosya adý>
# ( baþka param verilmediðinden bulunulan klasöre çýkarýr )

# Bir klasörü sýkýþtýrmak
tar -czvf a.tgz .
tar -cjvf a.tar.bz2 .

# ssh port deðiþtirmek
# 1. vi /etc/ssh/sshd_config
# 2. #Port 22 -> Port #####
# 3. /etc/init.d/sshd restart
# 4. Bulunduðun baðlantýyý kapatmadan yeni port ile dene
# 5. Olmuyorsa iptables, firewall v.b. kontrol et
# 6. Yine olmazsa deðiþiklikleri geri al
# 7. Bundan önceki üç maddeyi uygulamazsan giriþi tamamen kaybedebilirsin

# 80 porta baðlanan IP’leri baðlantý sayýsýna göre sýrala ve toplamý göster
netstat -plan|grep :80|awk {'print $5'}|cut -d: -f 1|sort|uniq -c|sort -nk 1
