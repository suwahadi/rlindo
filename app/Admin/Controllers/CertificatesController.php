<?php

namespace App\Admin\Controllers;

use App\Certificates;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Widgets\Table;

class CertificatesController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Certificates of Competency';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Certificates());

        $grid->column('id', 'ID')->sortable();

        $grid->CurriculumVitae()->name('Name')->display (function ($name) {
            $linknya = "curriculum-vitae/$this->curriculum_vitae_id";
            return '<a href='.$linknya.'>'.strtoupper($name).'</a>';
        });

        $grid->ListCertificates()->certificate_of_competency_name('Certificate Name')->display (function ($certificate_of_competency_name) {
            return $certificate_of_competency_name;
        });

        $grid->column('capacity', __('Capacity'));
        $grid->column('date_of_issue', __('Issued Date'))->sortable();
        $grid->column('date_of_expiry', __('Expired Date'))->sortable();

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->where(function ($query) {
                $query->whereHas('CurriculumVitae', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, 'Name');
            $filter->like('capacity', 'Capacity');

        });

        $grid->actions(function ($actions) {
            $actions->disableView();
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
        $show = new Show(Certificates::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Certificates());

        $form->select('curriculum_vitae_id', 'Name')->options(function ($id) {
            $CurriculumVitae = \App\CurriculumVitae::find($id);
            if ($CurriculumVitae) {
                return [$CurriculumVitae->id => strtoupper($CurriculumVitae->name)];
            }
        })->ajax('/app/api/cv/1')->required();

        $form->select('certificate_of_competency_name', 'Certificate Name')->options(function ($id) {
            $ListCertificates = \App\ListCertificates::find($id);
            if ($ListCertificates) {
                return [$ListCertificates->id => $ListCertificates->certificate_of_competency_name];
            }
        })->ajax('/app/api/listcertificates')->required();

        $form->text('capacity', __('Capacity'))->placeholder('Capacity');
        $form->date('date_of_issue', __('Issued Date'))->placeholder('Issued Date');
        $form->date('date_of_expiry', __('Expired Date'))->placeholder('Expired Date');

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