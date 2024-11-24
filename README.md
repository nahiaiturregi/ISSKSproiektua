## Taldekideak
Laura Meihua Caballero Pascual  
Nahia Iturregi Artiñano  
Unai Rodríguez Cubillo  
Eider Yan Santamaria Salvador  
Nahia Valiente Camiños

## Proiektua hedatzeko instrukzioak
GitHub biltegia klonatu:
```bash
$ git clone https://github.com/nahiaiturregi/ISSKSproiektua.git
```

Terminalean klonatutako biltegiaren direktoriora joan.

Direktorioaren barruan .env fitxategia igo edo konfiguratu inguruneko aldagai ezkutuak modu egokian konfiguratu eta erabili ahal izateko.

Entrega_2 adarrera aldatu:
```bash
$ git checkout entrega_2
```

'web' irudia eraiki:
```bash
$ sudo docker build -t="web" .
```

Zerbitzuak hedatu docker-compose erabiliz:
```bash
$ docker-compose up
```

Beharrezko datu-basea konfiguratzeko:
  1. phpMyAdmin bisitatu hurrengo URL-a erabiliz: **http://localhost:8890/**
  2. Identifikatu:
     - Erabiltzailea: .env fitxategian adierazitakoa
     - Pasahitza: .env fitxategian adierazitakoa
  3. "database" sakatu, "import" aukeratu eta biltegian dagoen 'database.sql' artxiboa hautatu.

Web sistemako 'home' orrialdea bisitatzeko: **https://localhost:81/**

Konexioaren konfidantza faltari buruz abisatzen duen mezu bat agertu daiteke, hala ere, konexioa onartu sistemara sartu ahal izateko. Gerta daiteke sistemaren zertifikatua nabigatzailearen konfidantzazko zertifikatuen zerrendan sartu behar izatea. Firefox-en hori egiteko:
  1. about:preferences#privacy bisitatu nabigatzailetik.
  2. 'Certificados' atalera joan eta 'Ver certificados' sakatu.
  3. 'Importar' sakatu eta klonatutako errepositorioan 'cert' karpetan dagoen 'cert.crt' hautatu.
  4. Nabigatzailea berabiarazi.

Amaitzerakoan zerbitzuak gelditzeko:
```bash
$ docker-compose down
```

## Erabilitako baliabideak
Proiektua aurrera eramateko erabilitako baliabideak:
  - register.php artxiboa idazteko: https://www.youtube.com/watch?v=VgLOIocrNq8