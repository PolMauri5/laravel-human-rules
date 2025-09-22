# Human Rules

Human Rules es un paquete de Laravel que traduce reglas de validación en frases legibles para humanos.  
Actualmente soporta **inglés (en)** y **español (es)**, y puede extenderse fácilmente con más idiomas y reglas personalizadas.

---

## Instalación

Instalar mediante Composer:

```bash
composer require polmauri/human-rules
```

Laravel detectará automáticamente el Service Provider gracias al `extra.laravel.providers` en `composer.json`.

---

## Configuración

Puedes publicar el archivo de configuración con:

```bash
php artisan vendor:publish --tag=human-rules-config
```

También puedes publicar las traducciones para modificarlas según tus necesidades:

```bash
php artisan vendor:publish --tag=human-rules-translations
```

---

## Uso

Ejemplo de uso básico:

```php
use HumanReadable\HumanRules\RuleTranslator;

$rules = [
    'email' => 'required|email|min:5',
    'password' => 'required|min:8',
];

$customNames = [
    'email' => 'correo electrónico',
    'password' => 'contraseña',
];

$result = RuleTranslator::translate($rules, $customNames);

// Resultado en español:
[
    "email" => "El campo correo electrónico es obligatorio y debe ser un correo electrónico válido y debe tener al menos 5 caracteres",
    "password" => "El campo contraseña es obligatorio y debe tener al menos 8 caracteres"
]
```

---

## Multi-idioma

El paquete incluye traducciones por defecto en inglés y español.

Para cambiar el idioma globalmente:

```php
app()->setLocale('en');
```

O de manera puntual en la llamada:

```php
RuleTranslator::translate($rules, $customNames, 'es');
```

---

## Extensión con nuevas reglas

Puedes añadir reglas creando clases en el namespace `HumanReadable\HumanRules\Rules` que implementen la interfaz:

```php
namespace HumanReadable\HumanRules\Contracts;

interface TranslatableRule
{
    public static function canHandle(?string $name, ?string $param): bool;

    public static function translate(string $field, ?string $param, string $locale): string;
}
```

Ejemplo simplificado de una regla personalizada:

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

El paquete incluye pruebas con [Pest](https://pestphp.com/).  
Puedes ejecutarlas con:

```bash
composer test
```

---

## Estilo de código

El paquete usa [Laravel Pint](https://laravel.com/docs/pint) para mantener un estilo de código consistente.

```bash
composer format
```

---

## Licencia

Este paquete se distribuye bajo la licencia MIT.  
Consulta el archivo [LICENSE.md](LICENSE.md) para más detalles.
