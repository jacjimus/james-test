<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyRequest;
use App\Models\Companies;

class CompanyController extends BaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    protected string $sortBy = 'id';

    protected string $sortDirection = 'DESC';

    /**
     * Get the class to be used for the CRUD operations.
     *
     * @return string
     */
    protected static function resource(): string
    {
        return Companies::class;
    }

    /**
     * Get form request to be used when validating the input.
     *
     * @return string
     */
    protected static function resourceFormRequest(): string
    {
        return CompanyRequest::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $companies = Companies::pluck('name', 'id');

        return $this->sendResponse($companies, 'Companies list');
    }
}
