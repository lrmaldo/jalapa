<?php
use Illuminate\Support\Facades\Storage;


if(!function_exists('formatBytes')):
    function formatBytes($size, $precision = 2){
        $base = log($size, 1024);
        $suffixes = array('', 'KB', 'MB', 'GB', 'TB');
        return round(pow(1024, $base - floor($base)), $precision) .' '. $suffixes[floor($base)];
    }
endif;

if(!function_exists('imageManager')):
    function imageManager($url, $width, $model){
        $imageOptimized = ImageManagerStatic::make(Storage::get($url))->widen($width)->encode('webp');
        $urlEncode = $url.'.webp';
        Storage::put($url, (string) $imageOptimized);
        Storage::move($url, $urlEncode);
        if($model->image):
            if(Storage::exists($model->image->url)):
                Storage::delete($model->image->url);
            endif;
            $model->image()->update([
                'url' => $urlEncode,
            ]);
        else:
            $model->image()->create([
                'url' => $urlEncode,
                'main' => true,
            ]);
        endif;
    }
endif;
if(!function_exists('imagesManager')):
    function imagesManager($url, $width, $model){
        $imageOptimized = ImageManagerStatic::make(Storage::get($url))->widen($width)->encode('webp');
        $urlEncode = $url.'.webp';
        Storage::put($url, (string) $imageOptimized);
        Storage::move($url, $urlEncode);
        $model->images()->create([
            'url' => $urlEncode
        ]);
    }
endif;