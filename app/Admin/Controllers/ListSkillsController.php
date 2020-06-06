<?php

namespace App\Admin\Controllers;

use App\ListSkills;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Actions\Action;
use App\Admin\Actions\Aktifkan;

class ListSkillsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'List Skills Training Certificates';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    
    protected function grid()
    {

        $grid = new Grid(new ListSkills());

        $grid->column('id', 'ID');
        $grid->column('skill_training_certificate_name', 'Certificate Name')->editable();
        
        $grid->column('status')->using([
            0 => 'Tidak Aktif',
            1 => 'Aktif',
        ], 'Unknown')->dot([
            0 => 'danger',
            1 => 'success',
        ], 'warning');

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->like('skill_training_certificate_name', 'Certificate Name');
            $filter->like('status', 'Status');
        });

        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableDelete();
            //$actions->disableEdit();
        });

        $grid->disableFilter();
        $grid->disableColumnSelector();
        $grid->disableRowSelector();
        $grid->disableExport();

        // $grid->actions(function ($actions) {
        //     $actions->disableView();
        //     $actions->disableDelete();
        //     $actions->disableEdit();
        //     $actions->add(new Aktifkan());
        // });

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
        $show = new Show(ListSkills::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new ListSkills());

        $form->setWidth(6, 2);

        $form->text('skill_training_certificate_name', 'Certificate Name');
        $form->select('status', 'Status')->options([0 => 'Tidak Aktif', 1 => 'Aktif'])->default('1');

        $form->tools(function (Form\Tools $tools) {
            $tools->disableDelete();
            $tools->disableView();
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