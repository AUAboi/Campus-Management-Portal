<?php

namespace Database\Seeders;

use App\Models\Faculty;
use DOMXPath;
use DOMDocument;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        list($faculties, $departments)  = $this->get_faculties_and_departments();
        $i = 0;

        foreach ($faculties as $faculty) {
            $faculty_model =  Faculty::create($faculty);

            //create array from string by slicing every new line
            $department_array = explode("\n", $departments[$i]["department_name"]);
            //remove white space from array
            $department_array = preg_replace('/\h+/', ' ', $department_array);

            //removes waste lines
            array_pop($department_array);
            array_shift($department_array);

            foreach ($department_array as $dept) {
                //Check if empty 
                if (trim($dept) != '') {
                    $faculty_model->departments()->create(array("department_name" => $dept));
                }
            }
            $i++;
        }
    }

    //Function to fetch faculties and departments from gcuf website
    //Messy, I know. But it works

    protected function get_faculties_and_departments()
    {
        $list = '<a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Faculties';
        $response = Http::get('https://gcuf.edu.pk/');
        $body = $response->body();
        $table_first = explode($list, $body);
        $table_second = explode('<li class="nav-item dropdown ">', $table_first[1]);
        $table_second[0] = "<li>" . $table_second[0];

        $dom = new DOMDocument();
        @$dom->loadHTML($table_second[0]);


        $xpath = new DOMXPath($dom);

        $faculty_list = $xpath->evaluate("/html/body/li/ul/li/a");
        $department_list = $xpath->evaluate("/html/body/li/ul/li/ul");

        for ($i = 0; $i < $faculty_list->length; $i++) {
            $faculty_item = $faculty_list->item($i);
            $faculty_item_text = $faculty_item->nodeValue;

            $department_item = $department_list->item($i);
            $department_item_text = $department_item->nodeValue;

            $faculty_names[$i]['faculty_name'] = $faculty_item_text;
            $department_names[$i]['department_name'] = $department_item_text;
        }

        return array($faculty_names, $department_names);
    }
}
