<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Requests\Users\UserRequest;
use App\Models\User;

class UserController extends BaseController
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
        return User::class;
    }

    /**
     * Get form request to be used when validating the input.
     *
     * @return string
     */
    protected static function resourceFormRequest(): string
    {
        return UserRequest::class;
    }
}
