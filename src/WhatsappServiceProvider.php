<?php namespace Lucasvdh\LaravelWhatsapp;

use File;
use Illuminate\Support\ServiceProvider;

class WhatsappServiceProvider extends ServiceProvider
{

	public function boot()
	{
		$this->app->bind('whatsapp', function () {
			return new Services\Whatsapp;
		});
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}
}