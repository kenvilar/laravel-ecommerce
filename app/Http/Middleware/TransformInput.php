<?php

namespace App\Http\Middleware;

use Closure;

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

        return $next($request);
    }
}
