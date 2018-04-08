<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

trait ApiResponser
{
    private function successResponse($data, $code)
    {
        return response()->json($data, $code);
    }

    protected function errorResponse($error, $code)
    {
        return response()->json(['error' => $error, 'code' => $code], $code);
    }

    protected function showAll(Collection $collection, $code = 200)
    {
        if (empty($collection) || $collection->isEmpty()) {
            return $this->successResponse(['data' => $collection], $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);

        $collection = $this->sortData($collection, $transformer);

        $collection = $this->paginate($collection);

        $collection = $this->transformData($collection, $transformer);

        $collection = $this->cacheResponse($collection);

        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $model, $code = 200)
    {
        $transformer = $model->transformer;

        $model = $this->transformData($model, $transformer);

        return $this->successResponse($model, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        return $this->successResponse(['data' => $message], $code);
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function sortData(Collection $collection, $transformer)
    {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttributes(request()->sort_by);

            $collection = $collection->sortBy->{$attribute};
        }
        return $collection;
    }

    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $key => $value) {
            $attribute = $transformer::originalAttributes($key);

            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $perPage = 15;

        $validatePaginate = Validator::make(request()->all(), [
            'per_page' => 'integer|min:2|max:50',
        ]);

        if (!$validatePaginate->fails() && request()->has('per_page')) {
            $perPage = (int)request()->per_page;
        }

        $page = LengthAwarePaginator::resolveCurrentPage();

        $items = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($items, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function cacheResponse($data)
    {
        $requestUrl = request()->url();

        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$requestUrl}?{$queryString}";

        return Cache::remember($fullUrl, 30 / 60, function () use ($data) {
            return $data;
        });
    }
}
