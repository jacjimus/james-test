<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

abstract class BaseController extends Controller
{
    /**
     * Get form request to be used when validating the input.
     *
     * @return string
     */
    abstract protected static function resourceFormRequest(): string;

    /**
     * Get the class to be used for the CRUD operations.
     *
     * @return string
     */
    abstract protected static function resource(): string;

    protected array $withRelations  = [];

    public function index()
    {
        $resource = static::resource();
        $response = empty($this->withRelations) ? $resource::orderBy($this->sortBy, $this->sortDirection)->paginate(10) :
            $resource::with($this->withRelations)->orderBy($this->sortBy, $this->sortDirection)->paginate(10);

        return $this->sendResponse($response, '');
    }

    public function store(): JsonResponse
    {
        $request = app(static::resourceFormRequest());

        $resource = static::resource();

        $resource = (new $resource())->fill($request->validated());

        DB::transaction(function () use ($resource, $request) {
            $this->authorize('isAdmin');
            $resource->save();
        });

        return $this->sendResponse($resource, 'Record Created Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $resourceId
     *
     * @throws AuthorizationException
     * @throws ReflectionException
     *
     * @return RedirectResponse
     */
    public function update(int $resourceId): JsonResponse
    {
        $resource = static::resource();
        $resource = $resource::findOrFail($resourceId);

        $request = app(static::resourceFormRequest());

        $resource = $resource->fill($request->validated());

        DB::transaction(function () use ($resource, $request) {
            $this->authorize('isAdmin');
            $resource->save();
        });

        return $this->sendResponse($resource, 'Record Updated Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $resourceId
     *
     * @throws AuthorizationException
     * @throws ReflectionException
     * @throws Throwable
     *
     * @return RedirectResponse
     */
    public function destroy(Request $request, int $resourceId): JsonResponse
    {
        $resource = static::resource();
        $resource = $resource::findOrFail($resourceId);

        DB::transaction(function () use ($request, $resource) {
            $this->authorize('isAdmin');
            $resource->delete();
        });

        return $this->sendResponse($resource, 'Record has been Deleted');
    }

    /**
     * success response method.
     *
     * @param $result
     * @param $message
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message): JsonResponse
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response.
     *
     * @param $error
     * @param array $errorMessages
     * @param int   $code
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * return Unauthorized response.
     *
     * @param $error
     * @param int $code
     *
     * @return \Illuminate\Http\Response
     */
    public function unauthorizedResponse($error = 'Forbidden', $code = 403)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        return response()->json($response, $code);
    }
}
