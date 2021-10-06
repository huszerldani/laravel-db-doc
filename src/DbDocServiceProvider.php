<?php

namespace Pinasen\DbDoc;

use Illuminate\Support\ServiceProvider;
use Pinasen\DbDoc\Console\DbDoc;

class DbDocServiceProvider extends ServiceProvider {
	public function boot() {
		$this->publishes([
			__DIR__.'/../config/db_doc.php' => config_path('db_doc.php'),
			__DIR__.'/../resources/views' => resource_path('views/vendor/db_doc'),
		]);

		$this->loadViewsFrom(__DIR__.'/../resources/views', 'db_doc');

		$this->commands([
			DbDoc::class,
		]);
	}

	public function register() {
		$this->mergeConfigFrom(
			__DIR__.'/../config/db_doc.php', 'db_doc'
		);
	}
}