<?php

namespace App\QueryBuilders;

use App\Http\Requests\TransactionGetRequest;
use App\Models\Transaction;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

final class TransactionBuilder extends Builder
{
    /**
     * Current HTTP Request object.
     *
     * @var TransactionGetRequest
     */
    protected $request;

    /**
     * TransactionBuilder constructor.
     *
     * @param TransactionGetRequest $request
     */
    public function __construct(TransactionGetRequest $request)
    {
        $this->request = $request;
        $this->builder = QueryBuilder::for(Transaction::class, $request);
    }

    /**
     * Get a list of allowed columns that can be selected.
     *
     * @return string[]
     */
    protected function getAllowedFields(): array
    {
        return [
            'transactions.id',
            'transactions.user_id',
            'transactions.address_id',
            'transactions.qty_transaction',
            'transactions.subtotal_products',
            'transactions.total_price',
            'transactions.status',
            'transactions.invoice_number',
            'transactions.shipping_cost',
            'transactions.created_at',
            'transactions.updated_at',
            'user.id',
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            'user.created_at',
            'user.updated_at',
            'user.deleted_at',
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
            AllowedFilter::exact('address_id'),
            AllowedFilter::exact('qty_transaction'),
            AllowedFilter::exact('subtotal_products'),
            AllowedFilter::exact('total_price'),
            AllowedFilter::exact('status'),
            AllowedFilter::exact('invoice_number'),
            AllowedFilter::exact('shipping_cost'),
            AllowedFilter::exact('created_at'),
            AllowedFilter::exact('updated_at'),
            AllowedFilter::exact('transactions.id'),
            AllowedFilter::exact('transactions.user_id'),
            AllowedFilter::exact('transactions.address_id'),
            AllowedFilter::exact('transactions.qty_transaction'),
            AllowedFilter::exact('transactions.subtotal_products'),
            AllowedFilter::exact('transactions.total_price'),
            AllowedFilter::exact('transactions.status'),
            AllowedFilter::exact('transactions.invoice_number'),
            AllowedFilter::exact('transactions.shipping_cost'),
            AllowedFilter::exact('transactions.created_at'),
            AllowedFilter::exact('transactions.updated_at'),
            AllowedFilter::exact('user.id'),
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
            AllowedFilter::exact('user.created_at'),
            AllowedFilter::exact('user.updated_at'),
            AllowedFilter::exact('user.deleted_at'),
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
            'address',
            'productTransactions',
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
            'status',
            'invoice_number',
            'user.name',
            'user.email',
            'user.phone',
            'user.password',
            'user.remember_token',
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
            'address_id',
            'qty_transaction',
            'subtotal_products',
            'total_price',
            'status',
            'invoice_number',
            'shipping_cost',
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
    
    public function paginate(): LengthAwarePaginator|Paginator
    {
        $query = $this->query();
        $query = $query->where('user_id',auth()->user()?->id);
        return $query->jsonPaginate();
    }
}
