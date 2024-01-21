## LaraSocket
Simple socket application for Laravel

## Installation

Install the package through [Composer](http://getcomposer.org/). 

Run the Composer require command from the Terminal:

    composer require akincand/larasocket
    
If you're using Laravel 5.5, this is all there is to do. 

Should you still be on version 5.4 of Laravel, the final steps for you are to add the service provider of the package and alias the package. To do this open your `config/app.php` file.

Add a new line to the `providers` array:

	AkincanD\LaraSocket\PackageServiceProvider::class

And optionally add a new line to the `aliases` array:

	'LaraSocket' => AkincanD\LaraSocket\Facades\LaraSocket::class,

Now you're ready to start using the larasocket in your application.
