<?php

namespace App\Admin\Actions\Document;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class ShareDocument extends RowAction
{
    public $name = 'Documents';

    public function handle(Model $model)
    {
        // $model ...
        return $this->response()->success()->refresh();
    }

    // public function form(Model $model = null)
    // {
        //$this->text('title')->rules('min:10')->default($model->title);

        //$this->textarea('desc');
    //     return redirect('/');
    // }

    public function index()
    {
        //$this->text('title')->rules('min:10')->default($model->title);
        //$this->textarea('desc');
        return redirect('/');
    }

}