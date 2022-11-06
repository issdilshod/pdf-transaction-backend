<?php

namespace Database\Seeders;

use App\Models\Helpers\Font;
use App\Models\Helpers\FontGroup;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() 
    {
        $fontGroup = FontGroup::where('name', 'Connections')->first();
        if ($fontGroup!=null){
            $fontList = [
                ['ascii' => '—', 'unicode' => '<2014>', 'hex' => '36'],
                ['ascii' => '™', 'unicode' => '<2122>', 'hex' => '39'],
                ['ascii' => ' ', 'unicode' => '<0020>', 'hex' => '40'],
                ['ascii' => '.', 'unicode' => '<002E>', 'hex' => '4B'],
                ['ascii' => '(', 'unicode' => '<0028>', 'hex' => '4D'],
                ['ascii' => '+', 'unicode' => '<002B>', 'hex' => '4E'],
                ['ascii' => '!', 'unicode' => '<0021>', 'hex' => '4F'],
                ['ascii' => '&', 'unicode' => '<0026>', 'hex' => '50'],
                ['ascii' => '$', 'unicode' => '<0024>', 'hex' => '5B'],
                ['ascii' => '*', 'unicode' => '<002A>', 'hex' => '5C'],
                ['ascii' => ')', 'unicode' => '<0029>', 'hex' => '5D'],
                ['ascii' => ';', 'unicode' => '<003B>', 'hex' => '5E'],
                ['ascii' => '-', 'unicode' => '<002D>', 'hex' => '60'],
                ['ascii' => '/', 'unicode' => '<002F>', 'hex' => '61'],
                ['ascii' => ',', 'unicode' => '<002C>', 'hex' => '6B'],
                ['ascii' => '_', 'unicode' => '<005F>', 'hex' => '6D'],
                ['ascii' => ':', 'unicode' => '<003A>', 'hex' => '7A'],
                ['ascii' => '#', 'unicode' => '<0023>', 'hex' => '7B'],
                ['ascii' => "'", 'unicode' => '<0027>', 'hex' => '7D'],
                ['ascii' => 'a', 'unicode' => '<0061>', 'hex' => '81'],
                ['ascii' => 'b', 'unicode' => '<0062>', 'hex' => '82'],
                ['ascii' => 'c', 'unicode' => '<0063>', 'hex' => '83'],
                ['ascii' => 'd', 'unicode' => '<0064>', 'hex' => '84'],
                ['ascii' => 'e', 'unicode' => '<0065>', 'hex' => '85'],
                ['ascii' => 'f', 'unicode' => '<0066>', 'hex' => '86'],
                ['ascii' => 'g', 'unicode' => '<0067>', 'hex' => '87'],
                ['ascii' => 'h', 'unicode' => '<0068>', 'hex' => '88'],
                ['ascii' => 'i', 'unicode' => '<0069>', 'hex' => '89'],
                ['ascii' => 'j', 'unicode' => '<006A>', 'hex' => '91'],
                ['ascii' => 'k', 'unicode' => '<006B>', 'hex' => '92'],
                ['ascii' => 'l', 'unicode' => '<006C>', 'hex' => '93'],
                ['ascii' => 'm', 'unicode' => '<006D>', 'hex' => '94'],
                ['ascii' => 'n', 'unicode' => '<006E>', 'hex' => '95'],
                ['ascii' => 'o', 'unicode' => '<006F>', 'hex' => '96'],
                ['ascii' => 'p', 'unicode' => '<0070>', 'hex' => '97'],
                ['ascii' => 'q', 'unicode' => '<0071>', 'hex' => '98'],
                ['ascii' => 'r', 'unicode' => '<0072>', 'hex' => '99'],
                ['ascii' => 's', 'unicode' => '<0073>', 'hex' => 'A2'],
                ['ascii' => 't', 'unicode' => '<0074>', 'hex' => 'A3'],
                ['ascii' => 'u', 'unicode' => '<0075>', 'hex' => 'A4'],
                ['ascii' => 'v', 'unicode' => '<0076>', 'hex' => 'A5'],
                ['ascii' => 'w', 'unicode' => '<0077>', 'hex' => 'A6'],
                ['ascii' => 'x', 'unicode' => '<0078>', 'hex' => 'A7'],
                ['ascii' => 'y', 'unicode' => '<0079>', 'hex' => 'A8'],
                ['ascii' => 'z', 'unicode' => '<007A>', 'hex' => 'A9'],
                ['ascii' => '·', 'unicode' => '<00B7>', 'hex' => 'B3'],
                ['ascii' => '©', 'unicode' => '<00A9>', 'hex' => 'B4'],
                ['ascii' => 'A', 'unicode' => '<0041>', 'hex' => 'C1'],
                ['ascii' => 'B', 'unicode' => '<0042>', 'hex' => 'C2'],
                ['ascii' => 'C', 'unicode' => '<0043>', 'hex' => 'C3'],
                ['ascii' => 'D', 'unicode' => '<0044>', 'hex' => 'C4'],
                ['ascii' => 'E', 'unicode' => '<0045>', 'hex' => 'C5'],
                ['ascii' => 'F', 'unicode' => '<0046>', 'hex' => 'C6'],
                ['ascii' => 'G', 'unicode' => '<0047>', 'hex' => 'C7'],
                ['ascii' => 'H', 'unicode' => '<0048>', 'hex' => 'C8'],
                ['ascii' => 'I', 'unicode' => '<0049>', 'hex' => 'C9'],
                ['ascii' => 'J', 'unicode' => '<004A>', 'hex' => 'D1'],
                ['ascii' => 'K', 'unicode' => '<004B>', 'hex' => 'D2'],
                ['ascii' => 'L', 'unicode' => '<004C>', 'hex' => 'D3'],
                ['ascii' => 'M', 'unicode' => '<004D>', 'hex' => 'D4'],
                ['ascii' => 'N', 'unicode' => '<004E>', 'hex' => 'D5'],
                ['ascii' => 'O', 'unicode' => '<004F>', 'hex' => 'D6'],
                ['ascii' => 'P', 'unicode' => '<0050>', 'hex' => 'D7'],
                ['ascii' => 'Q', 'unicode' => '<0051>', 'hex' => 'D8'],
                ['ascii' => 'R', 'unicode' => '<0052>', 'hex' => 'D9'],
                ['ascii' => '¹', 'unicode' => '<00B9>', 'hex' => 'DA'],
                ['ascii' => 'S', 'unicode' => '<0053>', 'hex' => 'E2'],
                ['ascii' => 'T', 'unicode' => '<0054>', 'hex' => 'E3'],
                ['ascii' => 'U', 'unicode' => '<0055>', 'hex' => 'E4'],
                ['ascii' => 'V', 'unicode' => '<0056>', 'hex' => 'E5'],
                ['ascii' => 'W', 'unicode' => '<0057>', 'hex' => 'E6'],
                ['ascii' => 'X', 'unicode' => '<0058>', 'hex' => 'E7'],
                ['ascii' => 'Y', 'unicode' => '<0059>', 'hex' => 'E8'],
                ['ascii' => 'Z', 'unicode' => '<005A>', 'hex' => 'E9'],
                ['ascii' => '0', 'unicode' => '<0030>', 'hex' => 'F0'],
                ['ascii' => '1', 'unicode' => '<0031>', 'hex' => 'F1'],
                ['ascii' => '2', 'unicode' => '<0032>', 'hex' => 'F2'],
                ['ascii' => '3', 'unicode' => '<0033>', 'hex' => 'F3'],
                ['ascii' => '4', 'unicode' => '<0034>', 'hex' => 'F4'],
                ['ascii' => '5', 'unicode' => '<0035>', 'hex' => 'F5'],
                ['ascii' => '6', 'unicode' => '<0036>', 'hex' => 'F6'],
                ['ascii' => '7', 'unicode' => '<0037>', 'hex' => 'F7'],
                ['ascii' => '8', 'unicode' => '<0038>', 'hex' => 'F8'],
                ['ascii' => '9', 'unicode' => '<0039>', 'hex' => 'F9']
            ];

            foreach($fontList AS $key => $value):
                Font::create([
                    'font_group_id' => $fontGroup->id,
                    'ascii' =>  $value['ascii'],
                    'unicode' =>  $value['unicode'],
                    'hex' =>  $value['hex'],
                ]);
            endforeach;
        }
    }
}
