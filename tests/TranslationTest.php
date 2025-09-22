<?php

use HumanReadable\HumanRules\RuleTranslator;

it('translates basic rules', function () {
    app()->setLocale('es');

    $result = RuleTranslator::translate([
        'email' => 'required|email',
    ], [
        'email' => 'el correo',
    ]);

    expect($result['email'])->toContain('el correo');
});
