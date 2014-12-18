<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FsContentFragmentTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{

		\DB::table('fs_content_fragments')->truncate();


			$items = [
				[
				'fragment_id' => 1,
				'content_id' => 1
				],
				[
				'fragment_id' => 1,
				'content_id' => 2
				],
				[
				'fragment_id' => 1,
				'content_id' => 3
				],
				[
					'fragment_id' => 1,
					'content_id' => 4
				],
				[
					'fragment_id' => 1,
					'content_id' => 5
				],
				[
					'fragment_id' => 1,
					'content_id' => 6
				],
				[
					'fragment_id' => 1,
					'content_id' => 7
				]
			];

		\DB::table('fs_content_fragments')->insert($items);
	}

}
