# X-Delegacja

Proste API do tworzenia delegacji

# Instalacja

## Docker
1. Zainstaluj wszystkie zależności composera: composer install.
2. Zbuduj dokera `./vendor/bin/sail build --no-cache`.
3. Uruchom skrypt konfiguracji Dockera: `./vendor/bin/sail up`.
4. Uruchom skrypt migracji bazy danych: `./vendor/bin/sail migrate --seed`.


## Lokalnie
Dla lokalnej konfiguracji wymagane są:

`PHP 8.1 lub nowszy`

`Composer 2`

`MySQL/SQlite/MariaDB`

1. Zainstaluj wszystkie zależności composera: composer install.
2. Skopiuj przykładowy plik środowiskowy i dokonaj wymaganych zmian konfiguracji w pliku .env: cp .env.example .env.
3. Wygeneruj nowy klucz aplikacji: `php artisan key:generate`.
4. Uruchom swój serwer MySQL i ustaw odpowiednie konfiguracje w pliku .env.
5. Uruchom skrypt migracji bazy danych: `php artisan migrate --seed`.
6. Uruchom aplikację: `php artisan serve`.

## Testowanie

Po zakończeniu instalacji możesz przeprowadzić testy.

Dla konfiguracji z Dockerem użyj: `./vendor/bin/sail test`

Dla lokalnej konfiguracji użyj: `php artisan test`

## Zmienne środowiskowe

`WORKER_ID_LENGTH=32 # Długość identyfikatora pracownika`

`COMPANY=X # Nazwa firmy`

`DELEGATION_CURRENCY=PLN # Waluta delegacji`

`DELEGATION_HOURS=8 # Liczba godzin na delegacji`

`DELEGATION_BONUS_RATE=2 # Współczynnik bonusu`

`DELEGATION_BONUS_DAYS=7 # Liczba dni bonusowych`

## API

### Tworzenie pracownika

- **URL:** `/api/v1/workers`
- **Metoda:** `POST`
- **Parametry:** Brak
- **Body:**
 ```json
    {
     "status":"success",
     "data":
     {
      "id":"id_pracownika",
      "company":"X"
     }
    }
 ```



### Tworzenie delegacji

- **URL:** `/api/v1/delegations`
- **Metoda:** `POST`
- **Parametry:**
    - `worker_id` - (wymagany) identyfikator pracownika
    - `start` - (wymagany) data rozpoczęcia delegacji w formacie `Y-m-d H:i:s`
    - `end` - (wymagany) data zakończenia delegacji w formacie `Y-m-d H:i:s`
    - `country` - (wymagany) kod ISO kraju delegacji
- **Body:**
  ```json
  {
    "worker_id": "id_pracownika",
    "start": "data_rozpoczęcia",
    "end": "data_zakończenia",
    "country": "kod_iso_kraju"
  }

### Pobieranie delegacji

- **URL:** `/api/v1/delegations`
- **Metoda:** `GET`


### Kody HTTP

*200 Success*

*404 Not Found*

*405 Method Not Allowed*

*409 Conflict*

*422 Unprocessable Entity*
