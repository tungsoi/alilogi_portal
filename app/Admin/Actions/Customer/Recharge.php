<?php

namespace App\Admin\Actions\Customer;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class Recharge extends BatchAction
{
    public $name = 'recharge';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            // ...
        }

        return $this->response()->success('Success message...')->refresh();
    }

    public function form()
    {
        $type = [
            1 => 'Advertising',
            2 => 'Illegal',
            3 => 'Fishing',
        ];

        $this->checkbox('type', 'type')->options($type);
        $this->textarea('reason', 'reason')->rules('required');
    }

}
