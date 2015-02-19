<?php

/**
 * Rakit Framework View Engine Class
 * --------------------------------------
 * This class is only for rakit framework
 */

namespace Rakit\Blade;

use Rakit\Framework\App;
use Rakit\Framework\Services\View\ViewEngine;

class RakitViewEngine extends ViewEngine {

	protected $app;

	public function __construct(App $app)
	{
		$this->app = $app;
	}

	/**
	 * Render view file with blade factory
	 *
	 * @param string $file
	 * @param array $data
	 * @return string rendered view
	 */
	public function render($file, array $data = [])
	{
		return $this->app->blade->render($file, $data);
	}

}