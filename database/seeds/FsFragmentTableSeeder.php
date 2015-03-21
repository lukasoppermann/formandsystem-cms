<?php
use Illuminate\Database\Seeder;

class FsFragmentTableSeeder extends Seeder {

  /**
  * Auto generated seed file
  *
  * @return void
  */
  public function run()
  {
    \DB::table('fs_fragments')->truncate();

    \DB::table('fs_fragments')->insert([
      [
        'id' => 1,
        'key' => null,
        'type' => "text",
        'data' => json_encode(
          [
            "text" => "#Qualit&#228;t und Service aus Deutschland\\nEntwickelt in enger Zusammenarbeit mit Krankenhäusern und Universitätskliniken",
            "class" => "banner js-banner"
          ]
        ),
      ],
      [
        'id' => 2,
        'key' => null,
        'type' => "timeline",
        'data' => json_encode(
        [
          'title' => 'Titel',
          'text' => "Test",
          "class" => "banner js-banner"
          ]
        ),
        ]
    ]);

  }

}
