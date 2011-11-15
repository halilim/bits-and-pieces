# More
# * http://www.pixelbeat.org/cmdline.html

#Apache restart
/etc/init.d/httpd restart

# Klas�r ya da dosyan�n owner/group'unu de�i�tirmek
chown [OPTION]... [OWNER][:[GROUP]] FILE..

# �rnekler
chown 33:33 dosya.vs
# -> dosya.vs nin owner ve group'u 33 uid'li kullan�c�

chown -R vs_com:apache deneme/
# -> deneme klas�r� ve t�m i�indekiler owner vs_com, group apache

chown -R client:psacln *
# -> bulunulan klas�r�n i�indeki her �ey owner client, group psacln


# chmod �rnekleri

chmod -R 0777 cache/
# -> cache dizini ve i�indekileri recursive olarak 0777 yap

chmod -R og-w *
# -> Sahip hari� yazma izinlerini kald�r
# (u: user (you), g: group, o: other, a:all)

find . -type d -exec chmod 755 {} \;
# -> T�m klas�rleri 0777 yap

# unix numeric file modes (dosya/klas�r izinleri)
 
# USER     GROUP    OTHER
# r w x    r w x    r w x
# 4 2 1    4 2 1    4 2 1
# r: read, w: write, x:execute

# �rnekler : 0775, 0440 etc
# ba�taki 0 �nemli, octal oldu�unu g�sterir (octal olmas� gerekir)
# klas�rlerde x izni verilmezse klas�r a��lamaz (listelenemez)


# En �ok i�lemci yiyen i�lemler
top

# Debian version
cat /etc/debian_version

# Centos 32 mi 64 m�
uname -a
# (��kt�da _64 ler ge�iyorsa 64't�r)


# root yetkili kullan�c� ekle
adduser -u 0 -o -g 0 -G 0,1,2,3,4,6,10 -M kullanici_adi
# http://labtestproject.com/create_root_user_account


# .tgz s�k��t�r�lm��lar�n� ��kartmak
tar zxvf <dosya ad�>
# ( ba�ka param verilmedi�inden bulunulan klas�re ��kar�r )

# Bir klas�r� s�k��t�rmak
tar -czvf a.tgz *
tar -cjvf a.tar.bz2 *

# ssh port de�i�tirmek
# 1. vi /etc/ssh/sshd_config
# 2. #Port 22 -> Port #####
# 3. /etc/init.d/sshd restart
# 4. Bulundu�un ba�lant�y� kapatmadan yeni port ile dene
# 5. Olmuyorsa iptables, firewall v.b. kontrol et
# 6. Yine olmazsa de�i�iklikleri geri al
# 7. Bundan �nceki �� maddeyi uygulamazsan giri�i tamamen kaybedebilirsin

# 80 porta ba�lanan IP�leri ba�lant� say�s�na g�re s�rala ve toplam� g�ster
netstat -plan|grep :80|awk {'print $5'}|cut -d: -f 1|sort|uniq -c|sort -nk 1
