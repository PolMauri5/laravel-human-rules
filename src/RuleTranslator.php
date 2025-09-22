<?php

namespace HumanReadable\HumanRules;

class RuleTranslator
{
    private static array $handlers = [
        \HumanReadable\HumanRules\Rules\RequiredRule::class,
        \HumanReadable\HumanRules\Rules\MinRule::class,
    ];

    /**
     * @param  array<string, string|array>  $rules
     * @param  array<string, string>  $customNames
     */
    public static function translate(array $rules, array $customNames = [], ?string $locale = null): array
    {
        $locale = $locale
            ?? config('human-rules.default_locale')
            ?? app()->getLocale();

        $out = [];

        foreach ($rules as $field => $ruleSet) {
            $label = $customNames[$field] ?? $field;
            $parts = is_array($ruleSet) ? $ruleSet : explode('|', (string) $ruleSet);

            $phrases = [];
            foreach ($parts as $raw) {
                [$name, $param] = explode(':', $raw, 2) + [null, null];

                foreach (self::$handlers as $handler) {
                    if ($handler::canHandle($name, $param)) {
                        $phrases[] = $handler::translate($label, $param, $locale);
                        break;
                    }
                }
            }

            if (empty($phrases)) {
                $out[$field] = trans('human-rules::message.field_prefix', ['field' => $label], $locale);

                continue;
            }

            $and = trans('human-rules::message.and', [], $locale);
            $first = array_shift($phrases);
            $prefix = trans('human-rules::message.field_prefix', ['field' => $label], $locale).' ';
            $rest = array_map(
                fn ($p) => str_starts_with($p, $prefix) ? substr($p, strlen($prefix)) : $p,
                $phrases
            );

            $out[$field] = $first.(count($rest) ? ' '.$and.' '.implode(' '.$and.' ', $rest) : '');
        }

        return $out;
    }
}
