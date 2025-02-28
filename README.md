<img src="art/banner.png">

# Squeaky
A Laravel Validation Rule that helps catch profanity in your application.

[![Tests](https://github.com/JonPurvis/squeaky/actions/workflows/tests.yml/badge.svg)](https://github.com/JonPurvis/squeaky/actions/workflows/tests.yml)
![GitHub last commit](https://img.shields.io/github/last-commit/jonpurvis/squeaky)
![Packagist PHP Version](https://img.shields.io/packagist/dependency-v/jonpurvis/squeaky/php)
![GitHub issues](https://img.shields.io/github/issues/jonpurvis/squeaky)
![GitHub](https://img.shields.io/github/license/jonpurvis/squeaky)
![Packagist Downloads](https://img.shields.io/packagist/dt/jonpurvis/squeaky)

## Introduction
Squeaky (short for Squeaky Clean) is a Laravel validation rule that you can add your Laravel application, to ensure any
user submitted input such as a name or biography, is free of profanity and therefore, clean. Just add `new Clean()` to
your rules and you're good to go!

Squeaky is powered by [Profanify](https://github.com/JonPurvis/profanify/), which is a PestPHP Plugin that
does the same thing, but for code. By utilising the profanity in that package, Squeaky is powerful from the get-go and
provides support for numerous locales, not just English.

## Installation

To install Squeaky, you can run the following command in your project's root:

```text
composer require jonpurvis/squeaky
```

## Examples

Let's take a look at how Squeaky works. As it's a Laravel Validation rule, there's not really that much to it. You 
would use it in the same way you would use a custom validation rule you've added yourself.

Let's take the following scenario where we have a form that allows a user to enter their name, email and bio:

```php
return [
    'name' => ['required', 'string', 'max:255', new Clean],
    'email' => [
        'required',
        'string',
        'lowercase',
        'email',
        'max:255',
        Rule::unique(User::class)->ignore($this->user()->id),
    ],
    'bio' => ['required', 'string', 'max:255', new Clean],
];
```

You'll notice that both _name_ and _bio_ are using the **Clean** rule. This rule will take the value and ensure that 
it doesn't exist in the profanity config files that the package has. By default, it will use your app locale, so if 
your locale is set to `en`, it will scan profanity in the _en_ profanity config.

If profanity is found, an error will appear in the validation errors array and will be shown to your user 
(if your application does this).

Some applications allow for more than one language, so you're able to pass in additional locales to the rule to cater 
for them. Below is an example showing how to cater for both `en` and `it`:

```php
'name' => ['required', 'string', 'max:255', new Clean(['en', 'it'])],
```

This will then check the locale config for any locale you've passed in (providing the config exists!). If profanity is 
found in any of them, an error will appear in the validation errors. 

The really cool thing about this, is the error will be returned in the language that failed. So if the failure was
found in the `it` profanity list, the package assumes the user is Italian and returns the error message in Italian to
let them know that their value is not clean. 

## Languages
Squeaky currently supports the following languages:

- English
- Italian
- Arabic
- Portuguese
- Dutch

## Contributing
Contributions to the package are more than welcome! 

For profanity additions, these will need adding into 
[Profanify](https://github.com/JonPurvis/profanify) and then a new release will need to be tagged so this package can 
use them. 

If you want to support a new language, once it's been added to [Profanify](https://github.com/JonPurvis/profanify), 
it will then need adding in the `boot` method of the `SqueakyServiceProvider` class in this package. 
