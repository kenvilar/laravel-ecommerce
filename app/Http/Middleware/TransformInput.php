<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Validation\ValidationException;

class TransformInput
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $transformer)
    {
        $transformedInput = [];

        foreach ($request->request->all() as $key => $val) {
            $transformedInput[$transformer::originalAttributes($key)] = $val;
        }

        $request->replace($transformedInput);

        $response = $next($request);

        if (isset($response->exception) && $response->exception instanceof ValidationException) {
            $data = $response->getData();

            $transformedErrors = [];

            foreach ($data->error as $key => $val) {
                $transformField = $transformer::transformedAttributes($key);

                $transformedErrors[$transformField] = str_replace($key, $transformField, $val);
            }

            $data->error = $transformedErrors;
            $response->setData($data);
        }

        return $response;
    }
}
