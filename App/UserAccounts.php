<?php

use Illuminate\Database\Capsule\Manager as Capsule;
// Create the Sentry alias
class_alias('Cartalyst\Sentry\Facades\Native\Sentry', 'Sentry');

/**
* 
*/
class UserAccounts {
	private $capusle;
	private $msg;
	private $user;

	public function __construct(){
		// Create a new Database connection
		$this->capsule = new Capsule;
		$this->capsule->addConnection([
	    'driver'    => 'mysql',
	    'host'      => 'localhost',
	    'database'  => 'ovalinfo',
	    'username'  => 'root',
	    'password'  => '',
	    'charset'   => 'utf8',
	    'collation' => 'utf8_unicode_ci',
		]);

		$this->msg = '';

		$this->capsule->bootEloquent();
		// Get the Throttle Provider
		$provider = Sentry::getThrottleProvider();

	}

	/**
	 * authenticate user
	 *
	 * @return string
	 **/

	public function login($username, $password, $remember=false){
		$throttleProvider = Sentry::getThrottleProvider();
		$throttleProvider->enable();
		try{
		    // Login credentials
		    $credentials = array(
		        'username' => $username,
		        'password' => $password
		    );

		    // Authenticate the user
		    $this->user = Sentry::authenticate($credentials, false);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $this->msg = 'Login field is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    $this->msg = 'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\WrongPasswordException $e)
		{
		    $this->msg = 'Wrong password, try again.';
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    $this->msg = 'User was not found.';
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
		    $this->msg = 'User is not activated.';
		}

		// The following is only required if the throttling is enabled
		catch (Cartalyst\Sentry\Throttling\UserSuspendedException $e)
		{
		    $this->msg = 'User is suspended.';
		}
		catch (Cartalyst\Sentry\Throttling\UserBannedException $e)
		{
		    $this->msg = 'User is banned.';
		}

		return $this->msg;
	}

	/**
	 * logout user
	 *
	 * @return void
	 **/
	public function logout(){
		Sentry::logout();
	}

	/**
	 * check if user is logged in
	 *
	 * @return boolean
	 **/

	public function isLoggedIn(){
		if ( ! Sentry::check()){
			return false;
		}else{
			return true;
		}
	}

	/**
	 * return current users id
	 *
	 * @return string
	 **/
	public function getCurrentId(){
		return Sentry::getUser()->id;
	}

	/**
	 * check if the user is admin
	 *
	 * @return boolean
	 **/
	public function isAdmin(){
		if($this->isLoggedIn()){

			$this->user = Sentry::findUserByID(Sentry::getUser()->id);
			if($this->isLoggedIn()){
				if ($this->user->hasAccess('users') && $this->user->hasAccess('admin')){
	     		return true;
		    }else{
		    	return false;
		    }
			}

		}	
	}

	/**
	 * if is a operator
	 *
	 * @return boolean
	 **/
	public function isOperator(){
		if($this->isLoggedIn()){

			$this->user = Sentry::findUserByID(Sentry::getUser()->id);
			if(!$this->isSuspended(Sentry::getUser()->id)){
				if ($this->user->hasAccess('users') && !$this->user->hasAccess('admin')){
	     		return true;
		    }else{
		    	return false;
		    }
			}
		}	
	}

	/**
	 * create a new activated operator
	 *
	 * @return string
	 **/
	public function createOperator($username,$password){
		try
		{
		    // Create the user
		    $new_user = Sentry::createUser(array(
		        'username'	=> $username,
		        'password'  => $password,
		        'activated' => true
		    ));

		    // Find the group using the group id
		    $OpGroup = Sentry::findGroupByName('Operator');

		    // Assign the group to the user
		    $new_user->addGroup($OpGroup);
		}
		catch (Cartalyst\Sentry\Users\LoginRequiredException $e)
		{
		    $this->msg = 'Username is required.';
		}
		catch (Cartalyst\Sentry\Users\PasswordRequiredException $e)
		{
		    $this->msg =  'Password field is required.';
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    $this->msg =  'User with this login already exists.';
		}
		catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
		{
		    $this->msg =  'Group was not found.';
		}
		return $this->msg;
	}

	/**
	 * undocumented function
	 *
	 * @return void
	 **/
	public function listOperators(){
		$group = Sentry::findGroupByName('Operator');
		return Sentry::findAllUsersInGroup($group);
	}

	/**
	 * check if the user is suspended
	 *
	 * @return boolean
	 **/
	public function isSuspended($user_id){
		try{
	    $throttle = Sentry::findThrottlerByUserId($user_id);

	    if($banned = $throttle->isSuspended()){
	       return true;
	    }
	    else{
	       return false;
	    }
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    return true;
		}
	}

	/**
	 * suspend user
	 *
	 * @return void
	 **/
	public function suspend($user_id){
		try
		{
		    // Find the user using the user id
		    $throttle = Sentry::findThrottlerByUserId($user_id);

		    // Suspend the user
		    $throttle->suspend();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    //echo 'User was not found.';
		}
	}

	/**
	 * suspend user
	 *
	 * @return void
	 **/
	public function activate($user_id){
		try
		{
	    // Find the user using the user id
	    $throttle = Sentry::findThrottlerByUserId($user_id);

	    // Unsuspend the user
	    $throttle->unsuspend();
		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    //echo 'User was not found.';
		}
	}

	/**
	 * update name of operator
	 *
	 * @return void
	 **/
	public function updateProfile($first_name,$last_name){
		//Sentry::getUser()->id
    try
		{

		    // Update the user details
		    $this->user->first_name = $first_name;
		    $this->user->last_name = $last_name;

		    // Update the user
		    if ($this->user->save())
		    {
		        // User information was updated
		    }
		    else
		    {
		        // User information was not updated
		    }
		}
		catch (Cartalyst\Sentry\Users\UserExistsException $e)
		{
		    echo 'User with this login already exists.';
		}
	}

	/**
	 * get first and lastname of operator
	 *
	 * @return array
	 * @author 
	 **/
	public function getOperatorName(){
		return array(
			'first-name' => $this->user->first_name,
			'last-name' => $this->user->last_name
			);
	}

	/**
	 * change password by operator
	 *
	 * @return string
	 * @author 
	 **/
	public function operatorChangePassword($old_password,$new_password){
		$resetCode = $this->user->getResetPasswordCode();

		if($this->user->checkPassword($old_password)){
        if ($this->user->attemptResetPassword($resetCode, $new_password)){
          return 'Password reset passed';
        }
        else{
            return 'Password reset failed';
        }
    }
    else{
        return 'Password does not match.';
    }
	}

}