<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e){
        if($request->is('api*')){
            if($e instanceof ValidationException){
            return response([
                'status' => 'error',
                'errors' => $e->errors()   
            ], 422);
            }
        if($e instanceof AuthorizationException){
            return response([
                'status' => 'error',
                'errors' => $e->getMessage()   
            ], 403);
            }
            if($e instanceof ModelNotFoundException || $e instanceof NotFoundHttpException){
            return response([
                'status' => 'error',
                'errors' => 'Resource Not Found' 
            ], 404);
            }
            if($e instanceof AuthenticationException){
                return response([
                    'status' => 'error',
                    'errors' => $e->getMessage()   
                ], 401);
                }
                return response(['status' => 'Error', 'error' => 'Something Went Wrong'], 500);
        }
        parent::render($request, $e);
    }
}
