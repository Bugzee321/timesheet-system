<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

trait Filterable
{
    /**
     * Apply filters to the query.
     *
     * @param Builder $query
     * @param array $filters
     * @return void
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        foreach ($filters as $field => $filter) {
            $this->applyFilter(
                $query,
                $field,
                $this->parseOperatorAndValue($filter)
            );
        }
    }

    /**
     * Apply a filter to the query based on the field and condition.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $field
     * @param  array  $condition
     * @return void
     */
    protected function applyFilter(Builder $query, string $field, array $condition): void
    {
        [$operator, $value] = $condition;

        if ($this->isRegularAttribute($field)) {
            $this->applyRegularFilter($query, $field, $operator, $value);
        } else {
            $this->applyEavFilter($query, $field, $operator, $value);
        }
    }

    /**
     * Parse the operator and value from the filter.
     *
     * @param  mixed  $filter
     * @return array
     */
    protected function parseOperatorAndValue($filter): array
    {
        if (is_array($filter)) {
            return [
                $filter['operator'] ?? 'eq',
                $filter['value'] ?? null
            ];
        }

        return ['eq', $filter];
    }

    /**
     * Determine if the field is a regular attribute.
     *
     * @param  string  $field
     * @return bool
     */
    protected function isRegularAttribute(string $field): bool
    {
        return Schema::hasColumn($this->getTable(), $field) ||
            in_array($field, $this->getFillable());
    }

    /**
     * Apply a regular filter to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $field
     * @param  string  $operator
     * @param  mixed  $value
     * @return void
     */
    protected function applyRegularFilter(Builder $query, string $field, string $operator, $value): void
    {
        $operatorMap = [
            'eq' => '=',
            'gt' => '>',
            'lt' => '<',
            'like' => 'LIKE'
        ];

        $sqlOperator = $operatorMap[$operator] ?? '=';
        $value = $operator === 'like' ? "%$value%" : $value;

        $query->where($field, $sqlOperator, $value);
    }

    /**
     * Apply an EAV filter to the query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $attributeName
     * @param  string  $operator
     * @param  mixed  $value
     * @return void
     */
    protected function applyEavFilter(Builder $query, string $attributeName, string $operator, $value): void
    {
        $query->whereHas('attributeValues', function (Builder $q) use ($attributeName, $operator, $value) {
            $q->whereHas('attribute', function (Builder $q) use ($attributeName) {
                $q->where('name', $attributeName);
            })->where(function (Builder $q) use ($operator, $value) {
                $this->applyEavValueCondition($q, $operator, $value);
            });
        });
    }

    /**
     * Apply a condition to the EAV value.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $operator
     * @param  mixed  $value
     * @return void
     */
    protected function applyEavValueCondition(Builder $query, string $operator, $value): void
    {
        $query->where(function (Builder $q) use ($operator, $value) {
            $q->where(function (Builder $q) use ($operator, $value) {
                // Handle numeric comparisons
                $q->whereHas('attribute', fn($q) => $q->where('type', 'number'))
                    ->when(
                        in_array($operator, ['eq', 'gt', 'lt']) && is_numeric($value),
                        fn($q) =>
                        $q->whereRaw("CAST(value AS DECIMAL) {$this->getSqlOperator($operator)} ?", [$value])
                    );
            })->orWhere(function (Builder $q) use ($operator, $value) {
                // Handle date comparisons
                $q->whereHas('attribute', fn($q) => $q->where('type', 'date'))
                    ->when(
                        in_array($operator, ['eq', 'gt', 'lt']) && strtotime($value) !== false,
                        fn($q) =>
                        $q->whereDate('value', $this->getSqlOperator($operator), $value)
                    );
            })->orWhere(function (Builder $q) use ($operator, $value) {
                // Handle text/select comparisons
                $valueCondition = $operator === 'like' ? "%$value%" : $value;
                $q->whereHas('attribute', fn($q) => $q->whereIn('type', ['text', 'select']))
                    ->where('value', $this->getSqlOperator($operator), $valueCondition);
            });
        });
    }

    /**
     * Get the SQL operator for the given operator.
     *
     * @param string $operator
     * @return string
     */
    protected function getSqlOperator(string $operator): string
    {
        return match ($operator) {
            'eq' => '=',
            'gt' => '>',
            'lt' => '<',
            'like' => 'LIKE',
            default => '='
        };
    }
}
