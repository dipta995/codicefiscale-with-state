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

```php
use CodiceFiscale;

public function create() {
    $jsonData = CodiceFiscale::getJsonData();
    return view('create', compact('jsonData'));
}


public function generateCodiceFiscal($surname, $name, $dob, $gender, $placeCode){
 $codice = CodiceFiscale::generateCodiceFiscale($surname, $name, $dob, $gender, $placeCode);
 return view('view-codice-fiscale', compact('jsonData'));
}
```

### 2️⃣ Display JSON Data in Blade

```blade
@foreach ($jsonData as $key => $value)
    <p>{{ $key }}: {{ is_array($value) ? implode(', ', $value) : $value }}</p>
@endforeach
```

### 3️⃣ Use Function with 5 Parameters (Dob must be Y-m-d)

Example For ROME:
```php
{
  "surname": "Rossi",
  "name": "Mario",
  "dob": "1985-07-15",
  "gender": "M",
  "placeCode": "H501" 
}

```


```php
use CodiceFiscale;

public function process(Request $request) {
    $result = CodiceFiscale::processData(generateCodiceFiscale($request->surname, $request->name, $request->dob, $request->gender, $request->placeCode));
    return response()->json($result);
}
```

---

## ✅ Done!
Your package is ready to use.
