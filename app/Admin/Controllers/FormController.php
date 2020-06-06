<?php
namespace App\Admin\Controllers;

use App\Admin\Forms\Steps;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\MultipleSteps;

class FormController extends AdminController
{

    public function register (Content $content)
    {
        $steps = [
            'info'     => Steps\Info::class,
            'profile'  => Steps\Profile::class,
            'password' => Steps\Password::class,
        ];

        return $content
            ->title('Register')
            ->body(MultipleSteps::make($steps));
    }

}