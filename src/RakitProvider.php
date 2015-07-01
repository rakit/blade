<?php

/**
 * Provider Class for Rakit Framework
 * --------------------------------------
 * This class is only for rakit framework
 */

namespace Rakit\Blade;

use Rakit\Framework\App;
use Rakit\Framework\Provider;

class RakitProvider extends Provider {

	/**
	 * Register blade instance on application booting
	 */
	public function register()
	{
		$app = $this->app;
		$app['blade'] = $app->container->singleton(function($container) use ($app) {
			$view_paths = [ $app->config['view.path'] ];
			$view_cache_path = $app->config['view.cache_path'];

			$blade = new Blade($view_paths, $view_cache_path);
			return $blade;
		});

		$app->config['view.engine'] = new RakitViewEngine($app);
	}

	/**
	 * Register view macro on application booting
	 */
	public function boot()
	{
		$app = $this->app;

		$app->macro('blade', function($file, array $data = []) use ($app) {
			return $app->blade->render($file, $data);
		});
	}

}
