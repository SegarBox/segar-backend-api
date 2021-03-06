<?php

namespace App\QueryBuilders;

use App\Http\Requests\RatingGetRequest;
use App\Models\Rating;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

final class RatingBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var RatingGetRequest
     */
    protected $request;

    /**
     * RatingBuilder constructor.
     *
     * @param RatingGetRequest $request
     */
    public function __construct(RatingGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Rating::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'ratings.id',
            'ratings.user_id',
            'ratings.product_id',
            'ratings.transaction_id',
            'ratings.rating',
            'ratings.is_rating',
            'ratings.created_at',
            'ratings.updated_at',
            'user.id',
            'user.phone',
            'user.name',
            'user.email',
            'user.password',
            'user.remember_token',
            'user.created_at',
            'product.transaction_id',
            'user.deleted_at',
            'product.id',
            'product.label',
            'product.qty',
            'product.price',
            'user.updated_at',
            'product.size',
            'product.detail',
            'product.created_at',
            'product.updated_at',
            'product.deleted_at',
        ];
    }

    /**
     * Get a list of allowed columns that can be used in any filter operations.
     *
     * @return array
     */
    protected function getAllowedFilters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('user_id'),
            AllowedFilter::exact('product_id'),
            AllowedFilter::exact('transaction_id'),
            AllowedFilter::exact('rating'),
            AllowedFilter::exact('is_rating'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('ratings.id'),
            AllowedFilter::exact('ratings.user_id'),
            AllowedFilter::exact('ratings.product_id'),
            AllowedFilter::exact('ratings.transaction_id'),
            AllowedFilter::exact('ratings.rating'),
            AllowedFilter::exact('ratings.is_rating'),
            AllowedFilter::exact('ratings.created_at'),
            AllowedFilter::exact('ratings.updated_at'),
            AllowedFilter::exact('user.id'),
            'user.name',
            'user.email',
            'user.remember_token',
            AllowedFilter::exact('user.created_at'),
            AllowedFilter::exact('user.updated_at'),
            AllowedFilter::exact('user.deleted_at'),
            AllowedFilter::exact('product.id'),
            'user.phone',
            'user.password',
            AllowedFilter::exact('product.transaction_id'),
            'product.label',
            AllowedFilter::exact('product.qty'),
            AllowedFilter::exact('product.price'),
            AllowedFilter::exact('product.size'),
            'product.detail',
            AllowedFilter::exact('product.updated_at'),
            AllowedFilter::exact('product.created_at'),
            AllowedFilter::exact('product.deleted_at'),
        ];
    }

    /**
     * Get a list of allowed relationships that can be used in any include operations.
     *
     * @return string[]
     */
    protected function getAllowedIncludes(): array
    {
        return [
            'user',
            'product',
        ];
    }

    /**
     * Get a list of allowed searchable columns which can be used in any search operations.
     *
     * @return string[]
     */
    protected function getAllowedSearch(): array
    {
        return [
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            'product.label',
            'product.detail',
        ];
    }

    /**
     * Get a list of allowed columns that can be used in any sort operations.
     *
     * @return string[]
     */
    protected function getAllowedSorts(): array
    {
        return [
            'id',
            'user_id',
            'product_id',
            'transaction_id',
            'rating',
            'is_rating',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Get the default sort column that will be used in any sort operation.
     *
     * @return string
     */
    protected function getDefaultSort(): string
    {
        return 'id';
    }

    public function query(): QueryBuilder
    {
        return parent::query() //@phpstan-ignore-line
            ->leftJoin('products','ratings.product_id','=','products.id')
            ->leftJoin('transactions','ratings.transaction_id','=','transactions.id')
            ->select([
                'ratings.*',
                'transactions.invoice_number',
                'products.image',
                'products.label',
                'products.size',
            ])
            ->groupBy(['ratings.id']);
    }
    
    public function paginate(): LengthAwarePaginator|Paginator
    {
        $query = $this->query();
        $query = $query->where('ratings.user_id',auth()->user()?->id);
        return $query->jsonPaginate();
    }
}
