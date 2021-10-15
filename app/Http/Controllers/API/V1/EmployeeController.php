<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\EmployeeRequest;
use App\Models\Employees;
use Illuminate\Http\Request;

class EmployeeController extends BaseController
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

    protected array $withRelations   = ['company'];

    /**
     * Get the class to be used for the CRUD operations.
     *
     * @return string
     */
    protected static function resource(): string
    {
        return Employees::class;
    }

    /**
     * Get form request to be used when validating the input.
     *
     * @return string
     */
    protected static function resourceFormRequest(): string
    {
        return EmployeeRequest::class;
    }

    public function upload(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('upload'), $fileName);

        return response()->json(['success' => true]);
    }
}
