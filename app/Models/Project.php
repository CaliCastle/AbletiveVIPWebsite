<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Project extends Model
{
    //
//    protected $fillable = [
//        'title', 'maker', 'baidu_link', 'qiniu_link', 'thumbnail',
//        'video_link', 'video_link', 'tutorial_link', 'video_download',
//        'details_link', 'difficulty', 'has_tutorial', 'is_universal', 'description',
//        'password', '360_link'
//    ];
    
    protected $guarded = [
        'id'
    ];

    /**
     * Get the users associated with the given project
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    /**
     * Check to see if the project has been starred by the given user
     *
     * @return bool
     */
    public function hasStarred()
    {
        $ids = $this->users()->lists('id')->toArray();

        return in_array(Auth::user()->id, $ids);
    }

    /**
     * Search the related projects by the given keyword
     *
     * @param $keyword
     * @return mixed
     */
    public static function search($keyword)
    {
        $projects = Project::where('title', 'like', "%{$keyword}%")
                            ->orderBy('title', 'asc')
                            ->paginate(50);

        return $projects;
    }

    /**
     * Local scope for alphabetic sort
     *
     * @param $query
     * @return mixed
     */
    public static function scopeAlphabetically($query)
    {
        return $query->orderBy('title', 'asc');
    }

    /**
     * Replace http with https ssl connection
     *
     * @return string
     */
    public function getThumbnailAttribute()
    {
        if ($this->title) {
            $thumbnail = $this->attributes["thumbnail"];

            if (!str_contains($thumbnail, 'https://')) {
                $thumbnail = str_replace('http', 'https', $thumbnail);
            }

            return $thumbnail;
        }
        return "";
    }
}
