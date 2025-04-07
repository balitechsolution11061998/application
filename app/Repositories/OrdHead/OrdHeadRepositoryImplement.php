<?php

namespace App\Repositories\OrdHead;

use LaravelEasyRepository\Implementations\Eloquent;
use App\Models\OrdHead;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class OrdHeadRepositoryImplement extends Eloquent implements OrdHeadRepository
{
    protected OrdHead $model;

    public function __construct(OrdHead $model)
    {
        $this->model = $model;
    }

    public function where($column, $value): Builder
    {
        // Automatically use id or ordid as primary key
        if ($column === null || $column === 'primary') {
            $column = Schema::hasColumn($this->model->getTable(), 'id') ? 'id' : 'ordid';
        }
        
        return $this->model->where($column, $value);
    }

    public function updateOrCreate($data)
    {
        try {
            $identifier = $this->getRecordIdentifier($data);
            $whereClause = [
                $identifier['column'] => $identifier['value'],
                'order_no' => $data['order_no']
            ];

            $operation = $this->model->where($whereClause)->exists() ? 'updated' : 'created';
            
            $record = $this->model->updateOrCreate($whereClause, $this->prepareData($data));

            activity()
                ->causedBy(auth()->user())
                ->performedOn($record)
                ->withProperties([
                    'order_no' => $data['order_no'],
                    'ordid' => $record->ordid ?? $record->id,
                    'operation' => $operation
                ])
                ->log("Order {$operation} successfully");

            return $record;

        } catch (Exception $e) {
            $errorMessage = "Failed to process order {$data['order_no']}: " . $e->getMessage();
            
            Log::error($errorMessage, [
                'exception' => $e,
                'data' => $data,
                'trace' => $e->getTraceAsString()
            ]);

            activity()
                ->causedBy(auth()->user())
                ->withProperties([
                    'error' => $e->getMessage(),
                    'order_no' => $data['order_no'] ?? 'unknown',
                    'data' => $data,
                    'stack_trace' => $e->getTraceAsString()
                ])
                ->log($errorMessage);

            throw new \Exception("Failed to process order: " . $e->getMessage(), 0, $e);
        }
    }

    protected function getRecordIdentifier(array $data): array
    {
        // Check if table has id or ordid column
        $hasId = Schema::hasColumn($this->model->getTable(), 'id');
        $hasOrdid = Schema::hasColumn($this->model->getTable(), 'ordid');

        // Priority 1: Use explicit identifier from data
        if ($hasOrdid && isset($data['ordid'])) {
            return ['column' => 'ordid', 'value' => $data['ordid']];
        }

        if ($hasId && isset($data['id'])) {
            return ['column' => 'id', 'value' => $data['id']];
        }

        // Priority 2: Find existing record by order_no
        $existing = $this->model->where('order_no', $data['order_no'])->first();
        
        if ($existing) {
            if ($hasOrdid && $existing->ordid) {
                return ['column' => 'ordid', 'value' => $existing->ordid];
            }
            if ($hasId && $existing->id) {
                return ['column' => 'id', 'value' => $existing->id];
            }
        }

        // Priority 3: Fall back to order_no as identifier for new records
        return ['column' => 'order_no', 'value' => $data['order_no']];
    }

    protected function prepareData(array $data): array
    {
        $hasOrdidColumn = Schema::hasColumn($this->model->getTable(), 'ordid');
        $hasIdColumn = Schema::hasColumn($this->model->getTable(), 'id');

        $preparedData = [
            'order_no' => $data['order_no'],
            'ship_to' => $data['ship_to'],
            'supplier' => $data['supplier'],
            'terms' => $data['terms'],
            'status_ind' => $data['status_ind'],
            'written_date' => $data['written_date'],
            'not_before_date' => $data['not_before_date'],
            'not_after_date' => $data['not_after_date'],
            'approval_date' => $data['approval_date'],
            'approval_id' => $data['approval_id'],
            'cancelled_date' => $data['cancelled_date'],
            'canceled_id' => $data['canceled_id'],
            'cancelled_amt' => $data['cancelled_amt'],
            'total_cost' => $data['total_cost'],
            'total_retail' => $data['total_retail'],
            'outstand_cost' => $data['outstand_cost'],
            'total_discount' => $data['total_discount'],
            'comment_desc' => $data['comment_desc'],
            'estimated_delivery_date' => $data['estimated_delivery_date'],
            'buyer' => $data['buyer'],
            'status' => $data['status'],
        ];

        // Handle ordid generation only if column exists
        if ($hasOrdidColumn) {
            if (!isset($data['ordid']) && !$this->model->where('order_no', $data['order_no'])->exists()) {
                $writtenDate = isset($data['written_date']) ? Carbon::parse($data['written_date']) : now();
                $preparedData['ordid'] = (int) $writtenDate->format('YmdH') . $data['order_no'];
            } elseif (isset($data['ordid'])) {
                $preparedData['ordid'] = $data['ordid'];
            }
        }

        return $preparedData;
    }
}