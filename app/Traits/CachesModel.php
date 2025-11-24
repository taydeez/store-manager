<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CachesModel
{
    /**
     * Cached single record by id.
     */
    public static function cachedFind($id, $ttl = 3600)
    {
        return Cache::tags([static::class])->remember(
            static::cacheKey($id),
            $ttl,
            fn() => static::find($id)
        );
    }

    /**
     * Cached all records.
     */
    public static function cachedAll($ttl = 3600)
    {
        return Cache::tags([static::class])->remember(
            static::listCacheKey(),
            $ttl,
            fn() => static::all()
        );
    }

    /**
     * Cache key for full list.
     */
    public static function listCacheKey()
    {
        return static::class . '_list';
    }

    /**
     * Cached paginate query.
     *
     * Example: User::cachedPaginate(15)
     */
    public static function cachedPaginate($perPage = 15, $ttl = 3600)
    {
        $key = static::class . '_paginate_' . $perPage . '_page_' . request('page', 1);

        return Cache::tags([static::class])->remember(
            $key,
            $ttl,
            fn() => static::paginate($perPage)
        );
    }

    /**
     * Cached where query (simple key-value array).
     *
     * Example: User::cachedWhere(['active' => 1])
     */
    public static function cachedWhere(array $conditions, $ttl = 3600)
    {
        $hash = md5(json_encode($conditions));
        $key = static::class . '_where_' . $hash;

        return Cache::tags([static::class])->remember(
            $key,
            $ttl,
            fn() => static::where($conditions)->get()
        );
    }

    /**
     * Cached custom query callback.
     *
     * Example:
     * User::cachedQuery(fn($q) => $q->where('role', 'admin')->orderBy('name'))
     */
    public static function cachedQuery(callable $callback, $ttl = 3600)
    {
        // Generate a unique hash for the callback signature
        $hash = md5(serialize($callback));
        $key = static::class . '_query_' . $hash;

        return Cache::tags([static::class])->remember(
            $key,
            $ttl,
            function () use ($callback) {
                $query = static::query();
                return $callback($query)->get();
            }
        );
    }

    /**
     * Boot trait: Automatically clear caches on update/delete.
     */
    protected static function bootCachesModel()
    {
        static::saved(function ($model) {
            Cache::forget(static::cacheKey($model->id));
            Cache::tags([static::class])->flush();
        });

        static::deleted(function ($model) {
            Cache::forget(static::cacheKey($model->id));
            Cache::tags([static::class])->flush();
        });
    }

    /**
     * Base cache key for single model.
     */
    public static function cacheKey($id)
    {
        return static::class . '_model_' . $id;
    }
}
