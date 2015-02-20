<?php

namespace Rakit\Blade;

use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\View;
use Closure;

class Blade extends Factory {
    
    /**
     * Create a new Blade Factory instance
     *
     * @param array $view_paths
     * @param mixed $view_cache_path
     */
    public function __construct(array $view_paths, $view_cache_path = null) 
    {
    	$resolver = new EngineResolver;
        $finder = new FileViewFinder(new Filesystem, $view_paths);
        $dispatcher = new Dispatcher;

        $resolver->register("blade", function() use ($view_cache_path) {
      		if ( ! is_dir($view_cache_path)) {
	        	mkdir($view_cache_path, 0777, true);
            }

            $blade = new BladeCompiler(new Filesystem, $view_cache_path);
            return new CompilerEngine($blade);
        });

        parent::__construct($resolver, $finder, $dispatcher);
    }

    /**
     * Shortcut for extending compiler
     *
     * @param Closure $compiler
     */
    public function extend(Closure $compiler)
    {
    	$this->getCompiler()->extend($compiler);
    }

    /**
     * Shortcut for getting BladeCompiler
     *
     * @return Illuminate\View\Compilers\BladeCompiler
     */
    public function getCompiler()
    {
    	return $this->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * Shortcut render a view file into string
     *
     * @param string $file
     * @param array $data
     * @return string rendered view
     */
    public function render($file, array $data = array())
    {
    	return $this->make($file, $data)->render();
    }

}
