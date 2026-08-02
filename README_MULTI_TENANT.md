# 📚 Školski Materijali - Multi-Tenant Admin Sistem

Ažurirana aplikacija za upravljanje školskim materijalima sa mogućnošću kreiranja više administratora.

## 🚀 POČETAK RADA

### 1. Instalacija migracija
Prije nego što koristite novu verziju, trebate pokrenuti migracije da se vaša baza podataka ažurira.

```
http://localhost/migrations.php
```

Ova stranica će:
- Dodati `parent_admin_id` kolonu u `users` tabelu
- Dodati `admin_id` kolone u `subjects`, `files`, `tests`, i `student_works` tabele
- Automatski preskočiti kolone koje već postoje

### 2. Logovanje

**Master Admin** (početni admin):
- Username: `admin`
- Password: `admin123`

Nakon prijave, master admin automatski ide na `index.php`.

## 👥 ULOGE I PRISTUP

### 👨‍💼 Master Admin
- **Pristupa**: `index.php`
- **Može**:
  - Kreirajti nove administratore
  - Kreirajti učenike i predmete
  - Vidjeti sve administratore, učenike, predmete i materijale
  - Brisati bilo šta

### 👨‍💻 Non-Master Admin (kreirad od strane master admina)
- **Pristupa**: `admin_dashboard.php`
- **Može**:
  - Kreirajti samo učenike (NE nove adminne)
  - Kreirajti svoje predmete i učitavati materijale
  - Vidjeti samo svoje predmete, učenike i materijale
  - Upravljati samo svojima stvarima

### 📚 Student (Učenik)
- **Pristupa**: `index.php`
- **Može**:
  - Vidjeti samo predmete dodijeljene od strane njihovog admina
  - Preuzimati materijale
  - Predavati radove

## 🔄 TOK RADA

1. **Master admin** se uloguje sa podrazumevanim kredencijalima
2. **Master admin** klika na "👨‍💼 Admini" dugme
3. **Master admin** kreira novog administratora
4. **Novi administrator** se uloguje i ide na `admin_dashboard.php`
5. **Novi administrator**:
   - Pravi predmete
   - Krira učenike
   - Učitava materijale (PDF, Word, itd.)
6. **Učenici**:
   - Loguju se
   - Preuzimaju materijale
   - Predaju radove

## 🎯 PRIMJER: Kako napraviti novog admina

1. Logujte se kao master admin
2. Idite na "👨‍💼 Admini" dugme u desnom uglu
3. Popunite:
   - Korisničko ime: `profesor1`
   - Lozinka: `lozinka123`
4. Kliknite "Kreiraj Admina"
5. Novi admin može da se uloguje sa tim kredencijalima

## 🎯 PRIMJER: Kako profesor dodaje učenike

1. Profesor se uloguje
2. Ide na stranici `admin_dashboard.php` (automatski se redirektor)
3. Klika "Kreiraj učenika"
4. Popunjava podatke i bira predmete
5. Učenik se može logati i vidjeti samo te predmete

## 📊 BAZA PODATAKA - NOVE KOLONE

### users tabela
```sql
ALTER TABLE users ADD COLUMN parent_admin_id INT NULL DEFAULT NULL;
```
- Za master admine: `NULL`
- Za non-master admine: ID master admina koji ga je kreirad

### subjects tabela
```sql
ALTER TABLE subjects ADD COLUMN admin_id INT NOT NULL DEFAULT 1;
```
- `admin_id = 1` za stare predmete (kreirane od strane originalnog admina)
- `admin_id` za nove predmete (ID admina koji ga je kreirad)

### files tabela
```sql
ALTER TABLE files ADD COLUMN admin_id INT NOT NULL DEFAULT 1;
```
- ID admina kojem pripada fajl

### tests tabela
```sql
ALTER TABLE tests ADD COLUMN admin_id INT NOT NULL DEFAULT 1;
```
- ID admina kojem pripada test

### student_works tabela
```sql
ALTER TABLE student_works ADD COLUMN admin_id INT NOT NULL DEFAULT 1;
```
- ID admina kojem pripada rad

## 🔒 SIGURNOST

- ✅ CSRF zaštita na svim POST zahtjevima
- ✅ Password hashing sa bcrypt
- ✅ Prepared statements za SQL Injection zaštitu
- ✅ Role-based access control
- ✅ Učenici ne mogu vidjeti predmete drugih admina
- ✅ Non-master admini ne mogu kreirajti nove adminne

## ⚙️ DATOTEKE KOJE SU KREIRANE/IZMIJENJENE

### Nove datoteke:
- `admin_dashboard.php` - Panel za non-master adminne
- `migrations.php` - Migracija baze podataka

### Izmijenjene datoteke:
- `index.php` - Dodani filteri za multi-tenant, redirekcija non-master admina
- `login.php` - Dodana automatska redirekcija na odgovarajuće panele
- `ANALIZA_APLIKACIJE.md` - Ažurirana dokumentacija

## 🐛 TROUBLESHOOTING

### Problem: Admin se ne redirektor na admin_dashboard.php
**Rješenje**: Provjerite da li je migracija pokrenuta. Ako `parent_admin_id` kolona ne postoji, admin se ne može provjeriti.

### Problem: Non-master admin ne vidi svoje predmete
**Rješenje**: Provjerite da li ste dodali `admin_id` pri kreiranju predmeta. Trebate pokrenuti migracije.

### Problem: Materijali ne pokazuju vlasnika
**Rješenje**: Dodaj naziv administratora pored naziva materijala je novi kod, trebali bi pokrenuti migracije.

## 📞 KONTAKT

Za dodatne informacije, vidjeti `ANALIZA_APLIKACIJE.md`
