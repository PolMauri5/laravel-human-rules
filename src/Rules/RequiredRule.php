<?php

namespace HumanReadable\HumanRules\Rules;

use HumanReadable\HumanRules\Contracts\TranslatableRule;

class RequiredRule implements TranslatableRule
{
    public static function canHandle(string $name, ?string $parameter): bool
    {
        return $name === 'required';
    }

    public static function translate(string $field, ?string $parameter, string $locale): string
    {
        return trans('human-rules::message.field_prefix', ['field' => $field], $locale)
             .' '.trans('human-rules::message.rules.required', [], $locale);
    }
}
