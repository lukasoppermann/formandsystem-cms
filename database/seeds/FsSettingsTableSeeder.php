<?php
use Illuminate\Database\Seeder;

class FsSettingsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{

		\DB::table('fs_settings')->truncate();


			$items = [
				[
					'key' => 'text',
					'group' => 'fragment',
					'setting' => json_encode([
						'name' => 'Text element',
						'description' => 'A block of text',
						'fields' => [
							'content' => 'textarea'
						]
					])
				],
				[
					'key' => 'media',
					'group' => 'fragment',
					'setting' => json_encode([
						'name' => 'Media element',
						'description' => 'Something like an image or a video',
						'fields' => [
							'path' => 'media_path'
						]
					])
				],
				[
					'key' => 'title',
					'group' => 'site',
					'setting' => 'Your pages title'
				],
			];

		\DB::table('fs_settings')->insert($items);
	}

}
