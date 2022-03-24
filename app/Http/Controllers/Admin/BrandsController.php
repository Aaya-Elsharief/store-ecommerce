<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BrandsRequest;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BrandsController extends Controller
{

    public function index(){
        $brands = Brand::selection() -> paginate(PAGINATION_COUNT);
        return view('admin.brands.index',compact('brands'));
    }

    public function create(){
        return view('admin.brands.create');
    }

    public function store(BrandsRequest $request){
        // return $request;
        try{

            if (! $request -> has ('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' =>1]);

            //save img
            $filePath = "";
            if ($request->has('logo')) {
                $filePath = uploadImage('brands', $request->logo);
            }

            //insert to DB
            $brand =Brand::create([
                'name' => $request -> name,
                'logo'=>$filePath ,
                'active' => $request -> active,
            ]);



            //redirect message
            return redirect()->route('admin.brands')->with(['success' => 'تم إضافة العلامة التجارية بنجاح']);

        }catch (\Exception $exception){
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }

    }

    public function edit($id){
        try{

            $brand = Brand::selection() -> find($id);

            if(!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'العلامة التجارية غير موجودة، أو حدث خطأ ما']);


            return view('admin.brands.edit',compact('brand'));
        }catch (\Exception $exception){
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
        }

    }

    public function update($id, BrandsRequest $request){

        try{

            $brand = Brand::selection() -> find($id);

            if(!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'العلامة التجارية غير موجودة، أو حدث خطأ ما']);

            DB::beginTransaction();

            //save img
            $filePath = "";
            if ($request->has('logo')) {

                $img =  Str::after($brand ->logo, 'assets/');
                $img = base_path('assets/'.$img);
                unlink($img);

                $filePath = uploadImage('brands', $request->logo);
                Brand::where('id', $id)
                    ->update([
                        'logo' => $filePath,
                    ]);
            }

            if (! $request -> has ('active'))
                $request->request->add(['active' => 0]);
            else
                $request->request->add(['active' =>1]);


            $data = $request-> except('_token', 'id', 'logo');


            Brand::where('id', $id)
                ->update(
                    $data
                );

            DB::commit();

            //redirect message
            return redirect()->route('admin.brands')->with(['success' => 'تم تعديل العلامة التجارية بنجاح']);

        }catch (\Exception $exception){
            DB::rollBack();
            return redirect()->route('admin.brands')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);

        }
    }

    public function destroy($id){

        try{
            $brand = Brand::selection() -> find($id);

            if(!$brand)
                return redirect()->route('admin.brands')->with(['error' => 'العلامة التجارية غير موجودة، أو حدث خطأ ما']);

            $img =  Str::after($brand ->logo, 'assets/');
            $img = base_path('assets/'.$img);
            unlink($img);

            $brand -> delete();

            return redirect()->route('admin.brands')->with(['success' => 'تم حذف العلامة التجارية بنجاح']);

        }catch (\Exception $exception){
            return redirect()->route('admin.vendors')->with(['error' => 'حدث خطأ ما، يرجى المحاولة فيما بعد']);
        }
    }

}
