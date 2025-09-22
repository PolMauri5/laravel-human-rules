# Human Rules

Human Rules is a Laravel package that translates validation rules into human-readable sentences.  
It currently supports **English (en)** and **Spanish (es)**, and can easily be extended with more languages and custom rules.

---

## Installation

Install via Composer:

```bash
composer require polmauri/human-rules
```

Laravel will automatically register the Service Provider thanks to the `extra.laravel.providers` entry in `composer.json`.

---

## Configuration

You can publish the configuration file with:

```bash
php artisan vendor:publish --tag=human-rules-config
```

You can also publish the translations to customize them:

```bash
php artisan vendor:publish --tag=human-rules-translations
```

---

## Usage

Basic usage example:

```php
use HumanReadable\HumanRules\RuleTranslator;

$rules = [
    'email' => 'required|email|min:5',
    'password' => 'required|min:8',
];

$customNames = [
    'email' => 'email address',
    'password' => 'password',
];

$result = RuleTranslator::translate($rules, $customNames);

// Result in Spanish (locale = es):
[
    "email" => "El campo email address es obligatorio y debe ser un correo electrónico válido y debe tener al menos 5 caracteres",
    "password" => "El campo password es obligatorio y debe tener al menos 8 caracteres"
]
```

---

## Multi-language

The package includes default translations in English and Spanish.

To change the global locale:

```php
app()->setLocale('en');
```

Or override it per call:

```php
RuleTranslator::translate($rules, $customNames, 'es');
```

---

## Extending with new rules

You can add rules by creating classes in the `HumanReadable\HumanRules\Rules` namespace that implement the interface:

```php
namespace HumanReadable\HumanRules\Contracts;

interface TranslatableRule
{
    public static function canHandle(?string $name, ?string $param): bool;

    public static function translate(string $field, ?string $param, string $locale): string;
}
```

Simplified example of a custom rule:

```php
namespace HumanReadable\HumanRules\Rules;

use HumanReadable\HumanRules\Contracts\TranslatableRule;

class MaxRule implements TranslatableRule
{
    public static function canHandle(?string $name, ?string $param): bool
    {
        return $name === 'max';
    }

    public static function translate(string $field, ?string $param, string $locale): string
    {
        return trans('human-rules::message.field_prefix', ['field' => $field], $locale)
            . ' ' . trans('human-rules::message.rules.max', ['max' => $param], $locale);
    }
}
```

---

## Tests

The package includes tests with [Pest](https://pestphp.com/).  
You can run them with:

```bash
composer test
```

---

## Code style

The package uses [Laravel Pint](https://laravel.com/docs/pint) to maintain a consistent code style.

```bash
composer format
```

---

## License

This package is distributed under the MIT License.  
See the [LICENSE.md](LICENSE.md) file for more details.
