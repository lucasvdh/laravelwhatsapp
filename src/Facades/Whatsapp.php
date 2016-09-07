<?php namespace Lucasvdh\LaravelWhatsapp\Facades;

use Illuminate\Support\Facades\Facade;

class Whatsapp extends Facade
{

	/**
	 * Get the registered name of the component.
	 *
	 * @return string
	 */
	protected static function getFacadeAccessor()
	{
		return 'whatsapp';
	}
}