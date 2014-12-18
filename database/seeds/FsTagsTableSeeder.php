<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FsTagsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$fake = Faker::create();

		\DB::table('fs_tags')->truncate();

		foreach(range(1,10) as $index)
		{
			$items[] = [
				'name' => $fake->word()
			];
		}

		\DB::table('fs_tags')->insert($items);
	}

}
