<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use DefaultDatetimeFormat;
    use HasFactory;

    protected $casts = [
        'video' => 'json',
    ];

    //set${yourDatabaseColumnName}Attribute
    //called before submitting data to db
    public function setVideoAttribute($value)
    {
        //the below method json_encode converts the object to json from array
        /*
        'a'=>'val1',
        'b'=>'val2',
        ...
        after json_encode
        'a':'val1',
        'b':'val2',
        ....

        */
        $this->attributes['video'] = json_encode(array_values($value));
    }

    //this is called after getting data from db
    public function getVideoAttribute($value)
    {
        $resVideo = json_decode($value, true) ?: [];
        // dump($resVideo);
        // dump($value);
        if (!empty($resVideo)) {
            foreach ($resVideo as $key => $value) {
                $resVideo[$key]['url'] = $value['url'];
                
                $resVideo[$key]['thumbnail'] = $value['thumbnail'];
            }
        } 
        return $resVideo;
        //127.0.0.1
        //10.0.2.2

        //$this->attributes['video'] = array_values(json_decode($value, true) ?: []);
    }
}
