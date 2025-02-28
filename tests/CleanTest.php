<?php

use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Validator;
use JonPurvis\Squeaky\Rules\Clean;

beforeEach(function () {
    $this->translator = new Translator(
        new ArrayLoader, 'en'
    );
});

it('fails', function ($word) {
    $v = new Validator($this->translator, ['name' => $word], ['name' => new Clean]);

    expect($v->fails())->toBeTrue();
})->with([
    'fuck',
    'shit',
    'bastard',
]);

it('passes', function ($word) {
    $v = new Validator($this->translator, ['name' => $word], ['name' => new Clean]);

    expect($v->passes())->toBeTrue();
})->with([
    'hello',
    'goodbye',
    'greetings',
    'analytics',
]);

test('different language', function ($word) {
    $v = new Validator($this->translator, ['name' => $word], ['name' => new Clean(locales: ['it', 'en'])]);

    expect($v->fails())->toBeTrue();
})->with([
    'dio accecato',
    'dio affogato nella merda',
    'dio aguzzino',
    'dio ammuffito',
    'fuck',
    'shit',
    'bastard',
]);

it('throws an exception if one of the locales is not a string', function () {
    (new Validator(
        $this->translator,
        ['name' => 'hello'],
        ['name' => new Clean([new stdClass()])])
    )->passes();
})->throws(
    exception: InvalidArgumentException::class,
    exceptionMessage: 'The locale must be a string.'
);

it('throws an exception if one of the locales does not have a profanity config list', function () {
    (new Validator(
        $this->translator,
        ['name' => 'hello'],
        ['name' => new Clean(['en', 'invalid'])])
    )->passes();
})->throws(
    exception: InvalidArgumentException::class,
    exceptionMessage: 'The locale [\'invalid\'] is not supported.'
);
