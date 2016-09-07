# Laravel Whatsapp

This is a Laravel wrapper for the [whatsapp/chat-api]() package

```
$eventListener = new Lucasvdh/LaravelWhatsapp/Abstracts/Listener;
$eventListener->setEventsToListenFor($events->activeEvents)
```

## Getting started
1. [Include the package in your application](#include-the-package-in-your-application)
2. [Register the service provider](#register-the-service-provider)
3. [Publish and include the styles and scripts](#publish-and-include-the-styles-and-scripts)

View the [examples](#examples).

## Include the package in your application

``` bash
composer require lucasvdh/laravelmacros:5.*
```
Or add a requirement to your project's composer.json

``` javascript
  "require": {
    "lucasvdh/laravelmacros": "5.*"
  },
```

## Register the service provider

Edit the `config/app.php` file. Append the following to the `providers` array:

``` php
  'providers' => [
    // ...
    Lucasvdh\LaravelMacros\MacroServiceProvider::class,
    // ...
  ],
```

If you don't have the `laravelcollective/html` package yet, be sure to add that service provider too:

``` php
  'providers' => [
    // ...
    Collective\Html\HtmlServiceProvider::class,
    // ...
  ],
```

And register the aliases:

``` php
  'aliases' => [
    // ...
    'Form' => Collective\Html\FormFacade::class,
    'Html' => Collective\Html\HtmlFacade::class,
    // ...
  ],
```


## Publish and include the styles and scripts

``` bash
$ php artisan vendor:publish --provider="Lucasvdh\LaravelMacros\MacroServiceProvider"
```

#### Publishing a specific resource

``` bash
$ php artisan vendor:publish --provider="Lucasvdh\LaravelMacros\MacroServiceProvider" --tag="scripts"
$ php artisan vendor:publish --provider="Lucasvdh\LaravelMacros\MacroServiceProvider" --tag="styles"
$ php artisan vendor:publish --provider="Lucasvdh\LaravelMacros\MacroServiceProvider" --tag="images"
```

The CSS and Javascript files will be published to `public/css` and `public/js`. 

Make sure to include these in the view where you want to use the macros. You have two choices for including the styles and scripts.
  
### Include all

Either you include all the plugins as a minified file.

``` html
<html>
  <head>
    ...
    <link href="/css/laravel-macros.css" rel="stylesheet">
  </head>
  <body>
    ...
    <!-- Include Javascript at the end of body to improve page load speed -->
    <script src="/js/laravel-macros.js" type="text/javascript"></script>
  </body>
</html>
```

### Include specific plugins

Or you include specific plugins.

``` html
<html>
  <head>
    ...
    <link href="/css/chosen.css" rel="stylesheet">
    <link href="/css/tags-input.css" rel="stylesheet">
  </head>
  <body>
    ...
    <!-- Include Javascript at the end of body to improve page load speed -->
    <script src="/js/chosen.jquery.min.js" type="text/javascript"></script>
    <script src="/js/tags-input.js" type="text/javascript"></script>
    
    <!-- IMPORTANT this file is required for the plugins to function -->
    <script src="/js/laravel-macros-app.js" type="text/javascript"></script>
  </body>
</html>
```

# That's it

You can now use the macros and all should work. Customization of the CSS and Javascript files should be straight forward.

Below, a few examples are given how to use these macros:

## Examples

### Date picker

``` blade
{!! Form::datepicker('field_name', $default, ['class' => 'some-class']) !!}
```

![datepicker](http://download-manager.nl/lucasvdh/laravelmacros/datepicker.png "Date picker")

![datepicker-extended](http://download-manager.nl/lucasvdh/laravelmacros/datepicker-extended.png "Date picker extended")

### Chosen select

``` blade
{!! Form::chosen('field_name', $default, $list, ['class' => 'some-class']) !!}
```

![chosen](http://download-manager.nl/lucasvdh/laravelmacros/chosen-select.png "Chosen select")

![chosen-extended](http://download-manager.nl/lucasvdh/laravelmacros/chosen-select-extended.png "Chosen select extended")

### Material checkbox

``` blade
{!! Form::materialCheckbox('field_name', $checked, 'This is the checkbox text', 'value', ['class' => 'some-class']) !!}
```

![material-checkbox](http://download-manager.nl/lucasvdh/laravelmacros/material-checkbox.png "Material checkbox")

![material-checkbox-checked](http://download-manager.nl/lucasvdh/laravelmacros/material-checkbox-checked.png "Material checkbox checked")

### Material radio

``` blade
{!! Form::materialRadio('field_name', $default, $options = ['value' => 'label'], ['class' => 'some-class']) !!}
```

![material-radio](http://download-manager.nl/lucasvdh/laravelmacros/material-radio.png "Material radio")
