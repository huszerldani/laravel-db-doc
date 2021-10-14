<?php

namespace Pinasen\DbDoc;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class DbDocGenerator extends Controller
{
	private function getTables($database) {
		$query = "SELECT table_name, table_comment FROM information_schema.tables WHERE table_schema='$database'";
	    return DB::select($query);
    }

	private function getColumnInformations($table) {
		return DB::select("SHOW FULL COLUMNS FROM $table");
	}

	private function getIndexes($table) {
		return DB::select("SHOW KEYS FROM $table");
	}

	public function generateDatabaseDoc() {
		$getIndexes = config('db_doc.with_index');

		$database = env('DB_DATABASE');

		if (!$database) {
			return [
				"status" => "error",
				"message" => "No database specified in the .env file"
			];
		}

		$tables = self::getTables($database);

		$tablesFormatted = [];
		foreach($tables as $table) {
			$tableFormatted = [
				"name" => $table->table_name,
				"comment" => $table->table_comment,
			];

			$columns = self::getColumnInformations($table->table_name);
			$tableFormatted['columns'] = $columns;

			if ($getIndexes) {
				$indexes = self::getIndexes($table->table_name);
				$tableFormatted['indexes'] = $indexes;
			}

			$tablesFormatted[] = $tableFormatted;
		}

		$markdown = view('db_doc::database_doc')->with([
			'tables' => $tablesFormatted,
			'database' => $database
		]);

		$path = base_path().'/'.config('db_doc.folder');

		if (!File::exists($path)) {
			File::makeDirectory($path);
		}

		$fileName = config('db_doc.file_name');

		$markdownFormatted = e($markdown);

		File::put($path.'/'.$fileName, $markdownFormatted);

		return [
			"status" => "ok",
			"path" => $path.'/'.$fileName
		];
	}
}
