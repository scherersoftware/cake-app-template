<h1>Home</h1>

<h2>Glide-resized Image</h2>

<?= $this->Glide->image('cakephp_hero.png', ['h' => 50]) ?>

<h2>FrontendBridge</h2>

<p>See webroot/js/app/controllers/home/index_controller.js for explanations</p>

<h3>Pass Variables from a CakePHP controller action to its JS Controller equivalent</h3>

<strong>Test:</strong> <span class="set-json-demo"></span>

<h3>AJAX JSON Requests</h3>

<a class="btn btn-default ajax-json-demo">Click me</a>

<h3>jsonAction Requests</h3>

<p>Allows to load CakePHP-rendered views including all FrontendBridge-JS-related functionality.</p>

<a class="btn btn-default json-action-demo">Click me</a>

<div class="render-target"></div>