<?php
// Include the composer autoload file
include_once "vendor/autoload.php";

// Import the necessary classes
use Illuminate\Database\Capsule\Manager as Capsule;
use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';

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

try
{
    // Create the user
    $user = Sentry::createUser(array(
        'email'     => 'op2@op.com',
        'password'  => 'test',
        'activated' => true,
    ));

    // Find the group using the group id
    $adminGroup = Sentry::findGroupByName('Operator');

    // Assign the group to the user
    $user->addGroup($adminGroup);
}
catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
{
    $msg = 'Login field is required.';
}
catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
{
    $msg = 'Password field is required.';
}
catch (Cartalyst\Sentry\Users\UserExistsException $e)
{
    $msg = 'User with this login already exists.';
}
catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
{
    $msg = 'Group was not found.';
}
$data = array(
	'msg' => $msg
);
$blade = new Blade($views, $cache);
echo $blade->view()->make('hello',$data);