<?php


namespace Code95\Page;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class Seo extends Model implements HasMedia
{
    use HasTranslations;
    use InteractsWithMedia;

    protected $fillable = ['tags'];
    public $translatable = ['tags'];
    protected $table = 'seo';

    protected $casts = ['tags' => 'array'];

    public function getFacebookAttribute()
    {
        $facebookAttribute = $this->tags['facebook'];
        $facebookAttribute['image'] = $this->facebook_image;

        return $facebookAttribute;
    }

    public function getTwitterAttribute()
    {
        $twitterAttribute = $this->tags['twitter'];
        $twitterAttribute['image'] = $this->twitter_image;

        return $twitterAttribute;
    }

    public function model(): MorphTo
    {
        return $this->morphTo();
    }

    public function getFacebookImageAttribute()
    {
        return $this->getFirstMediaUrlUsingLocal('facebook');
    }

    public function getTwitterImageAttribute()
    {
        return $this->getFirstMediaUrlUsingLocal('twitter');
    }

    public function getTitleAttribute()
    {
        return isset($this->tags['pageTitle']) ? $this->tags['pageTitle'] : '';
    }

    public function getDescriptionAttribute()
    {
        return isset($this->tags['description']) ? $this->tags['description'] : '';
    }

    public function getKeywordsAttribute()
    {
        return isset($this->tags['keywords']) ? $this->tags['keywords'] : '';
    }

    public function addMediaToCollection($file, ?string $collectionName = '')
    {
        if (request()->hasFile($file)) {
            //remove image  from storage
            //set new image again
            $collectionName = $collectionName . '-' . $this->getLocale();
            $this->clearMediaCollection($collectionName);
            $this->addMediaFromRequest($file)->toMediaCollection($collectionName);
        }
    }

    public function getFirstMediaUrlUsingLocal($collectionName)
    {
        $collectionNameWithLocal = $collectionName . '-' . $this->getLocale();
        $url = $this->getFirstMediaUrl($collectionNameWithLocal) ?: $this->getFirstMediaUrl($collectionName . '-' . 'en');

        return env('APP_URL') . $url;
    }
}
