DOLCE GUSTO - DASHBOARD
=======================
Copyright (C) 2018 Nodos \<http://nodos.pe\>


Authors:
--------
- César Mandamiento
- Jaime Wong
- Paul Xyu


Requirements
------------
1. PHP >= 7.0
2. MySQL >= 5.6 or compatible.
3. Extra PHP extensions: `intl`


Write permissions
-----------------
The application requires write permissions on the following directories:

- `data`


Installation Instructions
-------------------------
This project is built upon [Zend Framework 3](https://framework.zend.com/).


### 1. Install Composer
This project uses [Composer](https://getcomposer.org) for its dependencies. If you don't have a global Composer installed already, follow these steps to install a local copy inside the project.

While located inside the project's root directory, run the command:

    curl -s https://getcomposer.org/installer | php --

This will install a `composer.phar` executable file.


### 2. Install dependencies
On a **Production** environment, run:

    php composer.phar install --no-dev

This flag tells Composer not to be install extra development libraries or modules, such as Unit Testing and debugging libraries.

On a **Development** environment, run:

    php composer.phar install


### 3. Setup local configuration

In the `config/autoload` directory there is a sample configuration file called `local.php.dist`, copy it to a file named `local.php`.

Edit the file and follow the instructions commented within.


### 4. Create the database
Using your preferred interface to MySQL (or compatible), create a new database, user and password.

**NOTE:** The application will use `UTF-8` encoding.


### 5. Configure the database connection
In the `config/autoload` directory there is a file called `database.php.dist`, copy it to `database.php`.

Configure the database credentials on the proper variables.


### 6. Create database tables
This application uses [Phinx](https://phinx.org) to handle the creation and updates to the database tables in atomic steps called "migrations." Phinx is autoconfigured automatically.

Return to the project's root directory and run:

    vendor/bin/phinx migrate

Phinx will create and, if applicable, fill the database with initial data required by the application.

**NOTE:** Any posterior updates to the application might require running this command. Unless noted (and extremely unlikely) there's no harm on running this command on every update. If there's no new pending migrations, nothing will happen.


### 7. Configure the application's environment mode
This application will run by default in **Production environment.**

To enable  **Development environment**, go to the project root's directory and run the following command:

    php composer.phar development enable

To switch back to **Production environment** run:

    php composer.phar development disable

To show the application's current environment:

    php composer.phar development status


### 8. Setup the web server

#### 8.1. For Production
Instructions on how to configure the web server is too long for this README, please follow [the official instructions](https://framework.zend.com/manual/2.4/en/ref/installation.html#apache-setup).

#### 8.2. For Development
The simplest way to get the application running for development is to start the internal PHP CLI Server in the project's root directory:

    php composer.phar serve

Alternatively:

    php -S 0.0.0.0:8080 -t public/ public/index.php

This will start the server on port `8080`, and bind it to all network interfaces.

In a web browser, you can access the application at the URL `http://localhost:8080`


### 9. Setup the Administration interface
For the Administration interface, create a "Super User." Go to the project's root directory, run the following command and provide a password when asked:

    ./skelsus adminauth2:create-super-user

By default, the username is `admin`.

To change the password, run:

    ./skelsus adminauth2:change-user-password

You will be asked for the username and a new password.

The Administration section can be accessed at the `/admin` path of the application's URL root (e.g. `http://localhost:8080/admin`).