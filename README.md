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

Entrega_1 adarrera aldatu:
```bash
$ git checkout entrega_1
```

'web' irudia eraiki:
```bash
$ docker build -t="web"
```

Zerbitzuak hedatu docker-compose erabiliz:
```bash
$ docker-compose up
```

Beharrezko datu-basea konfiguratzeko:
  1. phpMyAdmin bisitatu hurrengo URL-a erabiliz: **http://localhost:8890/**
  2. Identifikatu:
     - Erabiltzailea: admin
     - Pasahitza: test
  3. "database" sakatu, "import" aukeratu eta biltegian dagoen 'database.sql' artxiboa hautatu.

Web sistemako 'home' orrialdea bisitatzeko: **http://localhost:81/**

Amaitzerakoan zerbitzuak gelditzeko:
```bash
$ docker-compose down
```