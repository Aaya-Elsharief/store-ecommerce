<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VendorsRequest;
use App\Models\Main_category;
use App\Models\Vendor;
use App\Notifications\VendorCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class VendorsController extends Controller
{
    public function index(){
        $vendors = Vendor::selection() -> paginate(PAGINATION_COUNT);
        return view('admin.vendors.index',compact('vendors'));
    }

    public function create(){
       $categories = Main_category::where('translation_of',0) -> active()->get();
         return view('admin.vendors.create',compact('categories'));

    }

    public function store(VendorsRequest $request){
      // return $request;
        try{

            if (! $request -> has ('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' =>1]);

            //save img
            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
            }

            //insert to DB
            $vendor =Vendor::create([
                'name' => $request -> name,
                'logo'=>$filePath ,
                'address' => $request -> address,
                'mobile' => $request -> mobile,
                'email'=> $request -> email,
                'active' => $request -> active,
                'password'=>$request -> password,
                'category_id' => $request -> category_id,
               'latitude' => $request -> latitude,
               'longitude' => $request -> longitude,
            ]);

                //notifications
           Notification::send($vendor, new VendorCreated ($vendor));

            //redirect message
            return redirect()->route('admin.vendors')->with(['success' => 'تم إضافة المتجر بنجاح']);

        }catch (\Exception $exception){
return $exception;
            return redirect()->route('admin.vendors')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }

    }

    public function edit($id){
        try{

            $vendor = Vendor::selection() -> find($id);

            if(!$vendor)
                return redirect()->route('admin.vendors')->with(['error' => 'المتجر غير موجود، أو حدث خطأ ما']);

            $categories = Main_category::where('translation_of',0) -> active()->get();

            return view('admin.vendors.edit',compact('vendor','categories'));
        }catch (\Exception $exception){
            return redirect()->route('admin.vendors')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }

    }
    public function update($id, VendorsRequest $request){

        try{

            $vendor = Vendor::selection() -> find($id);

            if(!$vendor)
                return redirect()->route('admin.vendors')->with(['error' => 'المتجر غير موجود، أو حدث خطأ ما']);

            DB::beginTransaction();

            //save img
            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('vendors', $request->logo);
                Vendor::where('id', $id)
                    ->update([
                    'logo' => $filePath,
                ]);
            }
            
             $data = $request-> except('_token', 'id', 'photo', 'password');

            //password
            if ($request->has('password') && !is_null($request -> password)) {
               $data['password'] = $request -> password;
            }

            Vendor::where('id', $id)
                ->update(
                    $data
                );

            DB::commit();

            //redirect message
            return redirect()->route('admin.vendors')->with(['success' => 'تم تعديل المتجر بنجاح']);

        }catch (\Exception $exception){
            DB::rollBack();
            return $exception;
            return redirect()->route('admin.vendors')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);

        }
    }

    public function destroy($id){

    try{
        $vendor = Vendor::selection() -> find($id);

        if(!$vendor)
            return redirect()->route('admin.vendors')->with(['error' => 'المتجر غير موجود، أو حدث خطأ ما']);



        $img =  Str::after($vendor ->logo, 'assets/');
        $img = base_path('assets/'.$img);
        unlink($img);


        $vendor -> delete();

        return redirect()->route('admin.vendors')->with(['success' => 'تم حذف المتجر بنجاح']);
    }catch (\Exception $exception){
        return $exception;
        return redirect()->route('admin.vendors')->with(['error' => 'حدث خطأ ما، يرجى المحاولة فيما بعد']);
    }
}



    public function changeStatus($id){

        try{

            $vendor = Vendor::selection() -> find($id);

            if(!$vendor)
                return redirect()->route('admin.vendors')->with(['error' => 'المتجر غير موجود، أو حدث خطأ ما']);


            $status = $vendor -> active == 0 ? 1:0;

            $vendor -> update(['active' => $status]);


            return redirect()->route('admin.vendors')->with(['success' => 'تم تغيير حالة المتجر بنجاح']);

        }catch (\Exception $exception){
            return redirect()->route('admin.vendors')->with(['error' => 'حدث خطأ ما، يرجى المحاولة فيما بعد']);

        }

    }


}
