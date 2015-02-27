<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Illuminate\Database\Capsule\Manager as Capsule;

// Create the Sentry alias
class_alias('Cartalyst\Sentry\Facades\Native\Sentry', 'Sentry');

// Create a new Database connection
$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'ovalinfo',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
]);

$capsule->bootEloquent();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
	
	$username = $_POST['username'];
	$password = $_POST['password'];

	$filtered_username = filter_var($username, FILTER_SANITIZE_STRING);
	$filtered_password = filter_var($password, FILTER_SANITIZE_STRING);

	try
	{
	    // Login credentials
	    $credentials = array(
	        'email'    => $username,
	        'password' => $password
	    );

	    // Authenticate the user
	    $user = Sentry::authenticate($credentials, false);
	}
	catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
	{
	    echo 'Login field is required.';
	}
	catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
	{
	    echo 'Password field is required.';
	}
	catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
	{
	    echo 'Wrong password, try again.';
	}
	catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
	{
	    echo 'User was not found.';
	}
	catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
	{
	    echo 'User is not activated.';
	}

	// The following is only required if the throttling is enabled
	catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
	{
	    echo 'User is suspended.';
	}
	catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
	{
	    echo 'User is banned.';
	}
}

if ( ! Sentry::check())
{
    // User is not logged in, or is not activated
    
}
else
{
    // User is logged in
    var_dump(Sentry::getUser());
}