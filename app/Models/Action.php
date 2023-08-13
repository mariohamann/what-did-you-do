<?php

namespace App\Models;

use App\Data\ActionsJsonData;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Action extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'category_id', 'description', 'lat', 'lng'];

    protected $visible = ['id', 'user', 'category_id', 'description', 'created_at', 'likes', 'category', 'lat', 'lng'];

    protected $appends = ['likes', 'category', 'user'];

    protected static function booted()
    {
        static::created(function ($action) {
            $action->addToJsonFile();
        });

        static::deleted(function ($action) {
            $action->removeFromJsonFile();
        });
    }

    /**
     * Get the owner of the action.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the category of the action. This is hard coded with Sushi.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id');
    }

    /**
     * Get the likes for the action.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // get user

    public function getUserAttribute()
    {
        return $this->user()->first();
    }

    public function getLikesAttribute()
    {
        $total = $this->likes()->count();
        $liked = $this->likes()->where('user_id', auth()->id())->exists();

        return compact('total', 'liked');
    }

    public function getCategoryAttribute()
    {
        return $this->category()->first();
    }

    public function addToJsonFile()
    {
        $actionData = ActionsJsonData::from([
            'id' => $this->id,
            'ca' => $this->category->id,
            'la' => round($this->lat, 5),
            'ln' => round($this->lng, 5),
        ]);

        $existingData = json_decode(Storage::disk('public')->get('actions.json'), true);
        $existingData[] = $actionData;

        Storage::disk('public')->put('actions.json', json_encode($existingData));
    }

    public function removeFromJsonFile()
    {
        $existingData = json_decode(Storage::disk('public')->get('actions.json'), true);
        $existingData = array_filter($existingData, function ($action) {
            return $action['id'] !== $this->id;
        });

        Storage::disk('public')->put('actions.json', json_encode($existingData));
    }

    public static function createJsonFile()
    {
        $actions = Action::all()->map(function ($action) {
            return ActionsJsonData::from([
                'id' => $action->id,
                'ca' => $action->category->id,
                'la' => round($action->lat, 5),
                'ln' => round($action->lng, 5),
            ]);
        });

        Storage::disk('public')->put('actions.json', $actions->toJson());
    }

    public static function getJsonFileUrl(): string
    {
        $filename = 'actions.json';
        $publicPath = storage_path('app/public/'.$filename);
        $filemtime = file_exists($publicPath) ? filemtime($publicPath) : '';

        return asset('storage/'.$filename).'?v='.$filemtime;
    }

    public function scopeLocatedWithin($query, $neLat, $neLng, $swLat, $swLng)
    {
        return $query
            ->whereBetween('lat', [$swLat, $neLat])
            ->whereBetween('lng', [$swLng, $neLng]);
    }
}
