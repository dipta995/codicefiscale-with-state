Here's a short and concise version for installation and usage with an example:

---

# **Laravel Codice Fiscale**

A Laravel package to handle codice fiscale operations with secure JSON data.

## 🚀 Installation

```bash
composer require dipta995/laravel-codicefiscale
```

If auto-discovery doesn't work, register manually in `config/app.php`:

```php
'providers' => [
    Dipta995\LaravelCodiceFiscale\LaravelCodiceFiscaleServiceProvider::class,
],

'aliases' => [
    'CodiceFiscale' => Dipta995\LaravelCodiceFiscale\Facades\CodiceFiscale::class,
];
```

Run:

```bash
composer dump-autoload
php artisan config:clear
```

---

## 📦 Usage

### 1️⃣ Fetch JSON Data in Controller

Example For ROME:
```php
{
  "surname": "Rossi",
  "name": "Mario",
  "dob": "1985-07-15",
  "gender": "M",
  "placeCode": "H501" 
}
````

```php
use CodiceFiscale;
//Check Validation
CodiceFiscale::validateFiscalCode($jsonData);
//Fetch All states
$jsonData = CodiceFiscale::getJsonData();
//Generate Fiscal Code with State validation or without validation
// using true as 6th param that is not mandatory
CodiceFiscale::generateCodiceFiscale($surname, $name, $dob, $gender, $placeCode,true);

```

### 2️⃣ Display JSON Data in Blade

```blade
@foreach ($jsonData as $key => $value)
    <p>{{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}</p>
@endforeach
```


## ✅ Done!
Your package is ready to use.
