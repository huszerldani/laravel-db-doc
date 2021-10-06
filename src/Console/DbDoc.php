<?php

namespace Pinasen\DbDoc\Console;

use Illuminate\Console\Command;
use Pinasen\DbDoc\DbDocGenerator;

class DbDoc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db-doc:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates database documentation from mysql database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
	    $database = env('DB_DATABASE');

		if (!$database) {
			$this->error('No database specified in the .env file');
		}

		$generator = new DbDocGenerator;
        $result = $generator->generateDatabaseDoc();

		if ($result['status'] === 'ok') {
			$path = $result['path'];
			$this->info("Database documentation generated from database: $database --> $path");
		} else {
			$this->error($result['message']);
		}
    }
}
