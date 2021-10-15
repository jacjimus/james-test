<?php

namespace App\Observers;

use App\Models\Companies;

class CompanyObserver
{
    public function saving(Companies $companies): void
    {
        if (request()->has('logo')) {
            $file_name = time().'_'.request()->file('logo')->getClientOriginalName();
            $file_path = request()->file('logo')->storeAs('', $file_name, 'public');

            $companies->logo = $file_path;
        }
    }
}
