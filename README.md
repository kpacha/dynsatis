#Dynsatis

Local repository manager for composer

Dynsatis allows you to create and mantain several local private repositories for your
composer packages and repos or for mirroring third-party ones.

##Installation

The easiest way:

    # Use the `dev-master` version if you want to be more up-to-date.
    $ composer create-project kpacha/dynsatis dynsatis v0.1.0

Or you could clone this repo

    $ git clone https://github.com/kpacha/dynsatis.git
    $ cd dynsatis
    $ composer install -o

##Configuration

Example setup for Apache2 (supposing you are using the hostname `dynsatis.local`)

    <VirtualHost *:80>
        ServerName dynsatis.local
        DocumentRoot "/var/www/dynsatis/web"
        DirectoryIndex index.php
        #SetEnv APPLICATION_ENV production
        SetEnv APPLICATION_ENV development

        <Directory "/var/www/dynsatis/web">
            Options -Indexes
            AllowOverride None
            Allow from All
            Order Allow,Deny
            RewriteEngine On
            RewriteCond %{REQUEST_FILENAME} -s [OR]
            RewriteCond %{REQUEST_FILENAME} -l [OR]
            RewriteCond %{REQUEST_FILENAME} -d
            RewriteRule ^.*$ - [NC,L]
            RewriteRule ^.*$ index.php [NC,L]
        </Directory>
    </VirtualHost>

Remember to set the right `APPLICATION_ENV` value for your use case!

Check the config files placed at `resources/config/`. Edit those files if you want to customize something.
