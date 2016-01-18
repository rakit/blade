<?php

use Rakit\Blade\Blade;
use Illuminate\View\Compilers\BladeCompiler;

class BladeTest extends PHPUnit_Framework_TestCase {

	private $blade;

	/**
	 * Setup blade factory 
	 */
	protected function setUp()
	{
		$view_paths = [ __DIR__.'/src/views' ];
		$view_cache_path = __DIR__.'/src/caches';
		$this->blade = new Blade($view_paths, $view_cache_path);	
	}

	public function testGetCompiler()
	{
		$this->assertTrue($this->blade->getCompiler() instanceof BladeCompiler);
	}

	public function testRender()
	{
		$rendered = $this->blade->render('test', ['message' => 'foobar']);
		$expected_result = '<h1>foobar</h1>';

		$this->assertTrue(trim($rendered) == $expected_result);
	}

	public function testExtendCompiler()
	{
		$this->blade->directive('uppercase', function($exp) {
			return "<?php echo strtoupper({$exp});?>";
		});

		$rendered = $this->blade->render('uppercase', ['message' => 'foobar']);
		$expected_result = 'FOOBAR';

		$this->assertEquals(trim($rendered), $expected_result);
	}

	/**
	 * Clean cache files after tests
	 */
	protected function tearDown()
	{
		$cache_path = __DIR__.'/src/caches';
		$ignored_files = ['.', '..', '.gitkeep'];	
		$cache_files = array_diff(scandir($cache_path), $ignored_files);

		if(empty($cache_files)) return;

		foreach($cache_files as $file) {
			unlink($cache_path.'/'.$file);
		}
	}

}