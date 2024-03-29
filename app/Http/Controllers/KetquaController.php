<?php

namespace App\Http\Controllers;

use App\Models\Ketqua;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KetquaController extends Controller
{
    //
    public function ketQuaLamBai(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'socaudung' => 'required|int',
            'sodiem' => 'required|int',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $ketQua = new Ketqua();
        $ketQua->socaudung = $data['socaudung'];
        $ketQua->sodiem = $data['sodiem'];
        $ketQua->thoigianvaothi = Carbon::now();
        $ketQua->thoigianthi = 30;
        $ketQua->dethi_id = $data['id'];
        $user = Auth::user();
        $ketQua->user_id = $user->id;
        $ketQua->save();
        return response()->json(['message' => 'Nộp bài thành công'], 200);
    }
}
