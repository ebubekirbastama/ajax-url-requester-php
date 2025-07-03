🌐 AJAX URL Requester - PHP + cURL 🚀
=====================================

Bu proje, PHP ve AJAX kullanarak alt alta verilen URL'lere belirlenen aralıklarla HTTP istek gönderen, sonuçları anlık olarak ekranda renkli ve simgeli şekilde gösteren hafif ve modern bir sistemdir.

💡 Özellikler:
--------------
✅ Bootstrap 5 responsive ve modern arayüz  
✅ PHP cURL ile sağlam bağlantı ve hata yönetimi  
✅ AJAX ile gerçek zamanlı log akışı (sayfa yenilenmez)  
✅ HTTP status kodlarına göre renkli simge ve log gösterimi  
✅ Yüzdelik ilerleme barı ile takip kolaylığı  
✅ Minimum bağımlılık (Sadece PHP 7+ ve internet yeterli)  

🔧 Kullanım:
------------
1. Tüm dosyaları sunucuya yükleyin (index.php ve process.php aynı dizinde olmalı)  
2. `index.php` üzerinden erişim sağlayın  
3. Alt alta URL'leri girin, bekleme süresini (dakika) belirleyin ve "Başlat" butonuna tıklayın  
4. İşlem süresince loglar anlık olarak görünür, her isteğin sonucu renkli şekilde işaretlenir  
5. Yüzdelik ilerleme barı ile genel durum takip edilir  

🎯 HTTP Status Kodlarına Göre Simge ve Renkler:
------------------------------------------------
🟢 200 - 299: Başarılı istek (Yeşil)  
🟡 300 - 399: Yönlendirme (Turuncu)  
🔴 400 - 599: Hatalı istek (Kırmızı)  

📁 Dosya Yapısı:
----------------
- `index.php` : Arayüz ve AJAX yönetimi  
- `process.php` : İstek işlemleri ve cURL entegrasyonu  


⚡ Gereksinimler:
-----------------
- PHP 7.0 veya üzeri  
- İnternet bağlantısı  
- Modern tarayıcı (Chrome, Firefox, Edge önerilir)  


👨‍💻 Katkıda Bulunmak:
----------------------
Pull request veya issue açarak geliştirme sürecine katkıda bulunabilirsiniz.

🌟 İyi kullanımlar dilerim!
