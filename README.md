## Telepítés

### COMPOSER
- composer install futtatása

### .ENV beállítása:
- .env.example fájl mintájára létrehozni egy .env fájlt és a következő paramétereket megadni
- adatbázis kapcsolat meghatározása
- APP_NAME beállítása pl: Carservice
- APP_URL beállítása pl: http://carservice.test
- php artisan key:generate - parancs futtatása

### ADATBÁZIS
- php artisan migrate - parancs futtatása az adatbázis migrációk lefuttatásához
- php artisan db:seed - az adatbázis feltöltése a teszt adatokkal (amennyiben ez a lépés kimarad, az applikáció első futáskor elvégzi autómatikusan!)

### Futtatás

- php artisan server - parancs futtatása

## Forrásfájlok

- A feladathoz kapott forrásfájlok a storage/app/json mappában találhatóak.
- A teljes adatbázis szerkezet dump-ja pedig a storage/app/database mappában található.
