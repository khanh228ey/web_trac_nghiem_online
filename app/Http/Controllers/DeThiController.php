<?php

namespace App\Http\Controllers;

use App\Models\Cauhoi;
use App\Models\Cautraloi;
use App\Models\ChiTietDeThi;
use App\Models\Dethi;
use App\Models\Ketqua;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeThiController extends Controller
{
    //

    public function getAllDeThi(){
        $getDeThi = Dethi::with('Monhoc')->get();
        return response()->json($getDeThi);
    }

    public function thongTinDeThi($id){
        $getThongTinDeThi = Dethi::with('Monhoc')->where('id',$id)->get();
        return response()->json($getThongTinDeThi);
    }

    public function chiTietDeThi($id){
        $chiTietDeThi = Dethi::with('Monhoc','Cauhoi')->where('id',$id)->first();
        return response()->json($chiTietDeThi);
    }


    public function themDeThi(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'tendethi' => 'required|string|max:255',
            'thoigianthi' => 'required|int',
            'noidung' => 'required|max:255',
            'dap_an_a' => 'required|max:255',
            'dap_an_b' => 'required|max:255',
            'dap_an_c' => 'required|max:255',
            'dap_an_d' => 'required|max:255',
            'dap_an_dung' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }
            $deThi = new Dethi();
            $deThi->tendethi = $data['tendethi'];
            $deThi->thoigianthi = $data['thoigianthi'];
            $deThi->thoigianbatdau = Carbon::now();
            $thoigianketthuc = $deThi->thoigianbatdau->addMinutes($deThi->thoigianthi);
            $deThi->thoigiankethtuc = $thoigianketthuc;
            $soCauHoi = $data['soluongcauhoi'];
            $deThi->monhoc_id = $data['monhoc_id'];
            $deThi->soluongcauhoi = $soCauHoi;
            $deThi->save();
            for($i=0;$i<$soCauHoi;$i++){
                $cauHoi = new Cauhoi();
                $cauHoi->noidung = $data['noidung'][$i];
                $cauHoi->dap_an_a = $data['dap_an_a'][$i];
                $cauHoi->dap_an_b = $data['dap_an_b'][$i];
                $cauHoi->dap_an_c = $data['dap_an_c'][$i];
                $cauHoi->dap_an_d = $data['dap_an_d'][$i];
                $cauHoi->dap_an_dung = $data['dap_an_dung'][$i];
                $cauHoi->dethi_id = $deThi->id;
                $cauHoi->monhoc_id = $data['monhoc_id'];
                $cauHoi->save();
            }

            return response()->json(['message' => 'Tạo đề thi thành công.'], 200);
        }

       
       
        
}

    








