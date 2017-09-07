<?php namespace App\Custom;

use Psy\Exception\RuntimeException;
use Storage;
use App\Custom\S3;
use App\Http\Requests\Client\PreviewJobRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Facades\Image;

class PreviewImage
{

    protected $main_image_path = '/images/job_thumbnails';
    protected $side_image_path = '/images/side_images';

    public function uploadMainImage($req)
    {
        $image = $req->file('main_image');

        // 画像がない場合はS3のパスを返す。
        if (!$image) {
            $s3_filename = $req->get('main_image_filename');

            // S3のパスもない場合はfalseを返す。
            if (!$s3_filename) {
                return false;
            }

            return S3::getJobThumnbNailPath() . '/780x400/' . $s3_filename;
        }

        $local = Storage::disk('local');
        $ext = $image->getClientOriginalExtension();
        $filename = md5($image->getClientOriginalName() . time()) . '.' . $ext;

        $int_image = Image::make($image);
        $int_image->resize(780, 400);

        $ret1 = $local->put('/job_thumbnails/'.$filename, $int_image->stream());

        if ($ret1) {
            return $this->main_image_path . '/' . $filename;
        }

        throw new RuntimeException('Failed to save main image.');
    }

    public function uploadSideImage($req, $filetype)
    {
        $image = $req->file($filetype);

        // 画像がない場合はS3のパスを返す。
        if (!$image) {
            $s3_filename = $req->get($filetype.'_filename');

            // S3のパスもない場合はfalseを返す。
            if (!$s3_filename) {
                return false;
            }

            return S3::getJobSideImagePath() . '/360x270/' . $s3_filename;
        }

        $local = Storage::disk('local');
        $ext = $image->getClientOriginalExtension();
        $filename = md5($image->getClientOriginalName() . time()) . '.' . $ext;

        $int_image = Image::make($image);
        $int_image->resize(360, 270);

        $ret = $local->put('/side_images/'.$filename, $int_image->stream());

        if ($ret) {
            return $this->side_image_path . '/' . $filename;
        }

        throw new RuntimeException('Failed to save side image.');
    }

}