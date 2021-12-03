# Ski Template Engine Documentation

# Ski Template Engine Documentation

## Simplicity of PHP + eloquence of JS

Ski is a framework agnostic template engine that build with Alpine JS.

Mock your next data driven application quickly with ski components and Alpine JS.

This tiny framework has been designed for people who are a little lazy like me. The learning curve is tiny as the framwork itself and his usage is very simple.

Alpine JS Documentation : https://alpinejs.dev

## Installation

The best way to start a Ski project is using composer

```console
composer require ski/ski
```
Then use the CLI for generate the base ski project file structure.
You can't choose a directory that already exist.
```console
php ski-cli ski:create <dirname>
```
Thats all folks, ski is now ready to use !

## Basic Usage

```php
require 'vendor/autoload.php';

Use Core\Ski;

$ski = new Ski(__DIR__.'/path/to/ski/folder');
```
## Core methods
### $->template()
### $->layout()
### $->data()
### $->render()
## Templating systems
### Templates/
### Components/
### Layouts/
### Head.php
### Config.yarn
```
Not implemented yet
```
