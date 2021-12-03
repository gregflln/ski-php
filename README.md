# Ski Template Engine (PHP+AlpineJS)🏔️
## 📜Welcome to Documentation
### Ski Engine is a framework agnostic template engine that works with $Alpine JS$

Mock your next data driven application quickly with ski components and Alpine JS.

This tiny framework has been designed for people who are a little lazy like me. The learning curve is tiny as the framwork itself and his usage is very simple.

For more information, check out [Alpine JS Documentation](https://alpinejs.dev)

## ☑️ Installation

The best way to start a Ski project is using composer

```console
composer require ski/ski
```
Then use the CLI for generate the base ski project file structure.

You can't choose a directory that already exist.
```console
php ski-cli ski:create <dirname>
```
$$That's all folks$$
<center><b>Ski Engine is now ready to use !</b></center>

## 🔨 Basic Usage

```php
require 'vendor/autoload.php';

Use Core\Ski;

$ski = new Ski(__DIR__.'/path/to/ski/folder');

$datas = fetchFromBackend(...); // from ☁️


$ski->template('articleTemplate'); //add template that you need

$ski->layout('appLayout');//extend template with predifined layout

$ski->data($data); //add datas to Alpine to front

$ski->render(); //And just ⚡️ !
```
## ⚙️Core methods
###  📑 Set template `->template()`
Define what template render to view, templates are stored in `<yourSkiDorectory>/templates/<templateFilename>`

The template name is his `<filename>` minus `.php`
```php
//example :
$ski->template('<templateName>');
```
### 🖼️ Extend it with a layout  `->layout()` `OPTIONAL`
Template can be extended by a layout. If you define a layout, the template will be render inside the defined layout.

For example, the layout is often the static elements in your app, like the navbar, top menus or footer.
```php
//example :
$ski->layout('layout');
```
### ☁️ Add some datas  `->data() ` `OPTIONAL`
Pass datas from your backend, DB, Models or whatever to the view.
```php
//example :
$ski->data($datas);
```
The `$datas` variable can be a JSON Object, PHP Object or an Array.

Datas are passed to AlpineJS in JS Object always under the name : `datas :{...}`
```html
<div x-data="datas">
	<div v-for="post in datas.posts">
		<template>
			<h3 x-text="post.username"></h3>
			<p x-text="post.body"></p>
		</template>
	</div>
</div>
```

### ⚡️ Just render it `->render()`
```php
//example :
$ski->render();
```
The `->render()` method will send the view to the browser, this methods must be called in last.

Previous methods can be called in any order.

## Templating
### 📑 Templates/
### ♻️ Components/
### 🖼️ Layouts/
### 🔗 Head.php
### 🧪 Config.yarn
```
Not implemented yet
```
### 🔬 Futur of Ski
