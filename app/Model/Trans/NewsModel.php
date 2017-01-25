<?php

namespace App\Model\Trans;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class NewsModel extends Model
{
    protected $table = 'news';

    protected $fillable = [
        'title',
        'details',
        'published_dt',
        'type',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    protected $dates = ['published_dt'];

    public function setPublishedDtAttribute($date)
    {
        if (!empty($date)) {
            $this->attributes['published_dt'] = Carbon::createFromFormat('d-m-Y', $date)->format('Y-m-d');
        } else {
            $this->attributes['published_dt'] = (NULL);
        }
    }

    public function getPublishedDtAttribute($date)
    {
        if (!empty($date)) {
            return Carbon::createFromFormat('Y-m-d', $date)->format('d-m-Y');
        }
    }


}
