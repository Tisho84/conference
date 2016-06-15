<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\DB;

class User extends ConferenceBaseModel implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id', 'user_type_id', 'rank_id', 'country_id',
        'phone', 'address', 'institution', 'active',
        'name', 'email', 'email2', 'password', 'is_reviewer'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function department()
    {
        return $this->belongsTo('App\Department');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'user_category', 'user_id', 'category_id');
    }

    public function type()
    {
         return $this->belongsTo('App\UserType', 'user_type_id', 'id', 'user_type');
    }

    public function papers()
    {
        return $this->hasMany('App\Paper');
    }

    public function reviewPapers()
    {
        return $this->hasMany('App\Paper', 'reviewer_id', 'id', 'paper');
    }

    public function requests()
    {
        return $this->belongsToMany('App\Paper', 'paper_reviewer_request', 'user_id', 'paper_id');
    }


    public static function getReviewers($departmentId = null, $categoryId = null)
    {
        $no = trans('static.no');
        $yes = trans('static.yes');
        $reviewers = self::getUsers(2, $departmentId);
        foreach ($reviewers as &$reviewer) {
            $hasCategory = $no;
            $text = $reviewer->name . ' | ' . $reviewer->papers . ' | ';
            if (in_array($categoryId, explode(' ', $reviewer->categories))) {
                $hasCategory = $yes;
            }
            $text .= $hasCategory;
            $reviewer->name = $text;
        }
        return $reviewers;
    }

    public static function getAuthors($departmentId = null)
    {
        return self::getUsers(1, $departmentId);
    }

    private static function getUsers($access, $departmentId)
    {
        switch ($access) {
            case 1:
                $paperId = 'paper.user_id';
                break;

            case 2:
                $paperId = 'paper.reviewer_id';
                break;

            default:
                return [];
        }

        $where = $departmentId ? '=' : '<>';
        return DB::table('users')
            ->join('user_type', 'users.user_type_id', '=', 'user_type.id')
            ->join('user_type_access', 'user_type.id', '=', 'user_type_access.user_type_id')
            ->leftJoin('paper', function($join) use ($paperId) {
                $join->on('users.id', '=', $paperId)->whereNull('paper.archive_id');
            })
            ->leftJoin('user_category', 'user_category.user_id', '=', 'users.id')
            ->select('users.*', DB::raw('COUNT(DISTINCT paper.id) as papers'), DB::raw("GROUP_CONCAT(DISTINCT user_category.category_id SEPARATOR ' ') as categories"))
            ->where('users.active', 1)
            ->where('user_type.active', 1)
            ->where('user_type_access.access_id', $access)
            ->where('users.department_id', $where, (int)$departmentId)
            ->groupBy('users.id')
            ->get();
    }
}
