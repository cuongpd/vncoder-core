<?php

namespace VnCoder\Helper;

use Intervention\Image\ImageManagerStatic as Image;

class ImageLib
{
    protected $image;

    public function __construct()
    {
        Image::configure(array('driver' => 'imagick'));
    }
}
