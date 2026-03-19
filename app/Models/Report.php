<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'month', 'year', 'total_hours', 'total_tasks'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
