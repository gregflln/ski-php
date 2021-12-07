# 🏔️Ski Template Engine (PHP+AlpineJS)
## 📜Welcome to Documentation
Ski Engine is a <mark>framework agnostic</mark> template engine that works with Alpine JS

Mock your next <mark> data driven</mark> application <mark>quickly</mark> with <mark>components</mark>.

>For more information, check out [Alpine JS Documentation](https://alpinejs.dev)
```html
<x-app>
	<x-article>
		<h1>Posts :</h1>
		<template x-for="post in posts">
			<x-post>
		</template>
	</x-article>
</x-app>
```
Alpine JS is an quite <mark>simple</mark> and very <mark>intuitive</mark> Javascript framework  <mark>inspired by Vue JS</mark> which can be used <mark>directly in HTML</mark> from a CDN.
>A, check out [Alpine JS Documentation](https://alpinejs.dev)
## ☑️ Installation

The best way to start a Ski project is using composer

```console
composer require ski/ski-php
```
Then use the CLI for generate the base ski project file structure.

You can't choose a directory that already exist.
```console
php ski-cli ski:create <dirname>
```
If everything went fine, Ski Engine directory must look like this
```
Directories structure:
----------------------
<mySkiPath>/
	|___ components/
	|___ templates/
	|___ head.php
	|___ config.yarn
```
That's all folks.
<b>Ski Engine is now <mark>ready to use !</mark></b>

## 🔨 Usage

This file can be your `index.php` or your router for example.
This is how to render a view

```php
require 'vendor/autoload.php';

Use Core\Ski;
$ski = new Ski(__DIR__.'/path/to/ski/folder');

$datas = [..]; // retrieve datas from whatever

$ski->template('articleTemplate'); //add template that you need
$ski->data($datas); //add datas to Alpine to front

$ski->render(); //And just ⚡️ !
```
###  📑  <mark>`$ski->template()`</mark> Choose template

Define which template will be rendered.
```php
//example :
$ski->template('articleTemplate');
// set template in /templates/articleTemplate.php
```
### ☁️   <mark>`$ski->data()`</mark>Add some datas <sub><sup>`OPTIONAL`<sup></sub>
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

### ⚡️  <mark>`$ski->render()`</mark>Build view and send it
```php
//example :
$ski->render();
```
The `->render()` method will send the view to the browser, this methods must be called in last.

Previous methods can be called in any order.

## 🏔️ Create better UI simpler with components
> With Ski Engine, you <mark>create templates by using components</mark>.
>  Components are little piece of code that you can manipulate in differents way.
> Components system are processed by PHP and components behavior are defined with AlpineJS directives.

### 🔁 How Ski Components Works ?
To create new component, create new file in `components/` directory.
The filename will be used as component tag name

Let's create a simple `comment` component :
```html
<!--/components/comment.php-->

<div class="comment-card">
	<h3 x-text="post.userName"></h3>
	<p x-text="post.content"></p>
</div>
```
Let's create another component `article` :
```html
<!--/components/article.php-->

<article class="article">
	<h2 x-text="datas.article.title"></h2>
	<p x-text="datas.article.content"></p>
	<div class="comments_Section">
		<h3>Comments:</h3>
		<x-slot></x-slot>
	</div>
</article>
```
### 📑 How to build template ?

To build templates, you just have to assemble your components.
For call components, use the following syntax `<x-componentName>` represents our component.
```html
<!--/templates/blogPage.php-->
<x-article>
	<template x-for="post in datas.posts">
		<x-comment/>
	<template>
</x-article>
```
The components names can only contains letters, and the word `template` is reserved and can't be used.
Tags are case insensitive : `<x-App>` `<x-APP>` `<x-app>` make reference to same "app.php" components file.

`<template>` should be called in templates and not in components itself, is just a tip.

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
## Integration with some frameworks
NAMM : Détailler comment implémenter Ski avec si possible avec Laravel, lumen, leaf, Flight,
## 🔬 Future of Ski

Ski-Engine is an Open Source project, every contribution are welcomes.
Some points needs attention :
- Improve XSS protection
- Add global variables system
- Add Configuration File
- Better management of head tag

#### ⚖️ Legal
At this early point of developpement, use Ski-Engine in production is clearly not recommanded.

<sub><sup>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</sup></sub>

This project is not affiliate with Alpine JS
<sup>(Thanks to Caleb Porzio for this really cool works on AlpineJS)</sup>
