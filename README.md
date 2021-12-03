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

$ski->data($datas); //add datas to Alpine to front

$ski->render(); //And just ⚡️ !
```
## ⚙️Core methods
###  📑 Set template `->template()`

Define what template will be rendered.
```php
//example :
$ski->template('articleTemplate');
// set template in /templates/articleTemplate.php
```
### 🖼️ Extend it with a layout  `->layout()` <sup>`OPTIONAL`<sup>
Template can be extended by a layout. If you define a layout, the template will be render inside the layout.
For example, the layout is often the static elements in your app, like the navbar, top menus or footer.
```php
//example :
$ski->layout('appLayout');
//extends template with layout in /layouts/appLayout.php
```
### ☁️ Add some datas  `->data() ` <sup>`OPTIONAL`<sup>
Pass datas from your backend, DB, Models or whatever to the view.
```php
//example :
$datas = Http::get('/api/v1/users')->getJson();

$ski->data($datas);

//$datas = {"posts":[...]}
//$datas = ['posts' => [...]]
//$datas = $posts[42]->content->...
```
The `$datas` variable can be a JSON Object, PHP Object or an Array.

Datas are passed to AlpineJS in `x-data` tag in `<body>` as Javascript Object `datas`
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
```
Directories structure:
----------------------
SkiRootPath
	|___ components
	|___ layouts
	|___ templates
	|___ head.php
```
### ♻️ Components/
To create new component, create new file in `components` directory :
```html
<!--/components/commentComponent.php-->
<template>
	<div class="comment">
		<h3 x-text="comment.userName"></h3>
		<p x-text="comment.content"></p>
	</div>
</template>
```
Let's create another component `articleComponent`
```html
<!--/components/articleComponent.php-->
<article class="article">
	<h2 x-text="datas.article.title"></h2>
	<p x-text="datas.article.content"></p>
	<div class="comments" x-for="comment in datas.comments">
		<@commentComponent>
	</div>
</article>
```
You probably already understood it, the `<@commentComponent>` represents our component.
### 📑 Templates/
To build templates, you just have to assemble your components.
```html
<!--/templates/blogPage.php-->
<main>
	<@breadcrumb>
	<@articleComponent>
	<@lastestNews>
</main>
```
The components names can only contains letters, and the word `template` is reserved and can't be used.
### 🖼️ Layouts/
Layouts is work in similar way, the content of template will be included in `<@template>`
```html
<!--/layouts/appLayout.php-->
<nav>
	...
</nav>
<div class="container">
	<@template>
</div>
<footer>
</footer>
```
### 🔗 Head.php
This file populate `<head></head>` in every rendered HTML document by Ski.
Here add your stylesheets or your favorite CSS frameworks CDN.
```html
<meta charset='utf-8'>
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
```
Be sure Alpine JS CDN is linked

### 🧪 Config.yarn
Soon !
```
Not implemented yet
```
### 🔬 Futur of Ski

Ski-Engine is an Open Source project, every contribution are welcomes.
Some points needs attention :
- XSS protection
- Configuration File
- Better integration with Alpine JS
- Better management of head tag

#### ⚖️ Legal shit
At this early point of developpement, use Ski-Engine in production is clearly not recommanded.
<sub><sup>
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</sup></sub>

This project is not affiliate with Alpine JS
<sup>(Thanks to Caleb Porzio for this really cool works on AlpineJS)</sup>
