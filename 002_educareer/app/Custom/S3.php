<?php namespace App\Custom;

use Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Facades\Image;

class S3
{

    static public function getJobThumnbNailPath()
    {
        return 'https://s3-ap-northeast-1.amazonaws.com/education-career.jp/job-thumbnail';
    }

    static public function getJobSideImagePath()
    {
        return 'https://s3-ap-northeast-1.amazonaws.com/education-career.jp/side-image';
    }

    static public function getInterviewImagePath()
    {
        return 'https://s3-ap-northeast-1.amazonaws.com/education-career.jp/interview';
    }

    public function uploadMainImage(UploadedFile $image)
    {
        $s3 = Storage::disk('s3');
        $ext = $image->getClientOriginalExtension();
        $filename = md5($image->getClientOriginalName() . time()) . '.' . $ext;

        $int_image = Image::make($image);

        $int_image->resize(780, 400);
        $filepath = '/job-thumbnail/780x400/' . $filename;
        $ret1 = $s3->put($filepath, $int_image->stream(), 'public');

        $int_image->resize(390, 200);
        $filepath = '/job-thumbnail/390x200/' . $filename;
        $ret2 = $s3->put($filepath, $int_image->stream(), 'public');

        $int_image->resize(145, 100);
        $filepath = '/job-thumbnail/145x100/' . $filename;
        $ret3 = $s3->put($filepath, $int_image->stream(), 'public');

        if ($ret1 && $ret2 && $ret3) {
            return $filename;
        }

        return false;
    }

    public function uploadSideImage(UploadedFile $image)
    {
        $s3 = Storage::disk('s3');
        $ext = $image->getClientOriginalExtension();
        $filename = md5($image->getClientOriginalName() . time()) . '.' . $ext;

        $int_image = Image::make($image);
        $int_image->resize(360, 270);

        $filepath = '/side-image/360x270/' . $filename;
        $ret = $s3->put($filepath, $int_image->stream(), 'public');

        if ($ret) {
            return $filename;
        }

        return false;
    }

    public function uploadInterviewImage(UploadedFile $image)
    {
        $s3 = Storage::disk('s3');
        $ext = $image->getClientOriginalExtension();
        $filename = md5($image->getClientOriginalName() . time()) . '.' . $ext;

        $int_image = Image::make($image);
        $int_image->resize(145, 100);

        $filepath = '/interview/145x100/' . $filename;
        $ret = $s3->put($filepath, $int_image->stream(), 'public');

        if ($ret) {
            return $filename;
        }

        return false;
    }

}