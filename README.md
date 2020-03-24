Lightsome
======

Requirements
------------

- PHP 5.6+

Important
-------
This was originaly downloaded from nirix/nanite, I liked how small it is.
Lightsome supports `GET`, `POST`, `PUT`, `PATCH` and `DELETE` requests.

    <?php
    require 'src/Light.php';
    require 'src/functions.php';

    // Use / for the main/index page.
    get('/', function(){
        echo "Front page";
    });

    // All routes start with /
    get('/about', function(){
        echo "About page";
    });

    // Regex enabled, groups get passed to the function.
    get('/projects/([a-zA-Z0-9\-_]+)', function($project){
        echo "Project page for {$project}";
    });

    // Handle a POST request
    post('/contact', function(){
        // Handle submitted contact form.
    });

    // Checking if a route has been matched
    if (!Nanite::$routeProccessed) {
        // 404 page here
    }

Apache `mod_rewrite`
--------------------

    RewriteEngine On
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^(.*)$ index.php/$1 [L,QSA]
    # or
    # RewriteRule ^(.*)$ index.php?url=/$1 [L,QSA]
    
Lighttpd `mod_rewrite`
----------------------

    server.modules += ( "mod_rewrite" )
    url.rewrite-if-not-file += (
        "^/(.*)" => "/index.php?url=/$1"
    )
