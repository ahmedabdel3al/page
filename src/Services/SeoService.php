<?php


namespace Code95\Page\Services;


use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\TwitterCard;
use Code95\Page\Seo;
use Illuminate\Database\Eloquent\Model;

class SeoService
{


    /**
     *
     * Create Or Update Seo tags
     * @param Model $model
     * @param Seo $seo
     * @param array $seoAttributes
     * @return Seo
     */
    public function createOrUpdate(Model $model, array $seoAttributes)
    {
        if (!$model->seo) {
            return $this->create($model, $seoAttributes);
        }
        return $this->update($model->seo, $seoAttributes);
    }

    /**
     * Create Seo Tags
     *
     * @param Model $model
     * @param [type] $seoAttributes
     * @return Seo
     */
    public function create(Model $model, $seoAttributes)
    {
        $seo = new Seo();
        $seo->setTranslation('tags', config('translatable.locale'), $seoAttributes);
        $seo->model()->associate($model);
        $this->attachMedia(tap($seo)->save());
        return $seo;
    }

    public function attachMedia(Seo $seo)
    {
        $seo->addMediaToCollection('seo.facebook.image', 'facebook');
        $seo->addMediaToCollection('seo.twitter.image', 'twitter');
    }

    /**
     * Update Seo Tags
     *
     * @param Seo $seo
     * @param [type] $seoAttributes
     * @return Seo
     */
    public function update(Seo $seo, $seoAttributes)
    {
        $seo->setTranslation('tags', config('translatable.locale'), $seoAttributes);
        tap($seo)->update();
        $this->attachMedia($seo);
        return $seo;
    }

    //seo apply
    public function setSeo(Seo $seo, $type = 'page', $url = '')
    {
        $this->setTitle($seo->title)
            ->setDescription($seo->description)
            ->setCanonical($url)
            ->setKeywords($seo->keywords)
            ->setFaceBook($seo->facebook)
            ->setType($type)
            ->setUrl($url)
            ->setTwitter($seo->twitter);
    }

    public function setTitle($title)
    {
        SEOMeta::setTitle($title);
        return $this;
    }

    public function setDescription($description)
    {
        when(!is_null($description), function () use ($description) {
            SEOMeta::setDescription($description);
        });
        return $this;
    }

    public function setType($type)
    {
        OpenGraph::setType($type);
        TwitterCard::setType($type);
        return $this;
    }

    public function setUrl($url = '')
    {
        $url = $url ?: request()->url();
        OpenGraph::setUrl($url);
        TwitterCard::setUrl($url);
        return $this;
    }

    public function setCanonical($url = '')
    {
        SEOMeta::setCanonical($url ?: env('APP_URL'));
        return $this;
    }

    public function setFacebook(array $attributes)
    {

        when(isset($attributes['description']), function () use ($attributes) {
            OpenGraph::setDescription($attributes['description']);
        });
        when(isset($attributes['title']), function () use ($attributes) {
            OpenGraph::setTitle($attributes['title']);
        });
        when(isset($attributes['image']), function () use ($attributes) {
            OpenGraph::addImage($attributes['image']);
        });
        OpenGraph::setSiteName(env('APP_NAME'));
        return $this;
    }

    public function setTwitter(array $attributes)
    {
        when(isset($attributes['description']), function () use ($attributes) {
            TwitterCard::setDescription($attributes['description']);
        });
        when(isset($attributes['title']), function () use ($attributes) {
            TwitterCard::setTitle($attributes['title']);
        });
        return $this;
    }

    public function setKeywords($keywords)
    {
        when(empty($keywords), function () use ($keywords) {
            SEOMeta::addKeyword($keywords);
        });
        return $this;
    }


}
