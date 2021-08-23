<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\MediaLibrary\HasMedia;
// use Spatie\MediaLibrary\InteractsWithMedia;
// use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Article extends Model
{
    use SoftDeletes;
    use HasFactory;

    public $table = 'articles';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'content',
        'counter',
        'bureau',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const BUREAU_SELECT = [
        'HRD'  => 'HRD',
        'ADVO' => 'Advocacy',
        'SE' => 'Social Environment',
        'RND' => 'Research and Development',
        'RNC' => 'Relation and Creative',
        'ENTRE' => 'Entrepreneurship'
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    // public function registerMediaConversions(Media $media = null): void
    // {
    //     $this->addMediaConversion('thumb')->fit('crop', 50, 50);
    //     $this->addMediaConversion('preview')->fit('crop', 120, 120);
    // }

    // public function getImageAttribute()
    // {
    //     $files = $this->getMedia('image');
    //     $files->each(function ($item) {
    //         $item->url = $item->getUrl();
    //         $item->thumbnail = $item->getUrl('thumb');
    //         $item->preview = $item->getUrl('preview');
    //     });

    //     return $files;
    // }

    // Helper functions to detect tag
    public function hasTag()
    {
        return $this->hasMany(HasTag::class, 'article_id');
    }

    // Helper function to deterine if tag is exist or not
    public function isTagExist()
    {
        $query = $this->query()
            ->join('has_tags', 'has_tags.article_id', '=', 'articles.id')
            ->join('tags', 'has_tags.tag_id', '=', 'tags.id')
            ->where('articles.id', '=', $this->id)
            ->get();
        return $query;
    }

    // Helper funtion to Media Handler
    public function getMediaPath()
    {
        // should return an array
        return $this->belongsTo(Media_handlers::class, 'media_id');
    }
}
