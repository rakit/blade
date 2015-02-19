<?php

/**
 * Provider Class for Rakit Framework
 * --------------------------------------
 * This class is only for rakit framework
 */

namespace Rakit\Blade;

use Rakit\Framework\App;
use Rakit\Framework\ServiceProviderInterface;

class RakitProvider implements ServiceProviderInterface {

	/**
	 * Register blade instance on application booting
	 *
	 * @param Rakit\Framework\App $app
	 */
	public function boot(App $app)
	{
		$app->singleton('blade', function($app) {
			$view_paths = [ $app->config['view.path'] ];
			$view_cache_path = $app->config['view.cache_path'];

			$blade = new Blade($view_paths, $view_cache_path);
			return $blade;
		});
		
		$app->config['view.engine'] = new RakitViewEngine($app);
	}

	/**
	 * Add some macro when application run
	 *
	 * @param Rakit\Framework\App $app
	 */
	public function run(App $app)
	{
		$app->macro('view', function($file, array $data = []) use ($app) {
			return $app->blade->render($file, $data);
		});

		$app->macro('render', function($file, array $data = []) use ($app) {
			echo $app->view($file, $data);
		});
	}

}
