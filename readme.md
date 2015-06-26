# Site Interlar

Criado utilizando Laravel Framework 5.1  
com Framework de Front-end Bootstrap3

##Requirements

	PHP >= 5.5.9
	OpenSSL PHP Extension
	Mbstring PHP Extension
	Tokenizer PHP Extension
	SQL server(for example MySQL)
	Composer
	Node JS

<a name="feature3"></a>
##How to install:
* [Step 1: Get the code](#step1)
* [Step 2: Use Composer to install dependencies](#step2)
* [Step 3: Configure Mailer](#step3)
* [Step 4: Create database](#step4)
* [Step 5: Install](#step5)
* [Step 6: Start Page](#step6)

-----
<a name="step1"></a>
### Step 1: Get the code - Download the repository

    

Extract it in www(or htdocs if you using XAMPP) folder and put it for example in interlar folder.

-----
<a name="step2"></a>
### Step 2: Use Composer to install dependencies

Laravel utilizes [Composer](http://getcomposer.org/) to manage its dependencies. First, download a copy of the composer.phar.
Once you have the PHAR archive, you can either keep it in your local project directory or move to
usr/local/bin to use it globally on your system.
On Windows, you can use the Composer [Windows installer](https://getcomposer.org/Composer-Setup.exe).

Then run:

    composer install
to install dependencies Laravel and other packages.

-----
<a name="step3"></a>
### Step 3: Configure Mailer

In the same fashion, copy the ***config/mail.php*** configuration file in ***config/local/mail.php***. Now set the `address` and `name` from the `from` array in ***config/mail.php***. Those will be used to send account confirmation and password reset emails to the users.
If you don't set that registration will fail because it cannot send the confirmation email.

-----
<a name="step4"></a>
### Step 4: Create database

If you finished first three steps, now you can create database on your database server(MySQL). You must create database
with utf-8 collation(uft8_general_ci), to install and application work perfectly.
After that, copy .env.example and rename it as .env and put connection and change default database connection name, only database connection, put name database, database username and password.

-----
<a name="step5"></a>
### Step 5: Install

This project makes use of Bower and Laravel Elixir. Before triggering Elixir, you must first ensure that Node.js (included in homestead) is installed on your machine.

    node -v

Install dependencies listed in package.json with:

    npm install

Retrieve frontend dependencies with Bower, compile SASS, and move frontend files into place:

    gulp

Now that you have the environment configured, you need to create a database configuration for it. For create database tables use this command:

    php artisan migrate

And to initial populate database use this:

    php artisan db:seed

If you install on your localhost in folder laravel5startersite, you can type on web browser:

	http://localhost/laravel5startersite/public
-----
<a name="step6"></a>
### Step 6: Start Page

You can now login to admin part of Laravel Framework 5  Bootstrap 3 Starter Site:

    username: admin@admin.com
    password: admin
OR user

    username: user@user.com
    password: user

-----
<a name="feature5"></a>
## Troubleshooting

### RuntimeException : No supported encrypter found. The cipher and / or key length are invalid.

php artisan key:generate

### Cache busting with Elixir
Version-ing of css an javascript is achieved through laravel-elixir. If your javascript or css changes aren't coming through, make sure your work is picked up by gulpfile.js when running gulp.

Note: Blade gets the path to a versioned Elixir file with the following method call:

    elixir($file);

### Site loading very slow

	composer dump-autoload --optimize
OR

    php artisan dump-autoload

-----
<a name="feature6"></a>
## License

This is free software distributed under the terms of the MIT license

-----
<a name="feature7"></a>
## Additional information

Inspired by and based on [andrew13's Laravel-4-Bootstrap-Starter-Site](https://github.com/andrew13/Laravel-4-Bootstrap-Starter-Site)

###Disable gulp-notify
If you are running on a system that handles notifications poorly or you simply do not wish to use gulp-notify but your project does? You can disable gulp-notify by using enviroment variable DISABLE_NOTIFIER.

    export DISABLE_NOTIFIER=true;

<a name="feature8"></a>
##How Starter Site is look like

![Index](http://i62.tinypic.com/2ed8ins.jpg)
![Login](http://i62.tinypic.com/madw7q.jpg)
![Register new user](http://i62.tinypic.com/1586pew.jpg)
![Admin dashboard](http://i61.tinypic.com/2ezgz2w.jpg)
![Admin users](http://i59.tinypic.com/24lpixt.jpg)
![Admin list users](http://i60.tinypic.com/28b9my1.jpg)
