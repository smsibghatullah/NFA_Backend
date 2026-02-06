<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GeneralInfo;

class GeneralInfoApiController extends Controller
{
    public function latest()
    {
        $info = GeneralInfo::where('is_visible', 1)
            ->latest()
            ->first();

        if (!$info) {
            return response()->json([
                'success' => false,
                'message' => 'No general information found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'email' => $info->email,
                'phone' => $info->phone,
                'address' => $info->address,
                'facebook' => $info->facebook,
                'twitter' => $info->twitter,
                'instagram' => $info->instagram,
            ]
        ], 200);
    }
}
