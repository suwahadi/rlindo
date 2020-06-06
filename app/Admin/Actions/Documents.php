<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Documents extends RowAction
{
    public $name = 'Documents';

    public function handle(Model $model)
    {
        $modelname = $model->name;
        return $this->response()->redirect('travel-document?&8c8be5678f3d348233c85bf93c4c0aa9='.$modelname);
    }

}