-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 02 Şub 2024, 19:42:02
-- Sunucu sürümü: 10.4.27-MariaDB
-- PHP Sürümü: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `dijitalurun`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin`
--

CREATE TABLE `admin` (
  `adminid` int(11) NOT NULL,
  `adminkadi` varchar(300) DEFAULT NULL,
  `adminposta` varchar(300) DEFAULT NULL,
  `adminsifre` varchar(300) DEFAULT NULL,
  `adminkodu` varchar(300) DEFAULT NULL,
  `adminekleyen` varchar(300) DEFAULT NULL,
  `adminyetki` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 admin 2 kullanıcı',
  `ekleme` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 izinli 2 izin verilmedi',
  `duzenleme` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 izinli 2 izin verilmedi',
  `silme` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 izinli 2 izin verilmedi',
  `listeleme` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 izinli 2 izin verilmedi'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ayarlar`
--

CREATE TABLE `ayarlar` (
  `id` int(11) NOT NULL,
  `site_baslik` varchar(300) DEFAULT NULL,
  `site_url` varchar(300) DEFAULT NULL,
  `site_admin_url` varchar(300) DEFAULT NULL,
  `site_logo` varchar(300) DEFAULT NULL,
  `site_favicon` varchar(300) DEFAULT NULL,
  `site_footer` text DEFAULT NULL,
  `site_gecerli_smtp` int(11) DEFAULT NULL,
  `site_gecerli_pos` int(11) DEFAULT NULL,
  `site_gecerli_sms` int(11) DEFAULT NULL,
  `smsbildirim` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif',
  `mailbildirim` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif',
  `adres` text DEFAULT NULL,
  `tel` varchar(300) DEFAULT NULL,
  `whatsapp` varchar(300) DEFAULT NULL,
  `mail` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `loglar`
--

CREATE TABLE `loglar` (
  `logid` int(11) NOT NULL,
  `logbaslik` varchar(300) DEFAULT NULL,
  `logaciklama` text DEFAULT NULL,
  `logekleyen` varchar(300) DEFAULT NULL,
  `logtarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `logtarihpanel` varchar(300) DEFAULT NULL,
  `logip` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `odemeturleri`
--

CREATE TABLE `odemeturleri` (
  `oid` int(11) NOT NULL,
  `okodu` varchar(300) DEFAULT NULL,
  `oadi` varchar(300) DEFAULT NULL,
  `osef` varchar(300) DEFAULT NULL,
  `otarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `oekleyen` varchar(300) DEFAULT NULL,
  `odurum` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `posfirmalari`
--

CREATE TABLE `posfirmalari` (
  `posid` int(11) NOT NULL,
  `posmerchantkey` varchar(300) DEFAULT NULL,
  `posmerchantsalt` varchar(300) DEFAULT NULL,
  `posmerchantid` varchar(300) DEFAULT NULL,
  `posadi` varchar(300) DEFAULT NULL,
  `possef` varchar(300) DEFAULT NULL,
  `ekleyen` varchar(300) DEFAULT NULL,
  `durum` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif',
  `tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `basariliurl` varchar(300) DEFAULT NULL,
  `hataurl` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `sayfalar`
--

CREATE TABLE `sayfalar` (
  `sayfaid` int(11) NOT NULL,
  `sayfaadi` varchar(300) DEFAULT NULL,
  `sayfasef` varchar(300) DEFAULT NULL,
  `sayfaicerik` longtext DEFAULT NULL,
  `sayfadurum` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif',
  `sayfaekleyen` varchar(300) DEFAULT NULL,
  `sayfatarih` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `sipid` int(11) NOT NULL,
  `sipno` varchar(300) DEFAULT NULL,
  `sipuye` varchar(300) DEFAULT NULL,
  `sipurun` varchar(300) DEFAULT NULL,
  `siptutar` double(15,2) DEFAULT NULL,
  `siptarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `siptarihs` varchar(300) DEFAULT NULL,
  `sipmusterinot` text DEFAULT NULL,
  `sipdurum` varchar(300) DEFAULT NULL,
  `sipodemekodu` varchar(300) DEFAULT NULL,
  `siparissonrasi` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `smsfirmalari`
--

CREATE TABLE `smsfirmalari` (
  `smsid` int(11) NOT NULL,
  `smsfirma` varchar(300) DEFAULT NULL,
  `smsfirmasef` varchar(300) DEFAULT NULL,
  `smsbaslik` varchar(300) DEFAULT NULL,
  `smskadi` varchar(300) DEFAULT NULL,
  `smsikincibaslik` varchar(300) DEFAULT NULL,
  `smssifre` varchar(300) DEFAULT NULL,
  `smsdurum` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2pasif',
  `smstarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `smsekleyen` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `smtpbilgileri`
--

CREATE TABLE `smtpbilgileri` (
  `smtp_id` int(11) NOT NULL,
  `smtp_mail` varchar(300) DEFAULT NULL,
  `smtp_sec` varchar(300) DEFAULT NULL,
  `smtp_port` varchar(300) DEFAULT NULL,
  `smtp_host` varchar(300) DEFAULT NULL,
  `smtp_sifre` varchar(300) DEFAULT NULL,
  `smtp_ekleyen` varchar(300) DEFAULT NULL,
  `smtp_tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `smtp_durum` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `urun_id` int(11) NOT NULL,
  `urun_adi` varchar(300) DEFAULT NULL,
  `urun_sef` varchar(300) DEFAULT NULL,
  `urun_resim` varchar(300) DEFAULT NULL,
  `urun_fiyat` double(15,2) DEFAULT NULL,
  `urun_stok` int(11) NOT NULL DEFAULT 1,
  `urun_kdv` tinyint(3) NOT NULL DEFAULT 20 COMMENT '1 8 18 20 gibi oranlar',
  `urun_kodu` varchar(300) DEFAULT NULL,
  `urun_demo` text DEFAULT NULL,
  `urun_yonetimdemo` text DEFAULT NULL,
  `urun_demokadi` varchar(300) DEFAULT NULL,
  `urun_demosifre` varchar(300) DEFAULT NULL,
  `urun_demoyonetimkadi` varchar(300) DEFAULT NULL,
  `urun_demoyonetimsifre` varchar(300) DEFAULT NULL,
  `urun_tarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `urun_durum` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif',
  `urun_icerik` longtext DEFAULT NULL,
  `urun_ekleyen` varchar(300) DEFAULT NULL,
  `urun_indirmelink` text DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunozellikler`
--

CREATE TABLE `urunozellikler` (
  `ozid` int(11) NOT NULL,
  `ozurun` varchar(300) DEFAULT NULL,
  `ozbaslik` varchar(300) DEFAULT NULL,
  `ozicerik` text DEFAULT NULL,
  `oztarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `ozekleyen` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunresimler`
--

CREATE TABLE `urunresimler` (
  `resid` int(11) NOT NULL,
  `resurun` varchar(300) DEFAULT NULL,
  `resdosya` varchar(300) DEFAULT NULL,
  `restarih` timestamp NOT NULL DEFAULT current_timestamp(),
  `resekleyen` varchar(300) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `uyeler`
--

CREATE TABLE `uyeler` (
  `uye_id` int(11) NOT NULL,
  `uye_kodu` varchar(300) DEFAULT NULL,
  `uye_adi` varchar(300) DEFAULT NULL,
  `uye_soyadi` varchar(300) DEFAULT NULL,
  `uye_tel` varchar(300) DEFAULT NULL,
  `uye_mail` varchar(300) DEFAULT NULL,
  `uye_sifre` varchar(300) DEFAULT NULL,
  `uye_tarih` timestamp NULL DEFAULT current_timestamp(),
  `uye_durum` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1 aktif 2 pasif'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`adminid`);

--
-- Tablo için indeksler `ayarlar`
--
ALTER TABLE `ayarlar`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `loglar`
--
ALTER TABLE `loglar`
  ADD PRIMARY KEY (`logid`);

--
-- Tablo için indeksler `odemeturleri`
--
ALTER TABLE `odemeturleri`
  ADD PRIMARY KEY (`oid`);

--
-- Tablo için indeksler `posfirmalari`
--
ALTER TABLE `posfirmalari`
  ADD PRIMARY KEY (`posid`);

--
-- Tablo için indeksler `sayfalar`
--
ALTER TABLE `sayfalar`
  ADD PRIMARY KEY (`sayfaid`);

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`sipid`);

--
-- Tablo için indeksler `smsfirmalari`
--
ALTER TABLE `smsfirmalari`
  ADD PRIMARY KEY (`smsid`);

--
-- Tablo için indeksler `smtpbilgileri`
--
ALTER TABLE `smtpbilgileri`
  ADD PRIMARY KEY (`smtp_id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urun_id`);

--
-- Tablo için indeksler `urunozellikler`
--
ALTER TABLE `urunozellikler`
  ADD PRIMARY KEY (`ozid`);

--
-- Tablo için indeksler `urunresimler`
--
ALTER TABLE `urunresimler`
  ADD PRIMARY KEY (`resid`);

--
-- Tablo için indeksler `uyeler`
--
ALTER TABLE `uyeler`
  ADD PRIMARY KEY (`uye_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `admin`
--
ALTER TABLE `admin`
  MODIFY `adminid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `ayarlar`
--
ALTER TABLE `ayarlar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `loglar`
--
ALTER TABLE `loglar`
  MODIFY `logid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `odemeturleri`
--
ALTER TABLE `odemeturleri`
  MODIFY `oid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `posfirmalari`
--
ALTER TABLE `posfirmalari`
  MODIFY `posid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `sayfalar`
--
ALTER TABLE `sayfalar`
  MODIFY `sayfaid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `sipid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `smsfirmalari`
--
ALTER TABLE `smsfirmalari`
  MODIFY `smsid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `smtpbilgileri`
--
ALTER TABLE `smtpbilgileri`
  MODIFY `smtp_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urunozellikler`
--
ALTER TABLE `urunozellikler`
  MODIFY `ozid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `urunresimler`
--
ALTER TABLE `urunresimler`
  MODIFY `resid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Tablo için AUTO_INCREMENT değeri `uyeler`
--
ALTER TABLE `uyeler`
  MODIFY `uye_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
