<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Certificates extends RowAction
{
    public $name = 'Certificates';

    public function handle(Model $model)
    {
    	$modelname = $model->name;
        return $this->response()->redirect('certificates?&49cc5b95bf423b4069540db25f01cabd='.$modelname);
    }

}