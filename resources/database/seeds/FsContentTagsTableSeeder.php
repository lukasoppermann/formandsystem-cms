<?php
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class FsContentTagsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		$fake = Faker::create();

		\DB::table('fs_content_tags')->truncate();

		foreach(range(1,20) as $index)
		{
			$items[] = [
				'tag_id' => $fake->numberBetween(1, 10),
				'content_id' => $fake->numberBetween(1, 10)
			];
		}

		\DB::table('fs_content_tags')->insert($items);
	}

}
