<?php

namespace Code95\Page;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasTranslations;

    protected $fillable = ['title', 'slug', 'body', 'type', 'is_active'];

    public $translatable = ['title', 'body'];

    /**
     * @var array
     */
    const TYPES = [
        'static' => 1,
        'dynamic' => 2,
        1 => 'static',
        2 => 'dynamic',
    ];

    public function seo()
    {
        return $this->morphOne(Seo::class, 'model');
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSlug(Builder $query, $slug)
    {
        return $query->where('slug', $slug);
    }
}
