
# Online Sınav Sistemi v0.0.1
Fırat Üniversitesi, Yazılım Mühendisliği olarak alınan Bilgi Sistemleri ve Güvenliği ders kapsamında yapılan Online Sınav Sistemi kaynak kodlarıdır.



### Kullanılan Diller

- Php ( Temel Düzey ) 
- MySQL ( Temel Düzey )
- JavaScript ( Temel Düzey )



# Kurulum
     
     
 
- detayli_sonuc.php
- questionAnswer.php
- scoreboard.php
- index_js.php


 Yukarıda yer alan .php dosyalarının sayfa başlarında yer alan MySQL veritabanı bağlantısı için gerekli olan PDO adaptörü ayarları yer almaktadır.
Bu ayarları kullandığınız Sunucu veya PHP geliştirme ortamda kullandığını ayarlara göre değiştirmeniz gerekmektedir.


```php
   try {
        $pdo= new PDO("mysql:host=localhost;dbname=TABLO_ADI;charset=utf8","VERİ_TABANİ_KULLANICI_ADI","VERİ_TABANİ_KULLANICI_ŞİFRESİ@",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
    } catch ( PDOException $hata ){
        print $hata->getMessage();
    }
```

Veritabanı ayarlamalarını yaptıktan sonra belirlediğiniz veri tabanına quiz_db.sql Import edilmesi.

Import işleminin başarılı bir şekilde gerçekleştirdikten sonra skortablosu.html dizinden silmeniz durumunda Sınav Başlama arayüzü ile karşılacaksınız.


![](https://raw.githubusercontent.com/BedirhanERKAN/online-sinav-sistemi/master/ana-ekran.png)

> skortablosu.html silmeniz durumunda karşılaşmanız gereken ekran.


![](https://raw.githubusercontent.com/BedirhanERKAN/online-sinav-sistemi/master/not-ekran.png)

> Sınavı tamamlamak için kullanacağınız 'scoreboard.php' sayfasını tetiklemeniz durumunda Skor Tablosu oluşturarak, ana ekranda gözükecektir.


# Önemli Noktalar

> log klasörü altında sınava giren kişilerin cevaplandırdığı şıklar ve sorular bulunmaktadır.

> Sınavı tamamladıktan sonra sistem otomatik olarak arka planda questionAnswer.php dosyasına POST işlemi gerçekleştirmektedir.

> index_js.php içerisinde yer alan Php ve SQL kodları ile soruların rastgelmesini, soru başına düşen süreyi ayarlayabilirsiniz.

> Dosyaları çalıştırığınızda kesinlikle .htaccess olmasına dikkat ediniz. index.js dosyasının görevini index_js.php yapmaktadır. Bu görevi arka planda yönlendirme işlemi yaparak gerçekleştirmektedir.
