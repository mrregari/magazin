<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = ['title','content','category_id','status_id','img','price','old_price','qty','hit','sale'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function status() {
        return $this->belongsTo(Status::class);
    }
    public function getImage() {
        if (!$this->img) {
            return asset('assets/front/img/no-image.png');
        }
        // Картинки из public/assets/... отдаём напрямую, остальные лежат в storage
        if (str_starts_with($this->img, 'assets/')) {
            return asset($this->img);
        }
        return asset("storage/{$this->img}");
    }
}