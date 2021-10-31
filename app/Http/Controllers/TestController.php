<?php

namespace App\Http\Controllers;

use DOMXPath;
use DOMDocument;
use Inertia\Inertia;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;

class TestController extends Controller
{

    // get database data here

    public function index()
    {


        $programs = $this->get_programs_from_departments();
        $program_urls = Department::all();


        $k = 1;
        foreach ($program_urls as $key => $url) { {
                foreach ($programs as $i => $program) {
                    $program = $program['program_name'];

                    //Match urls with program names
                    similar_text($this->replace_dashes($url->department_link), $this->remove_extra_text(strtolower($program)), $percentage);

                    if ($percentage > 74) {
                        echo "<br />";
                        echo $k  . $this->replace_dashes($url->department_link) . " => " . $program;
                        $k++;
                    }
                }
            }
        }

        die();

        // foreach ($programs as $program) {
        //     dd($url->department_link);
        // }



        dd($percentage);

        return  Inertia::render('Test', [
            'body' => '',
        ]);
    }

    public function page()
    {
        return view("selection");
    }

    protected function replace_dashes($string)
    {
        $string = str_replace(["dept-", "-"], " ", $string);
        return $string;
    }

    protected function remove_extra_text($string)
    {
        $string = str_replace(["associate degree in", "degree", "bs", "b.sc", "bba", "(hons.)", "."], " ", $string);
        return $string;
    }

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
            $faculty_names[$i]['faculty_name'] = $faculty_item_text;

            $department_item = $department_list->item($i);
            $department_item_text = $department_item->nodeValue;

            $department_array = explode("\n", $department_item_text);
            $department_array = preg_replace('/\h+/', ' ', $department_array);
            array_pop($department_array);
            array_shift($department_array);





            for ($j = 0; $j < count($department_array); $j++) {
                $department_names[$i][$j]['department_name'] = $department_array[$j];
            }
        }



        return array($faculty_names, $department_names);
    }


    public function get_programs_from_departments()
    {




        $body = View::make('selection')->render();


        $dom = new DOMDocument();
        @$dom->loadHTML($body);


        $xpath = new DOMXPath($dom);
        $options = $xpath->evaluate("/html/body//option");

        for ($i = 0; $i < $options->length; $i++) {
            $program_item = $options->item($i);
            $program_item_text = $program_item->nodeValue;
            $program_names[$i]['program_name'] = $program_item_text;
        }
        array_shift($program_names);
        return $program_names;
    }


    public function get_programs_urls()
    {
        $list = '<a class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-delay="0" data-close-others="false" href="#">Faculties';
        $response = Http::get('https://gcuf.edu.pk/');
        $body = $response->body();
        $list_first = explode($list, $body);
        $list_second = explode('<li class="nav-item dropdown ">', $list_first[1]);
        $list_second[0] = "<li>" . $list_second[0];

        $dom = new DOMDocument();
        @$dom->loadHTML($list_second[0]);


        $xpath = new DOMXPath($dom);

        $department_urls = $xpath->evaluate("/html/body/li/ul/li/ul//a");

        for ($k = 0; $k <  $department_urls->length; $k++) {
            $department_url_item = $department_urls->item($k);
            $department_url_item = $department_url_item->getAttribute('href');


            $url[$k]['department_url'] = $department_url_item;
        }
    }
}
