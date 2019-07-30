<?php

namespace App;

use App\Model\Category\Category;
use App\Model\Comment\Comment;
use App\Model\Comment\Reply;
use App\Model\Follow\Follow;
use App\Model\Page\Article;
use App\Model\Privacy\Privacy;
use App\Model\User\AdditionalInformation;
use App\Model\User\PhotosUser;
use App\Model\User\SpecificData;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function specific()
    {
        return $this->hasOne(SpecificData::class);
    }

    public function avatar()
    {
        return $this->hasOne(PhotosUser::class)
            ->where('type', 'AVATAR');
    }

    public function photos()
    {
        return $this->hasMany(PhotosUser::class)
            ->where('type', 'PHOTO');
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function answersComment()
    {
        return $this->hasMany(Reply::class);
    }

    public function follows()
    {
        return $this->hasMany(Follow::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function privacy()
    {
        return $this->hasOne(Privacy::class);
    }

    public function inf()
    {
        return $this->hasOne(AdditionalInformation::class);
    }

    public function getFullName(){
        $name = SpecificData::where('user_id', Auth::id())->value('name');
        $last_name = SpecificData::where('user_id', Auth::id())->value('last_name');
        $fullName = $name . ' ' . $last_name;
        return $fullName;
    }
}
