<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class OrdHead extends Model
{
    use HasFactory, LogsActivity;
    
    protected $table = 'ordhead';
    
    // Constructor to dynamically set primary key
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        
        // Check if 'id' column exists, otherwise use 'ordid'
        $this->primaryKey = Schema::hasColumn($this->getTable(), 'id') ? 'id' : 'ordid';
    }
    
    public $guarded = [];
    protected $fillable = [];

    public function ordsku()
    {
        return $this->hasMany(OrdSku::class, 'ordhead_id', $this->primaryKey);
    }

    public function suppliers()
    {
        return $this->belongsTo(Supplier::class, 'supplier', 'supp_code');
    }

    public function stores()
    {
        return $this->belongsTo(Store::class, 'ship_to', 'store');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }
}