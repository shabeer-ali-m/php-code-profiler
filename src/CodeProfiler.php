<?php

namespace CodeProfiler;

use Fabfuel\Prophiler\Benchmark\Benchmark as Benchmark;

class CodeProfiler 
{
	static private $instance = [];

	static public $prophiler;

	static private $active;

	static public function checkpoint($name, array $metadata = [], $component = null)
	{
		if (is_null(self::$prophiler)) {
			self::$prophiler =  new \Fabfuel\Prophiler\Profiler();
		}

		if (!is_null(self::$active)) {
			self::end();
		}

		self::$active = new Benchmark($name, $metadata, $component);
		self::$active->start();
	}

	static public function end()
	{
		self::$active->stop();
		self::$prophiler->addBenchmark(self::$active);
	}

	static public function render($file = "")
	{
		$toolbar = new \Fabfuel\Prophiler\Toolbar(self::$prophiler);
		if ($file != "")
			file_put_contents($file, $toolbar->render());
		else
			return $toolbar->render();
	}
}