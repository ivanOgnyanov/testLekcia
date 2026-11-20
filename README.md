# Лекция 5 - Laravel: контролери и потребителски вход

Учебен проект към лекция 5 от курса по сървърно програмиране (MVC, Laravel 13).
Съдържа работещи примери за всичко, разгледано в лекцията: контролери, класа `Request`,
пренасочване и съобщения в сесията, валидация, FormRequest класове и ресурсни контролери.

Номерата на слайдовете в описанията по-долу отговарят на лекцията
„Lekcia 5 MVC Laravel Controllers and UserData 2026“.

---

## Изисквания

| Софтуер | Версия | Бележка |
|---|---|---|
| PHP | 8.3 или по-нова | например от XAMPP (`C:\xampp\php`) |
| Composer | 2.x | https://getcomposer.org |
| Git | всяка | https://git-scm.com |

Node.js **не е нужен** - изгледите използват Bootstrap от CDN.

PHP трябва да има разширението за SQLite. Проверка:

```bash
php -m
```

В списъка трябва да има `pdo_sqlite`. Ако липсва, в `php.ini` (при XAMPP - `C:\xampp\php\php.ini`)
се премахва `;` пред реда `extension=pdo_sqlite`.

> **XAMPP:** командата `php` трябва да работи от всяка папка. Ако не работи, добавете `C:\xampp\php`
> в системната променлива `PATH` и отворете нов команден прозорец.

---

## Инсталиране след сваляне от GitHub

### 1. Клониране на хранилището

```bash
git clone https://github.com/ivanOgnyanov/testLekcia.git
cd testLekcia
```

### 2. Инсталиране на PHP пакетите

Папката `vendor` не се качва в GitHub - пакетите се свалят според `composer.lock`:

```bash
composer install
```

### 3. Файл с настройки `.env`

Файлът `.env` също не се качва (съдържа пароли и ключове). Създава се от примерния `.env.example`:

```bash
# Windows (cmd)
copy .env.example .env

# Linux / macOS / Git Bash
cp .env.example .env
```

### 4. Ключ на приложението

```bash
php artisan key:generate
```

Записва случаен `APP_KEY` в `.env` - използва се за криптиране на сесиите и бисквитките.

### 5. База данни

Проектът използва SQLite - цялата база е един файл `database/database.sqlite`. Той не се качва
в GitHub, затова първо се създава празен файл, а след това се създават таблиците:

```bash
# Windows (cmd)
type nul > database\database.sqlite

# Linux / macOS / Git Bash
touch database/database.sqlite
```

```bash
php artisan migrate --seed
```

`--seed` добавя примерни данни: 6 членове (сред тях Петър Петров, petar@abv.bg), 3 задачи и тестов потребител.

### 6. Стартиране

```bash
php artisan serve
```

Отворете в браузъра: **http://localhost:8000**

Началната страница съдържа връзки към всички примери.

> **С Apache от XAMPP** (без `php artisan serve`): проектът трябва да е в `C:\xampp\htdocs\testLekcia`
> и се отваря на http://localhost/testLekcia/public

### Накратко

```bash
git clone https://github.com/ivanOgnyanov/testLekcia.git
cd testLekcia
composer install
copy .env.example .env
php artisan key:generate
type nul > database\database.sqlite
php artisan migrate --seed
php artisan serve
```

(командите `copy` и `type nul` са за Windows - за Linux/macOS вижте стъпки 3 и 5)

---

## Тестове

Проектът съдържа автоматични тестове (Pest) за всички примери:

```bash
php artisan test
```

Тестовете използват отделна база в паметта и не променят данните в `database.sqlite`.

---

## Какво от лекцията е реализирано

| Страница | Адрес | Какво показва | Слайдове |
|---|---|---|---|
| Задачи | `/tasks` | данни от контролера към изглед | 8 |
| Контакти | `/contacts/create` | `Request` в контролер, зареждане на изглед с входа | 17-19, 27 |
| Анкета | `/surveys/create` | методите на `Request` и масиви от формуляр | 20-22 |
| Статия | `/articles/create` | валидация с `$request->validate()` и показване на грешките | 30-35 |
| Членове | `/members` | FormRequest, service клас, ресурсен контролер | 13, 36-52 |
| Експорт | `/members/export` | контролер с едно действие (`__invoke`) | 14, 52 |

### Контролери

- **Конвенции за имена** (слайд 7) - навсякъде: контролери в единствено число (`MemberController`),
  адреси в множествено число (`/members`), имена на маршрути с точки (`members.index`),
  изгледи в папки (`members/index.blade.php`), полета на формулярите в snake_case.
- **Данни към изглед** (слайд 8) - `TaskController::index()` подава `Task::all()` на изгледа `tasks.index`.
- **Създаване с Artisan** (слайдове 10-11) - всички класове са създадени с команди:
  ```bash
  php artisan make:model Member -mfsc --resource --requests
  php artisan make:controller ExportMembersController --invokable
  php artisan make:class Services/MemberService
  php artisan make:mail WelcomeMail
  ```
- **Тънки контролери и service клас** (слайд 13) - `MemberController::store()` има два реда: валидацията е
  в `StoreMemberRequest`, а записът и изпращането на имейл - в `App\Services\MemberService`.
  Laravel създава обекта `MemberService` и го подава на метода (dependency injection).
- **Контролер с едно действие** (слайд 14) - `ExportMembersController` с метод `__invoke`
  сваля всички членове като CSV файл.
- **Типове на връщаните стойности** (слайд 9) - всички методи декларират `View` или `RedirectResponse`.

### Обработка на потребителския вход - Request

- **Request в контролер** (слайдове 17-19) - `ContactController::store(Request $request)` приема
  данните от формата за контакт и ги показва в изгледа `contacts.result`; липсващото съобщение
  се заменя с `?? 'Няма съобщение'`.
- **Методите на Request** (слайдове 20-22) - анкетата показва в таблица какво връща всеки метод:
  - `$request->string('name')->title()` - „петър петров“ → „Петър Петров“;
  - `$request->input('cities', [])` и `$request->input('cities.0')` - масив от чекбоксове `cities[]`;
  - `$request->boolean('newsletter')` - чекбокс → `true` / `false`;
  - `$request->integer('per_page', 10)` - текст → число;
  - `$request->has('comment')` и `$request->filled('comment')` - разликата при празно поле.
- **Почистване на входа** (слайд 15) - празното поле „Коментар“ пристига като `null`
  (`ConvertEmptyStringsToNull`).

### Пренасочване и съобщения в сесията

- **Зареждане на изглед** (слайд 27) - контактите и анкетата само показват данни, затова връщат изглед.
- **Пренасочване след запис - Post/Redirect/Get** (слайд 26) - след запис, редакция и изтриване
  на член контролерът пренасочва към `members.index`.
- **Съобщение за успех** (слайд 29) - `->with('success', '...')` в контролера и
  `@session('success')` в общия layout `resources/views/layouts/app.blade.php`. Блокът е на едно място
  и съобщението се показва на всяка страница.
- **old()** (слайд 25) - всички формуляри запазват въведеното при грешка; формата за редакция на член
  използва `old('name', $member?->name)`.

### Валидация

- **validate() в контролера** (слайд 31) - `ArticleController::store()` проверява заглавието и текста
  и използва върнатия масив `$validated`. Статията не се записва - примерът показва само валидацията.
- **Съобщения за грешка** (слайдове 33-34) - `@error` до всяко поле, клас `is-invalid` на полето с грешка
  и списък с всички грешки (`$errors->all()`).
- **Съобщения на български** (слайд 35) - преводите са от пакета Laravel-Lang (`lang/bg`),
  а езикът е зададен с `APP_LOCALE=bg` в `.env`.

### FormRequest - професионален подход

- **StoreMemberRequest и UpdateMemberRequest** (слайдове 37-40) - в `app/Http/Requests`:
  - `authorize()` връща `true` (генерираният клас връща `false` и всяка заявка би завършила с 403);
  - имейлът е уникален - при редакция с `Rule::unique('members')->ignore(...)`, за да не се
    отказва собственият имейл на члена.
- **Собствени съобщения** (слайд 41) - `messages()` („Този имейл вече е регистриран.“) и
  `attributes()` („Полето **имейл** е задължително.“).
- **Запис само на проверените данни** (слайдове 44-45) - `$request->validated()`, а моделът
  `Member` разрешава масов запис само на `name` и `email` (`#[Fillable]`).
- **Имейл „Добре дошли“** - при нов член `MemberService` изпраща `WelcomeMail`. Понеже в `.env` е
  `MAIL_MAILER=log`, имейлът не се изпраща наистина, а се записва в `storage/logs/laravel.log`.

### Ресурсни контролери

- **Route::resource** (слайдове 47-50) - `MemberController` реализира и 7-те метода:
  списък, формуляр за нов, запис, показване, формуляр за редакция, обновяване и изтриване.
- **Route model binding** (слайдове 45, 51) - методите получават директно `Member $member`;
  несъществуващ член (например `/members/12345`) връща грешка 404.
- **@method('PUT') и @method('DELETE')** - формите за редакция и изтриване.
- **Допълнителен маршрут преди Route::resource** (слайд 52) - `/members/export` е дефиниран преди
  ресурса, иначе би се приел като `show` с `{member} = "export"`.

Всички маршрути:

```bash
php artisan route:list --except-vendor
```

---

## Къде е кодът

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── ArticleController.php        validate() в контролера
│   │   ├── ContactController.php        Request в контролер
│   │   ├── ExportMembersController.php  __invoke, експорт в CSV
│   │   ├── MemberController.php         ресурсен контролер (7 метода)
│   │   ├── SurveyController.php         методите на Request
│   │   └── TaskController.php           данни към изглед
│   └── Requests/
│       ├── StoreMemberRequest.php
│       └── UpdateMemberRequest.php
├── Mail/WelcomeMail.php
├── Models/
│   ├── Member.php
│   └── Task.php
└── Services/MemberService.php           бизнес логиката извън контролера

database/
├── factories/  MemberFactory, TaskFactory
├── migrations/ create_members_table, create_tasks_table
└── seeders/    MemberSeeder, TaskSeeder

resources/views/
├── layouts/app.blade.php                общ layout + съобщението за успех
├── home.blade.php                       начална страница с връзки към примерите
├── articles/   create
├── contacts/   create, result
├── mail/       welcome
├── members/    index, create, edit, show, partials/form
├── surveys/    create, result
└── tasks/      index

routes/web.php                           всички маршрути с номерата на слайдовете

tests/Feature/
├── MemberTest.php
└── RequestExamplesTest.php
```

---

## Полезни команди

| Команда | Какво прави |
|---|---|
| `php artisan migrate:fresh --seed` | изтрива всички таблици и ги създава наново с примерните данни |
| `php artisan route:list --except-vendor` | всички маршрути на приложението |
| `php artisan test` | пуска тестовете |
| `php artisan tinker` | конзола за изпълнение на PHP код в приложението |

---

## Чести проблеми

| Проблем | Решение |
|---|---|
| `No application encryption key has been specified` | `php artisan key:generate` |
| `could not find driver` | разрешете `extension=pdo_sqlite` в `php.ini` |
| `Database file at path [...] does not exist` | създайте празен файл `database/database.sqlite` (стъпка 5) |
| Съобщенията за грешка са на английски | проверете `APP_LOCALE=bg` в `.env` |
| `'php' is not recognized...` | добавете `C:\xampp\php` в `PATH` |
