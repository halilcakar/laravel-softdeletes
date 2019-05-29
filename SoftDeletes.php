<?php

namespace App\Traits;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes as LaravelSoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope as LaravelSoftDeletingScope;

class SoftDeletingScope extends LaravelSoftDeletingScope {
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getQualifiedDeletedAtColumn(), '>', Carbon::now())
            ->orWhereNull($model->getQualifiedDeletedAtColumn());
    }
}

trait SoftDeletes {
    use LaravelSoftDeletes;

    public static function bootSoftDeletes()
    {
        static::addGlobalScope(new SoftDeletingScope);
    }

    /**
     * Delete's a soft-deleted model instance in future.
     *
     * @return bool|null
     */
    public function deleteInFuture($time) {

        $this->{$this->getDeletedAtColumn()} = $time;

        $this->exists = true;

        $result = $this->save();

        return $result;
    }
}
