<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use JonPurvis\Clean\Rules\Clean;

beforeEach(function () {
    $this->translator = new Translator(
        new ArrayLoader, 'en'
    );
});

it('fails', function ($word) {
    $v = new Validator($this->translator, ['name' => $word], ['name' => new Clean()]);

    expect($v->fails())->toBeTrue();
})->with([
    'fuck',
    'shit',
    'bastard'
]);

it('passes', function ($word) {
    $v = new Validator($this->translator, ['name' => $word], ['name' => new Clean()]);

    expect($v->passes())->toBeTrue();
})->with([
    'hello',
    'goodbye',
    'greetings'
]);
