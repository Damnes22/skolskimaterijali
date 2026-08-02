# 📚 ANALIZA APLIKACIJE "Školski Materijali"

## 🔍 PREGLED APLIKACIJE

**Školski Materijali** je web aplikacija za upravljanje školskim materijalima, izgrađena sa **PHP-om** i **MySQL bazom podataka**. Aplikacija omogućava administratorima da kreiraju predmete, učenike i učitavaju materijale, dok učenici mogu preuzimati materijale za svoje predmete.

---

## 🏗️ ARHITEKTURA APLIKACIJE

### Tip aplikacije
- **Backend**: PHP (proceduralni stil sa OOP elementima)
- **Frontend**: Tailwind CSS, HTML5, JavaScript (vanilla)
- **Baza podataka**: MySQL (InfinityFree hosting)
- **Stil**: Dark theme sa gradijentima

### Hosting
- **Server**: InfinityFree (sql309.infinityfree.com)
- **Database**: `if0_39924349_skolskimaterijali`
- **Kredencijali**: Sprema se u `config.php`

---

## 📁 STRUKTURA DATOTEKA

```
SkolskiMaterijaliBackup/
├── config.php              # Konfiguracija baze podataka
├── index.php               # Glavna stranica (master admin)
├── admin_dashboard.php     # Admin panel za non-master adminne (NEW)
├── migrations.php          # Migracijska datoteka za ažuriranje baze (NEW)
├── login.php               # Stranica za prijavu
├── logout.php              # Odjava korisnika
├── init_users.php          # Inicijalizacija default korisnika
├── upload.php              # Stara stranica za upload
├── subject.php             # Prikaz materijala po predmetu
├── update_user.php         # AJAX endpoint za update korisnika
├── load_subjects.php       # AJAX endpoint za učitavanje predmeta
├── modals.php              # Modali HTML
└── uploads/                # Direktorij za uploadane fajlove
```

---

## 🏢 MULTI-TENANT ADMIN SISTEM (NOVO)

Aplikacija je sada pre-strukturirana da podrži multi-tenant arhitekturu sa master adminima i non-master adminima.

### 📊 Kako sistem radi

1. **Master Admin** (početni admin):
   - Pristupa `index.php`
   - Može kreirajti nove administratore
   - Može vidjeti sve predmete, učenike i materijale
   - Svaki admin koji kreira dobija `parent_admin_id`

2. **Non-Master Admin** (kreiraj od strane master admina):
   - Pristupa `admin_dashboard.php`
   - Može kreirajti samo učenike (NE nove adminne)
   - Vidi samo svoje predmete, učenike i materijale
   - `parent_admin_id` je ID master admina koji ga je kreirad

3. **Student** (učenik):
   - Pristupa `index.php`
   - Vidi samo predmete dodijeljene od strane njihovog admina
   - Može preuzemet materijale i predavati radove

### 🔄 Redirekcija nakon prijave

- **Master Admin** → `index.php` (bez parent_admin_id)
- **Non-Master Admin** → `admin_dashboard.php` (sa parent_admin_id)
- **Student** → `index.php` (kao standardan student)

### 🗄️ Nove kolone u bazi podataka

- `users.parent_admin_id` - ID admina koji je kreirad ovog admina
- `subjects.admin_id` - ID admina kojem pripada predmet
- `files.admin_id` - ID admina kojem pripada fajl
- `tests.admin_id` - ID admina kojem pripada test
- `student_works.admin_id` - ID admina kojem pripada rad učenika

### ⚙️ Kako pokrenuti migracije

1. Otvorite pregledar
2. Idite na: `http://localhost/migrations.php` (ili vaša URL)
3. Provjerite da li su sve migracije izvršene uspješno
4. Ako već postoje kolone, one će biti preskočene

---

## 🔐 SIGURNOST

### Implementirane mjere
1. **CSRF zaštita**: Koristi `$_SESSION['csrf_token']` za sve POST zahtjeve
2. **Password hashing**: `password_hash()` sa `PASSWORD_DEFAULT` (bcrypt)
3. **SQL Injection zaštita**: Koristi `prepared statements` (`bind_param()`)
4. **Session validacija**: Provjera `$_SESSION['user_id']` i uloge
5. **Role-based access control**: Razlikovanje između `admin` i `student` uloga

### Potencijalni problemi
⚠️ Otvorene baze podataka kredencijale u `config.php` (vidljive u kodu)
⚠️ Nedostaje HTTPS zahtjev (trebao bi `force_https`)
⚠️ Nema rate limitinga za login pokušaje

---

## 👥 KORISNIČKI SISTEMI

### Uloge
1. **Admin** - Puna kontrola:
   - Kreiraj/obriši predmete
   - Kreiraj/obriši/izmijeni korisnike
   - Upload/brisanje materijala
   - Dodjeli predmete učenicima

2. **Student** - Limitirani pristup:
   - Pregled samo svojih predmeta
   - Preuzimanje materijala
   - Nema mogućnosti kreiranja ili brisanja

### Default korisnici (init_users.php)
- **admin** / **admin123** (admin)
- **ucenik** / **ucenik** (student)

---

## 🗄️ BAZA PODATAKA

### Očekivane tabele (nisu eksplicitno prikazane u kodu, ali se koriste)

```sql
-- Korisnici
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) UNIQUE,
    password VARCHAR(255),
    role ENUM('admin', 'student')
);

-- Predmeti
CREATE TABLE subjects (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255),
    is_archived TINYINT(1) DEFAULT 0
);

-- Materijali/Fajlovi
CREATE TABLE files (
    id INT PRIMARY KEY AUTO_INCREMENT,
    subject_id INT,
    filename VARCHAR(255),
    filepath VARCHAR(255),
    uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);

-- Korisnički predmeti
CREATE TABLE user_subjects (
    user_id INT,
    subject_id INT,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (subject_id) REFERENCES subjects(id)
);
```

---

## 🎯 GLAVNE FUNKCIONALNOSTI

### 1. **Autentifikacija** (login.php)
- Login sa username/password
- Password verification sa bcrypt
- Session postavljanje sa `user_id`, `username`, `role`
- Preusmjeravanje na index.php nakon uspješne prijave

### 2. **Upravljanje predmetima** (index.php - POST/GET)
- ➕ **Kreiranje**: `POST /index.php` sa `new_subject`
- 🗑️ **Brisanje**: `GET /index.php?delete_subject=ID`
- 📋 **Učitavanje**: Prema ulozi (admin vidi sve, student samo svoje)

### 3. **Upravljanje korisnicima** (index.php + update_user.php)
- ➕ **Kreiranje**: `POST /index.php` sa `new_user`
- ✏️ **Izmjena**: `POST /index.php` sa `edit_user_id`
- 🗑️ **Brisanje**: `GET /index.php?delete_user=ID`
- Dodjela predmeta studentima preko `user_subjects` tabele

### 4. **Upload materijala** (index.php - POST/GET)
- Drag-and-drop interface
- Validacija tipa fajla (14 tipova dozvojenih)
- Ograničenje veličine: max 10MB
- Sprema: `uploads/TIMESTAMP_filename`
- Brisanje: `GET /index.php?delete_file=ID`

### 5. **Preuzimanje materijala**
- Direktna linija do fajla iz `files` tabele
- `target="_blank"` za otvaranje u novoj kartici

---

## 🎨 FRONTEND KARAKTERISTIKE

### Design
- **Dark theme**: Sivo-plava boja (`#1a1a2e`, `#162447`, `#1f4068`)
- **Gradijent pozadina**: Animirani gradijent za header
- **Tailwind CSS**: Za sav styling
- **Responsive**: Mobile-first pristup sa special klasama za mobilne uređaje

### Komponente
1. **Header**: Korisničko ime, uloga, dugmići za akcije
2. **Predmeti sekcija**: Lista predmeta sa mogućnošću brisanja (admin)
3. **Materijali sekcija**: Lista fajlova sa preuzimanjem i brisanjem
4. **Modali**:
   - 📤 Upload fajla
   - ➕ Kreiraj korisnika
   - 🛠 Upravljaj korisnicima
   - ✏️ Izmijeni korisnika

### Animacije
- `animate-fadeIn`: Fade-in efekt za poruke
- `btn-hover`: Lift efekt na dugmićima
- Smooth transitions na svim elementima

---

## ⚙️ KLJUČNE DATOTEKE DETALJNO

### 1. **config.php** (17 linija)
```php
Konekcija na MySQL bazu sa kredencijalima
- Host: sql309.infinityfree.com
- User: if0_39924349
- Pass: cbfsb1KiF12
- DB: if0_39924349_skolskimaterijali
```

### 2. **login.php** (116 linija)
```php
- POST obrada: Provjera username/password
- password_verify() za sigurnost
- Session postavljanje
- HTML forma sa Tailwind CSS
- Dark theme sa istim gradijentima kao index.php
```

### 3. **index.php** (855 linija)
```php
SESIJA I ZAŠTITA:
  - session_start()
  - CSRF token generiranje
  - Provjera user_id i role

POST OBRADA (Admin samo):
  - new_subject: Kreiranje predmeta
  - upload_file: Upload materijala sa validacijom
  - new_user: Kreiranje korisnika
  - edit_user_id: Izmjena korisnika

GET OBRADA (Admin samo):
  - delete_subject=ID
  - delete_file=ID
  - delete_user=ID

BAZA PODATAKA:
  - Učitavanje predmeta (admin vidi sve, student samo svoje)
  - Učitavanje korisnika (admin samo)
  - Učitavanje fajlova za odabrani predmet

HTML/JAVASCRIPT:
  - Kompleksan Tailwind design
  - Drag-and-drop upload sa progress bar
  - Modali sa jQuery (nisu prikazani u ograničenju)
  - Responsive design sa mobile optimizacijom
```

### 4. **init_users.php** (43 linija)
```php
- Default korisnici: admin (admin123), ucenik (ucenik)
- Koristi password_hash() za sigurnost
- Provjera duplikata prije insert
- Direktan ispis poruka o kreiranju
```

### 5. **upload.php** (72 linija)
**NAPOMENA**: Starija verzija, ne koristi se u index.php
- Jednostavnija forma
- Validacija ekstenzije (9 tipova)
- Direktan upload bez progress bar

### 6. **subject.php** (31 linija)
**NAPOMENA**: Direktan prikaz predmeta
- GET /subject.php?id=ID
- Liste fajlove za predmet
- Nema autentifikacije!

### 7. **modals.php** (134 linija)
**NAPOMENA**: Nije pravilno uključen - kod je embedded u index.php
- Upload modal sa drag-and-drop
- Kreiraj korisnika modal
- Upravljaj korisnicima modal (tablica)
- Izmijeni korisnika modal

### 8. **update_user.php** (59 linija)
```php
- AJAX endpoint za update korisnika
- Provjera admin pristupa
- Update username, password, role
- Ažuriranje user_subjects (predmeti)
```

### 9. **load_subjects.php** (29 linija)
```php
- AJAX endpoint za učitavanje predmeta
- Provjera user_id
- Vraća checkboxe sa već dodjeljenim predmetima
```

### 10. **logout.php** (5 linija)
```php
- session_destroy()
- Preusmjeravanje na login.php
```

---

## 🚀 TIJEK IZVRŠAVANJA

### 1. Prvi pristup (login.php)
```
1. Korisnik ide na http://app.local
2. index.php provjerava $_SESSION['user_id']
3. Ako ne postoji, header redirect na login.php
4. Korisnik unosi username/password
5. Login.php proverava u bazi sa password_verify()
6. Ako OK: $_SESSION postavljen + redirect na index.php
7. Ako nije OK: poruka greške "Pogrešna lozinka!" ili "Korisnik ne postoji!"
```

### 2. Prikaz index.php (nakon login)
```
1. Provjera $_SESSION['user_id'] - ako nema, logout
2. Postavljanje $is_admin = ($_SESSION['role'] === 'admin')
3. Obrada POST/GET zahtjeva (ako admin)
4. Učitavanje predmeta iz baze (svima dostupni njihovi)
5. Ako je odabran predmet: učitavanje fajlova
6. HTML render sa Tailwind CSS
7. Modali sa JavaScript eventima
```

### 3. Admin - Kreiraj predmet
```
1. Unos u formu "novi predmet"
2. POST na index.php sa csrf_token i new_subject
3. Validacija (ne smije biti prazan)
4. INSERT u subjects tabelu
5. $_SESSION['success_message'] = "..."
6. Redirect na index.php
7. Poruka se prikaže sa fade-in animacijom
```

### 4. Admin - Upload materijala
```
1. Klik na "+ Dodaj materijal" dugme
2. Modal se prikaže sa drag-and-drop zonom
3. Odabir fajla (maksimalno 10MB)
4. Validacija tipa (14 dozvoljenih tipova)
5. POST na index.php sa csrf_token, file, upload_file
6. move_uploaded_file() sa TIMESTAMP prefixom
7. INSERT u files tabelu
8. Redirect sa success_message
9. Fajl se prikazuje u listi sa mogućnostima preuzimanja i brisanja
```

### 5. Student - Preuzimanje
```
1. Student vidi samo svoje predmete
2. Klik na predmet prikazuje fajlove
3. Klik na "📥 Preuzmi" otvara fajl
4. Direktan download iz uploads/ direktorija
```

---

## 🐛 UTVRĐENI PROBLEMI I NEDOSTACI

### Sigurnost
1. ⚠️ **Kredencijali u kodu**: config.php sa jasno vidljivim credentialima
2. ⚠️ **Nema HTTPS enforcement**: Trebalo bi `force_https`
3. ⚠️ **Nema rate limitinga**: Mogući brute force napadi na login
4. ⚠️ **subject.php bez autentifikacije**: Bilo tko može vidjeti fajlove
5. ⚠️ **Nema input sanitizacije**: `htmlspecialchars()` se koristi za output, ali nije za sve slučajeve

### Kodiranje
1. ❌ **Nema error handling**: Greške nisu bilježene (logging)
2. ❌ **Direktne SQL greške**: `$conn->error` se vraća korisnicima
3. ❌ **Nema validacije ekstenzije na serveru**: Samo client-side u nekim mjestima
4. ❌ **Kod je prepleten**: HTML, CSS, PHP, JavaScript u jednoj datoteci (index.php 855 linija)

### Funkcionalnost
1. ❌ **modals.php nije korišten**: Kod je redundantan
2. ❌ **upload.php nije korišten**: Stara verzija
3. ❌ **update_user.php nije korišten**: Nema AJAX implementacije
4. ❌ **load_subjects.php nije korišten**: Nema AJAX za loading predmeta
5. ❌ **Nema paginacije**: Ako ima mnogo materijala, stranica će biti spora

### UX/UI
1. ❌ **Nema potvrdnih poruka**: Samo "Obriši" klik bez potvrde (osim kroz JavaScript confirm)
2. ❌ **Nema pretraživanja**: Nemoguće pronaći materijal ako ima mnogo
3. ❌ **Nema sortiranja**: Materijali se prikazuju samo po ID-u
4. ❌ **Nema kategorija**: Samo flat lista predmeta

---

## 📊 STATISTIKA KODA

| Datoteka | Redova | Tip | Status |
|----------|--------|-----|--------|
| config.php | 17 | PHP | ✅ Koristi se |
| index.php | 855 | PHP+HTML+CSS+JS | ✅ Glavna datoteka |
| login.php | 116 | PHP+HTML+CSS+JS | ✅ Koristi se |
| logout.php | 5 | PHP | ✅ Koristi se |
| init_users.php | 43 | PHP | ⚙️ Samo inicijalizacija |
| upload.php | 72 | PHP+HTML+CSS | ❌ Zastarjelo |
| subject.php | 31 | PHP+HTML+CSS | ⚠️ Nema auth |
| update_user.php | 59 | PHP | ❌ Nekorišteno |
| load_subjects.php | 29 | PHP | ❌ Nekorišteno |
| modals.php | 134 | PHP | ❌ Redundantno |
| **UKUPNO** | **1,361** | - | - |

---

## 🎯 ZAKLJUČAK

**Školski Materijali** je funkcionalna aplikacija za upravljanje školskim materijalima sa:

### ✅ Što dobro funkcionira
- Autentifikacija sa bcrypt password hashing
- CSRF zaštita
- SQL injection zaštita sa prepared statements
- Role-based access control
- Responsive dark design
- Upload sa validacijom veličine i tipa
- Session management

### ❌ Što treba poboljšati
1. Refaktorirati kod iz index.php (855 linija) u MVC arhitekturu
2. Obrisati nekorištene datoteke (upload.php, modals.php, update_user.php, load_subjects.php)
3. Dodati pravilan error handling i logging
4. Implementirati HTTPS
5. Dodati rate limiting za login
6. Poboljšati UI/UX sa paginacijom i pretraživanjem
7. Osigurati kredencijale (.env fajl)
8. Dodati file type validation na serveru
9. Ispraviti subject.php da zahtijeva autentifikaciju
10. Dodati unit testove

---

## 🛠️ KAKO POKRENUTI

### 1. Preuzmite datoteke
```bash
git clone https://... SkolskiMaterijaliBackup
cd SkolskiMaterijaliBackup
```

### 2. Konfiguracija baze
- Ažurirajte `config.php` sa vašim kredencijalima
- Kreirajte tabele (schema gore)

### 3. Inicijalizacija
```
http://app.local/init_users.php
```
- Ovime se kreiraju default korisnici

### 4. Pristup
```
http://app.local/
- Redirects na login.php
- Login sa admin / admin123
- Ili ucenik / ucenik
```

### 5. Struktura uploads
```
mkdir uploads
chmod 777 uploads
```

---

**Verzija**: 1.0  
**Zadnja ažuriranja**: [ne zna se iz koda]  
**Status**: ✅ Radi, ali trebao bi refactor
