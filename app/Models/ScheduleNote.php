<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'note_date',
    ];

    protected $casts = [
        'note_date' => 'date',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
