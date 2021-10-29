<?php

namespace App\Http\Controllers;

use DOMDocument;
use DOMXPath;
use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TestController extends Controller
{

    // get database data here

    public function index()
    {

        list($faculties, $departments)  = $this->get_faculties_and_departments();




        foreach ($faculties as $faculty) {
            $iteration = 0;
            $department_array = explode("\n", $departments[$iteration]["department_name"]);
            $department_array = preg_replace('/\h+/', ' ', $department_array);
            array_pop($department_array);
            array_shift($department_array);



            foreach ($department_array as $dept) {
                echo $iteration . $dept;
            }
            $iteration = 1;
        }

        die();

        return  Inertia::render('Test', [
            'body' => $departments,
        ]);
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
            $department_names[$i]['department_name'] = $department_item_text;
        }

        return array($faculty_names, $department_names);
    }
}
