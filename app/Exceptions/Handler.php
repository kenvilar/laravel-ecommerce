<?php

namespace App\Exceptions;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof ValidationException) {
            $errors3 = $exception->errors();

            return $this->errorResponse($errors3, 422);
        }
        if ($exception instanceof ModelNotFoundException) {
            $getModel = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse("Does not exists any ${getModel} with the specified identificator.", 404);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse("Unauthenticated!", 401);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse($exception->getMessage(), 401);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse('The specified URL cannot be found.', 404);
        }

        if ($exception instanceof HttpException) {
            return $this->errorResponse($exception->getMessage(), $exception->getStatusCode());
        }

        if ($exception instanceof MethodNotAllowedHttpException) {
            //return $this->errorResponse('The specified method for the request is invalid.', $code);
            return $this->errorResponse('The specified method for the request is invalid.', 405);
        }

        if ($exception instanceof QueryException) {
            $errorCode = $exception->errorInfo[1];

            if ($errorCode === 1451) {
                return $this->errorResponse('Cannot delete this resource permanently.', 409);
            }
        }

        if (env('APP_DEBUG') || config('app.debug')) {
            return $this->errorResponse('Unexpected Exception', 500);
        }

        return parent::render($request, $exception);
    }
}
