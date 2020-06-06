<?php

namespace App\Admin\Actions;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;
use App\ListSkills;

class Aktifkan extends RowAction
{
    public $name = 'Update Status';

	public function handle(Model $model)
    {
    	$modelstatus = $model->status;
    	
    	$Skills = ListSkills::find($model->id);
    	if ($modelstatus == '0') {
    		$Skills->status = '1';
    		$Skills->save();
    	}elseif ($modelstatus == '1') {
    		$Skills->status = '0';
    		$Skills->save();
    	}
        return $this->response()->success('Status updated...')->refresh();
    }

}