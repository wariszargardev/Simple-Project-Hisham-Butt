<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait MediaTrait
{
    public function verifyAndUpload(Request $request, $fieldName = 'image', $directory = 'images')
    {
        if ($request->hasFile($fieldName)) {
            return $request->file($fieldName)->store($directory, 'public');
        }
        return "";
    }
}
