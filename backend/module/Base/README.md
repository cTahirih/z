# Base module for Zend Framework 3

This module provides foundational configurations, plugins, helpers and commands for our projects. This module is an obligatory requirement as it's the core of Skelsus.

## Static views routing and rendering shortcut
It's a frequent occurrence to have a route that shows a static view template. By "static" I mean the view needs no variables nor requirements.

To simplify this, **Base** includes a simple Controller that can render such a view and an static class that simplifies the configuration.

Here's an example:

    // In a configuration file (e.g. a module's module.config.php)
    
    use Base\Route;
    
    return [
        'router' => [
            'routes' => [
                'privacy' => Route::render('/privacy', 'app/privacy'),
            ],
            
            // etc...

The Controller class is `Base\Controller\StaticViewController`.

The route helper class is `Base\Route`.


## Controller Plugins

### render (Base\Controller\Plugin\Render)
A shortcut for instanciating and setting up a `Zend\View\ViewModel` object.

Example:

    // Inside a Controller action
    return $this->render('app/home', $vars);

This is equivalent to:

    $viewModel = new ViewModel($vars);
    $viewModel->setTemplate('app/home');
    return $viewModel;

### getRender (Base\Controller\Plugin\GetRender)
Returns as a string the contents of the rendered View Model.

Example:

    // Inside a Controller action
    $content = $this->getRender('app/home', $vars);


## View Helpers

### formError (Base\View\Helper\FormError)
Returns an HTML label with the error message for the given Element or an empty string on no error.

Example: 

    // Inside a view
    <?= $this->formError($form->get('email')) ?>

Will output on error:

    <label class="msg" for="email">Missing Email</label>


## "skelsus" CLI script
The `skelsus` script located in the root directory allows any Module to provide application-wide commands. It uses [Symfony Console](https://symfony.com/doc/current/components/console.html).

Any ZF3 Module can provide commands by having its `Module.php` implement `Base\SkelsusCommandProviderInterface`. The interface defines a `getSkelsusCommands()` method which should return an array of `Symfony\Component\Console\Command\Command` instances (NOT class names!).

`skelsus` will autoconfigure everything from there.

As a convention, organize your Commands inside a `Skelsus\Console\Command` namespace.

## Skelsus Commands
The **Base** module defines the following commands:

### console (Base\Skelsus\Console\Command\ConsoleCommand)
Drops you into a `psysh` console.

### database (Base\Skelsus\Console\Command\DatabaseCommand)
Drops you into a database interactive console using `config/autoload/database.php` credentials.

**NOTE:** Only MySQL is currently supported.


## Env class (Base\Env)
**Env** acts as a global state environment status. Inside the application you can query the current environment by calling:

    use Base\Env;
    
    $environment = Env::get();

The value can be overwritten with `set()` with any string. By convention, the following values are used:

    production
    development
    testing

For convenience, it also provides the following boolean methods:

    isProduction()
    isDevelopment()
    isTesting()

### Environment Lifecycle
The **Env** class defines `production` as the default environment. Regardless of this, on `public/index.php` the environment is set as `production`.

If the application is in Development Mode, then `config/development.config.php` will overwrite the value to `development`.

When running **PHPUnit**, the file `test/bootstrap.php` will be called. This script will, among other things, set the environment to `testing`.

### Developers, attention!
While **Env** can be called globally, it should only be used on configurations, Framework infrastructure or Unit Testing classes. It's a bad practice to call it inside Controllers, Views or Domain code. Use Dependency Injection instead.
