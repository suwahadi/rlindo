<?php

namespace App\Admin\Controllers;

use App\Skills;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Widgets\Table;

class SkillsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Skills Training Certificates';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Skills());

        $grid->column('id', 'ID')->sortable();

        $grid->CurriculumVitae()->name('Name')->display (function ($name) {
            $linknya = "curriculum-vitae/$this->curriculum_vitae_id";
            return '<a href='.$linknya.'>'.strtoupper($name).'</a>';
        });

        $grid->ListSkills()->skill_training_certificate_name('Skills Name')->display (function ($skill_training_certificate_name) {
            return $skill_training_certificate_name;
        });

        $grid->column('date_of_issue', __('Issued Date'))->sortable();
        $grid->column('date_of_expiry', __('Expired Date'))->sortable();

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
            $filter->like('skill_training_certificate_name', 'Certificate Name');

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
        $show = new Show(Skills::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Skills());

        $form->select('curriculum_vitae_id', 'Name')->options(function ($id) {
            $CurriculumVitae = \App\CurriculumVitae::find($id);
            if ($CurriculumVitae) {
                return [$CurriculumVitae->id => strtoupper($CurriculumVitae->name)];
            }
        })->ajax('/app/api/cv/1')->required();

        $form->select('skill_training_certificate_name', 'Certificate Name')->options(function ($id) {
            $ListSkills = \App\ListSkills::find($id);
            if ($ListSkills) {
                return [$ListSkills->id => $ListSkills->skill_training_certificate_name];
            }
                })->ajax('/app/api/listskills')->required();

        $form->date('date_of_issue', __('Issued Date'));
        $form->date('date_of_expiry', __('Expired Date'));

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