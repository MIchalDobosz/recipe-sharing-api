<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'files_recipes');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'avatar_id');
    }

    public static function store($files, $disk, $path)
    {
        if (gettype($files) !== 'array') return self::storeSingleFile($files, $disk, $path);

        foreach ($files as $file)
        {
            $filesData[] = self::storeSingleFile($file, $disk, $path);
        }
        return $filesData;
    }

    private static function storeSingleFile($file, $disk, $path)
    {
        $file = $file->store($path, $disk);
        $url = Storage::url($file);
        $fileData = [
            'path' => $file,
            'url' => $url
        ];

        return $fileData;
    }
}
