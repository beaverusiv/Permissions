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
        \App::bind('permissions', function()
        {
            return new Permissions;
        });

        \Event::listen('permissions.changed', function()
        {
            Permissions::cache();
        });

        \Event::listen('permissions.generate', function($param)
        {
            Permissions::generate($param);
        });

        \Event::listen('menu.generate', function()
        {
            $menu_options = [
                'ul' => ['class' => 'treeview-menu'],
                'text-prepend' => '<i class="fa fa-lock"></i>',
                'text-append' => '<i class="fa fa-angle-left pull-right"></i>',
                'li' => ['class' => 'treeview']
            ];

            $groups_options = [
                'a' => [
                    'route' => 'groups.adminBrowse',
                    'style' => 'margin-left: 2px;'
                ],
                'text-prepend' => '<i class="fa fa-angle-double-right"></i>'
            ];

            $edit_group_options = [
                'a' => [
                    'route' => 'groups.adminEdit'
                ],
                'hidden' => true
            ];

            if($menu = \Menu::exists('backend')) {
                $content = $menu->addItem('Permissions', $menu_options);
                $groups = $content->addItem('Groups', $groups_options);
                $groups->addItem('Edit Group', $edit_group_options);
            }
        });
	}

    public function boot()
    {
        if(!\Cache::has('permissions')) {
            Permissions::cache();
        }

        include __DIR__.'/routes.php';

        $this->loadViewsFrom(__DIR__.'/views', 'permissions');

        $this->publishes([
            __DIR__.'/config/config.php' => config_path('permissions.php'),
        ]);

        \Route::filter('bocapa.auth', function()
        {
            if(!Permissions::allowed(\Route::current()->getName())) {
                return \Redirect::to('/');
            }
        });

        // Nuclear option to run our permission checking on all routes.
        \Route::when('*', 'bocapa.auth');
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
