<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Habit extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'description', 'start_date', 'end_date', 'completion', 'repeat_type'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function records()
    {
        return $this->hasMany(Record::class);
    }

    public function getCompletionCountAttribute()
    {
        return $this->completion == 0 ? 0 : $this->records()->count();
    }

    public function getRecordsDateAttribute()
    {        
        return $this->records->pluck('finish_date');
    }

    
}
