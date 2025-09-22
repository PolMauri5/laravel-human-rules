<?php

namespace HumanReadable\HumanRules\Contracts;

interface TranslatableRule
{
    public static function canHandle(string $name, ?string $parameter): bool;

    public static function translate(string $field, ?string $parameter, string $locale): string;
}
