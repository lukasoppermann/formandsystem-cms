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
        'data' => json_encode(
          [
            "type" => "block",
            "content" => "#Qualit&#228;t und Service aus Deutschland\\nEntwickelt in enger Zusammenarbeit mit Krankenhäusern und Universitätskliniken",
            "class" => "banner js-banner"
          ]
        ),
      ]
    ]);

  }

}
