<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $table = 'paper';
    protected $dates = ['created_at', 'updated_at'];
    protected $fillable = [
        'department_id', 'category_id', 'user_id',
        'reviewer_id', 'status_id', 'source', 'title',
        'description', 'authors', 'archived', 'payment_confirmed',
        'payment_source', 'payment_description', 'updated_at'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function reviewer()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i');
    }

    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d.m.Y H:i');
    }

    public function canEdit()
    {
        if ($this->status_id == 1) {
            return true;
        }

        return false;
    }

    public function canInvoice()
    {
        return $this->canEdit();
    }

    public function isAuthor($id = null)
    {
        $id = $id ? : auth()->user()->id;
        return $this->user_id == $id ? true : false;
    }

    public function isReviewer($id = null)
    {
        $id = $id ? : auth()->user()->id;
        return $this->reviewer_id == $id ? true : false;
    }
}
