<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets;

class HomeController extends Controller
{

    public function index(Content $content)
    {

        $content->title('Dashboard');
        $content->description(' ');

        $content->row(function ($row) {
            $TotalCrew = \App\CurriculumVitae::get()->count();
            $TotalStandBy = \App\Experiences::where('standby_status', 'Stand By')->count();
            $TotalCandidates = \App\Experiences::where('standby_status', 'Candidate')->count();
            $TotalStandOut = \App\Experiences::where('standby_status', 'Stand Out')->count();

            $row->column(3, new Widgets\InfoBox('Total Crew', 'users', 'aqua', 'admin/curriculum-vitae', $TotalCrew));
            $row->column(3, new Widgets\InfoBox('Candidates', 'briefcase', 'yellow', 'admin/experiences?standby_status=Candidate', $TotalCandidates));
            $row->column(3, new Widgets\InfoBox('Stand By', 'sign-in', 'green', 'admin/experiences?standby_status=Stand+By', $TotalStandBy));
            $row->column(3, new Widgets\InfoBox('Stand Out', 'sign-out', 'red', 'admin/experiences?standby_status=Stand+Out', $TotalStandOut));
        });


        $headers1 = ['ID', 'Name', 'Rank', 'PPE Size', 'Nationality', 'Email', 'Home Phone', 'Mobile Phone'];
        $rows1 = \App\CurriculumVitae::orderBy('id', 'DESC')->select('id', 'name', 'rank', 'ppe_size', 'nationality', 'email', 'home_tel', 'mobile_tel')->get()->take(5);
        $rows1 = $rows1->ToArray();
        $table1 = new Widgets\Table($headers1, $rows1);
        $button = '<a href="admin/curriculum-vitae"><button type="button" class="btn btn-default btn btn-block">Show More...</button></a>';
        $content->row((new Widgets\Box('5 Latest Crews', $table1.$button))->style('info')->solid());


        $headers2 = ['ID', 'Vessel Name', 'Rank', 'Vessel Type', 'Company Name', 'Principle Name', 'Salary (USD)', 'Contract', 'Status'];
        $rows2 = \App\Experiences::orderBy('id', 'DESC')->select('id', 'name_of_vessel', 'rank', 'vessel_type', 'company', 'principle_name', 'salary', 'contract', 'standby_status')->get()->take(5);
        $rows2 = $rows2->ToArray();
        $button2 = '<a href="admin/experiences"><button type="button" class="btn btn-default btn btn-block">Show More...</button></a>';
        $table2 = new Widgets\Table($headers2, $rows2);
        $content->body((new Widgets\Box('5 Latest Experiences', $table2.$button2))->style('success')->solid());

        return $content;

    }

}