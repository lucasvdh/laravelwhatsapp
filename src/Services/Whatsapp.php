<?php namespace Lucasvdh\LaravelWhatsapp\Services;

use Exception;
use Lucasvdh\LaravelWhatsapp\Abstracts\Listener;
use WhatsProt;
use Registration;

class Whatsapp
{

	/**
	 * When requesting the code, you can do it via SMS or voice call, in both cases you
	 * will receive a code like 123-456, that we will use for register the number.
	 *
	 * @param string $username Your phone number with country code, ie: 34123456789
	 * @param string $type
	 * @param bool $debug Shows debug log, this is set to false if not specified
	 * @return Registration
	 * @throws Exception
	 * @internal param string $nickname Your nickname, it will appear in push notifications
	 * @internal param bool $log Enables log file, this is set to false if not specified
	 */
	public function requestCode($username, $type = 'sms', $debug = false)
	{
		// Create a instance of Registration class.
		$registration = new Registration($username, $debug);

		switch ($type) {
			case 'sms':
				$registration->codeRequest('sms');
				break;
			case 'voice':
				$registration->codeRequest('voice');
				break;
			default:
				throw new Exception('Invalid registration type');
		}
		return $registration;
	}

	/**
	 * @param $username
	 * @param $code
	 * @param bool $debug
	 * @return mixed
	 * @throws Exception
	 */
	public function register($username, $code, $debug = false)
	{
		$registration = new Registration($username, $debug);

		$registration_result = $registration->codeRegister($code);

		// Convert to assoc array
		$registration_result = json_decode(json_encode($registration_result), true);

		if (!isset($registration_result['pw'])) {
			throw new Exception('Registration was unsuccessful');
		}

		return $registration_result;
	}

	/**
	 * @param $username
	 * @param bool $debug
	 */
	public function resetPassword($username, $debug = false)
	{
		// Create a new Registration instance
		$registration = new Registration($username, $debug);
		$registration->checkCredentials();
	}

	/**
	 * @param $username
	 * @param $nickname
	 * @param bool $debug
	 * @param bool $log
	 * @return WhatsProt
	 */
	public function getConnection($username, $nickname, $debug = false, $log = false)
	{
		return new WhatsProt($username, $nickname, $debug, $log);
	}

	/**
	 * @param WhatsProt $connection
	 * @param $password
	 * @param Listener $listener
	 * @return WhatsProt
	 */
	public function connect(WhatsProt $connection, $password, Listener $listener)
	{
		//Now continue with your script.
		$connection->connect();
		$connection->loginWithPassword($password);

		return $connection;
	}
}