<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Skills extends RowAction
{
    public $name = 'Skills';

    public function handle(Model $model)
    {
    	$modelname = $model->name;
        return $this->response()->redirect('skills?&40318dedfb0fc354524f8c222d16a32f='.$modelname);
    }

}