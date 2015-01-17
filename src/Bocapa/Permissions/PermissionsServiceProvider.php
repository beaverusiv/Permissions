<?php namespace Bocapa\Permissions;

use Illuminate\Support\ServiceProvider;

class PermissionsServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
        $this->package('bocapa/permissions');

        \Event::listen('permissions.changed', function()
        {
            Permissions::cache();
        });

        \Event::listen('permissions.generate', function($param)
        {
            Permissions::generate($param);
        });
	}

    public function boot()
    {
        if(!\Cache::has('permissions')) {
            Permissions::cache();
        }

        include __DIR__.'/../../routes.php';
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
