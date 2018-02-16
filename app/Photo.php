<?php

namespace App;

use Image;
use Storage;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

class Photo extends Model
{
    protected $guarded = ['id'];

    protected $appends = ['created_at_formatted','file_size_formatted'];

    protected $uploadPath = 'client-files/uploads';

    protected $photoFileTypes = ['image/jpeg','image/pjpeg','image/png'];

    protected $documentFileTypes = ['application/pdf'];

    /**
     * Upload media to the server and
     * save a reference to the database.
     * @param UploadedFile $file
     * @param null $tags
     * @return mixed
     */
    public static function uploadMedia(UploadedFile $file, $tags = null)
    {
        $photo = new static;
        if(in_array($file->getClientMimeType(), $photo->photoFileTypes))
        {
            return $photo->addPhoto($file, $tags);
        }
    }

    /**
     * Generate a unique name for the file.
     * @param $file
     * @return string
     */
    private function generateUniqueFileName($file)
    {
        return time() . '_' . uniqid() . '.' .$file->getClientOriginalExtension();
    }

    /**
     * Return the file path.
     * @param $name
     * @param string $folder
     * @return string
     */
    private function getPath($name, $folder = 'images')
    {
        $root = 'https://s3.amazonaws.com/'.config('filesystems.disks.s3.bucket');

        $path = [
            'full_path' => $root.'/'.$folder.'/' . $name,
            'thumbnail_path' => $root .'/'.$folder.'/th_' . $name,
            'upload_path' => $folder.'/'.$name,
            'thumbnail_upload_path' => $folder.'/th_' . $name,
        ];

        return $path;
    }

    /**
     * Add a photo to the media library.
     * @param $file
     * @param string $tags
     * @return static
     */
    private function addPhoto(UploadedFile $file, $tags = null)
    {
        $path = $file->storePublicly('images', 's3');
        $photo = $this->create([
            'title' => str_replace(' ', '-', $file->getClientOriginalName()),
            'path' => 'https://s3.amazonaws.com/'.config('filesystems.disks.s3.bucket').'/'.$path,
            'thumbnail_path' => 'https://s3.amazonaws.com/'.config('filesystems.disks.s3.bucket').'/'.$path,
            'caption' => '',
        ]);
        return $photo;
    }

    /**
     * Scope a query to only include images.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeImages($query)
    {
        return $query->where('type', 'image');
    }

    /**
     * Scope a query to only include videos.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeVideo($query)
    {
        return $query->where('type', 'video');
    }

    /**
     * Scope a query to only include documents.
     *
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDocuments($query)
    {
        return $query->where('type', 'document');
    }

    /**
     * Return the file size formatted.
     * @return string
     */
    public function getFileSizeFormattedAttribute()
    {
        if($this->size < 1048576)
        {
            return number_format($this->size / 1024, 2).'KB';
        }
        return number_format($this->size / 1048576, 2).'MB';
    }

    /**
     * Get formatted created at date.
     * @return mixed
     */
    public function getCreatedAtFormattedAttribute()
    {
        return $this->created_at->format('M dS, Y @ g:m A');
    }

    /**
     * Gets the tags associated with a given media file.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany('App\Tag', 'media_tag')->withTimestamps();
    }
}
