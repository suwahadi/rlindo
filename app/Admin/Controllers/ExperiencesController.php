<?php

namespace App\Admin\Controllers;

use App\Experiences;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Widgets\Table;

class ExperiencesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Experiences';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Experiences());

        $grid->column('id', __('ID'))->sortable();

        $grid->CurriculumVitae()->name('Name')->display (function ($name) {
            $linknya = "curriculum-vitae/$this->curriculum_vitae_id";
            return '<a href='.$linknya.'>'.strtoupper($name).'</a>';
        });

        $grid->column('name_of_vessel', __('Vessel Name'))->sortable();
        $grid->column('rank', __('Rank'))->sortable();
        $grid->column('vessel_type', __('Vessel Type'))->sortable();
        $grid->column('grt_hp', __('GRT / HP'));
        $grid->column('company', __('Company Name'))->upper()->sortable();
        $grid->column('principle_name', __('Principle Name'))->sortable();
        $grid->column('contract', __('Contract'));
        $grid->column('Salary')->display(function () {
            return 'USD '.$this->salary;
        })->sortable();

        $grid->column('Onboard Period')->display(function () {
                return $this->onboard_period_from.'<br>'.$this->onboard_period_to;
            });
        $grid->column('standby_status', 'Status')->label([
            'Stand By' => 'success',
            'Stand Out' => 'danger',
            'Candidate' => 'warning',
        ])->sortable();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function($filter){
            $filter->disableIdFilter();

            $filter->where(function ($query) {
                $query->whereHas('CurriculumVitae', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, 'Name');

            $filter->like('name_of_vessel', 'Vessel Name');
            $filter->like('rank', 'Rank');
            $filter->group('salary', function ($group) {
                $group->gt('Greater than');
                $group->lt('Less than');
            });

            $filter->between('onboard_period_to', 'Onboard Between')->date();

            $filter->equal('standby_status', 'Status')->select([
                'Stand By' => 'Stand By',
                'Stand Out' => 'Stand Out',
                'Candidate' => 'Candidate',
            ]);

        });

        $grid->disableRowSelector();
        
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Experiences::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Experiences());

        $form->select('curriculum_vitae_id', 'Name')->options(function ($id) {
            $CurriculumVitae = \App\CurriculumVitae::find($id);
            if ($CurriculumVitae) {
                return [$CurriculumVitae->id => strtoupper($CurriculumVitae->name)];
            }
        })->ajax('/app/api/cv/1')->required();

        $form->text('name_of_vessel', __('Name of Vessel'))->required();
        $form->text('rank', __('Rank'))->required();
        $form->select('vessel_type', 'Vessel Type')->options(['UTILITY' => 'UTILITY', 'DP' => 'DP', 'CREWBOAT' => 'CREWBOAT', 'AHT' => 'AHT', 'AHTS' => 'AHTS', 'TANKER' => 'TANKER', 'TUG BOAT' => 'TUG BOAT', 'CRANE BARGE' => 'CRANE BARGE', 'LANDING CRAFT' => 'LANDING CRAFT', 'SUPPLY' => 'SUPPLY', 'AHTS DP 1' => 'AHTS DP 1', 'AHTS DP 2' => 'AHTS DP 2', 'DSV' => 'DSV', 'BULK CARRIER' => 'BULK CARRIER', 'ASD TUG' => 'ASD TUG', 'ASV' => 'ASV', 'PSV DP 2' => 'PSV DP 2', 'MULTICAT' => 'MULTICAT', 'OTHER' => 'OTHER',])->required();
        $form->text('grt_hp', __('GRT / HP'));
        $form->text('company', __('Company Name'));
        $form->text('principle_name', __('Principle Name'));
        $form->select('contract', 'Contract')->options(['3 Months' => '3 Months', '5 Months' => '5 Months', '12 Months' => '12 Months', 'Others' => 'Others']);
        $form->currency('salary', 'Salary')->required()->setWidth(2, 2)->symbol('USD');
        $form->dateRange('onboard_period_from', 'onboard_period_to', 'Onboard Period');
        $form->select('standby_status', 'Status')->options(['Stand By' => 'Stand By', 'Stand Out' => 'Stand Out', 'Candidate' => 'Candidate'])->required()->setWidth(2, 2);

        $form->tools(function (Form\Tools $tools) {
            $tools->disableView();
            $tools->disableDelete();
        });

        $form->footer(function ($footer) {
            $footer->disableReset();
            $footer->disableViewCheck();
            $footer->disableEditingCheck();
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}