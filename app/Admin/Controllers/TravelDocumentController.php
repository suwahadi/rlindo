<?php

namespace App\Admin\Controllers;

use App\TravelDocument;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
Use Encore\Admin\Widgets\Table;

class TravelDocumentController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'Travel Document';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new TravelDocument());
        $grid->id('ID')->sortable();

        $grid->CurriculumVitae()->name('Name')->display (function ($name) {
            $linknya = "curriculum-vitae/$this->curriculum_vitae_id";
            return '<a href='.$linknya.'>'.strtoupper($name).'</a>';
        });

        $grid->document_type('Type')->sortable();
        $grid->document_no('Document No');
        $grid->document_date_of_issue('Issued Date')->sortable();
        $grid->document_date_of_expiry('Expired Date')->sortable();
        $grid->document_place_of_issue('Place of Issue')->upper();
        $grid->document_file('Document')->lightbox(['width' => 50, 'height' => 50]);

        $grid->filter(function($filter){
            $filter->disableIdFilter();
            $filter->where(function ($query) {
                $query->whereHas('CurriculumVitae', function ($query) {
                    $query->where('name', 'like', "%{$this->input}%");
                });
            }, 'Name');
            $filter->equal('document_type', 'Document Type')->select(['Passport' => 'Passport', 'Seaman Book' => 'Seaman Book']);
            $filter->like('document_no', 'Document No');
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
        $show = new Show(TravelDocument::findOrFail($id));
        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new TravelDocument());

        $form->select('curriculum_vitae_id', 'Name')->options(function ($id) {
            $CurriculumVitae = \App\CurriculumVitae::find($id);
            if ($CurriculumVitae) {
                return [$CurriculumVitae->id => strtoupper($CurriculumVitae->name)];
            }
        })->ajax('/app/api/cv/1')->required();

        $form->select('document_type', 'Document Type')->options(['Passport' => 'Passport', 'Seaman Book' => 'Seaman Book'])->required();
        $form->text('document_no', __('Document No'))->required();
        $form->date('document_date_of_issue', __('Issued Date'))->required();
        $form->date('document_date_of_expiry', __('Expired Date'))->required();
        $form->text('document_place_of_issue', __('Place of Issue'))->required();
        $form->image('document_file', 'File');

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