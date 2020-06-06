<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Experiences extends RowAction
{
    public $name = 'Experiences';

    public function handle(Model $model)
    {
    	$modelname = $model->name;
        return $this->response()->redirect('experiences?&ab1d45c92475b7e44eb30f1dcb2c447d='.$modelname);
    }

}