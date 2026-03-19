<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeeAvailability extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['employee_id', 'day_of_week', 'start_time', 'end_time'];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
