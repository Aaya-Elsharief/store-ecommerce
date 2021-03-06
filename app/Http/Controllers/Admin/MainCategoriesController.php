<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoriesRequest;
use App\Models\Main_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use mysql_xdevapi\Exception;

class MainCategoriesController extends Controller
{
    public function index()
    {
        $default_lang = get_default_lang();

        $categories = Main_category::where('translation_lang', $default_lang)->selection()->get();

        return view('admin.mainCategories.index', compact('categories'));
    }


    public function create()
    {
        return view('admin.mainCategories.create');
    }


    public function store(MainCategoriesRequest $request)
    {

        try {
            $collection = collect($request->category);

            $main_category = $collection->filter(
                function ($value, $key) {
                    return $value['abbr'] == get_default_lang();;
                }
            );

            $default_category = array_values($main_category->all())[0];

            //save img
            $filePath = "";
            if ($request->has('photo')) {
                $filePath = uploadImage('maincategories', $request->photo);
            }

            DB::beginTransaction();

            $default_category_id = Main_category::insertGetId([
                'translation_lang' => $default_category['abbr'],
                'translation_of' => 0,
                'name' => $default_category['name'],
                'slug' => $default_category['name'],
                'photo' => $filePath,
            ]);


            $other_categories = $collection->filter(
                function ($value, $key) {
                    return $value['abbr'] != get_default_lang();
                }
            );

            if (isset($other_categories) && $other_categories->count()) {
                $categories_arr = [];
                foreach ($other_categories as $category) {
                    $categories_arr[] = [
                        'translation_lang' => $category['abbr'],
                        'translation_of' => $default_category_id,
                        'name' => $category['name'],
                        'slug' => $category['name'],
                        'photo' => $filePath,
                    ];
                }
                Main_category::insert($categories_arr);
            }

            DB::commit();

            return redirect()->route('admin.maincategories')->with(['success' => '???? ?????????? ?????????? ??????????']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => '???????? ?????? ???? ???????? ???????????????? ???????? ??????']);

        }

    }


    public function edit($mainCategoryId)
    {
        //get specific categories with its tranlations
         $mainCategory = Main_category::with('category_translations')
            ->selection()
            -> find($mainCategoryId);
//return $mainCategory;
        if (!$mainCategory) {
            return redirect()->route('admin.maincategories')->with(['error' => '?????? ?????????? ?????? ????????????']);
        }
        return view('admin.maincategories.edit',compact('mainCategory'));

    }


    public function update($mainCategoryId,MainCategoriesRequest $request){

      try {
        $maincategory = Main_category::find($mainCategoryId);

        if (!$maincategory)
            return redirect()->route('admin.maincategories')->with(['error' => '?????? ?????????? ?????? ????????????']);


        $category = array_values($request->category)[0];

        if (!$request->has('category.0.active'))
            $request->request->add(['active' => 0]);
        else
            $request->request->add(['active' => 1]);

        //update data
        Main_category::where('id', $mainCategoryId)->update([
            'name' => $category['name'],
            'active' => $request->active,


        ]);

          //save img
          $filePath = "";
          if ($request->has('photo')) {
              $img =  Str::after($category ->photo, 'assets/');
              $img = base_path('assets/'.$img);
              unlink($img);

              $filePath = uploadImage('maincategories', $request->photo);
              Main_category::where('id', $mainCategoryId)->update([
                  'photo' => $filePath,
              ]);
          }


        return redirect()->route('admin.maincategories')->with(['success' => '???? ?????????? ?????????? ??????????']);

      }catch (\Exception $exception){

          return redirect()->route('admin.maincategories')->with(['error' => '???????? ?????? ???? ???????? ???????????????? ???????? ??????']);
      }



    }

    public function destroy($mainCategoryId){

        try{

            $mainCategory = Main_category::find($mainCategoryId);

            if(!$mainCategoryId)
                return redirect()->route('admin.maincategories')->with(['error' => '?????? ?????????? ?????? ????????????']);


            $vendors = $mainCategory -> vendors(); // from relation

            if(isset ($vendors) && $vendors -> count() > 0){
                return redirect()->route('admin.maincategories')->with(['error' => '?????? ?????????? ???? ???????? ????????']);
            }


            $img =  Str::after($mainCategory ->photo, 'assets/');
            $img = base_path('assets/'.$img);
            unlink($img);


            $mainCategory -> delete();

            return redirect()->route('admin.maincategories')->with(['success' => '???? ?????? ?????????? ??????????']);




        }catch (\Exception $exception){

            return redirect()->route('admin.maincategories')->with(['error' => '?????? ?????? ?????? ???????? ???????????????? ???????? ??????']);

        }
    }

    public function changeStatus($mainCategoryId){

        try{

            $mainCategory = Main_category::find($mainCategoryId);

            if(!$mainCategoryId)
                return redirect()->route('admin.maincategories')->with(['error' => '?????? ?????????? ?????? ????????????']);

             $status = $mainCategory -> active == 0 ? 1:0;

            $mainCategory -> update(['active' => $status]);


            return redirect()->route('admin.maincategories')->with(['success' => '???? ?????????? ???????? ?????????? ??????????']);

        }catch (\Exception $exception){
            return redirect()->route('admin.maincategories')->with(['error' => '?????? ?????? ?????? ???????? ???????????????? ???????? ??????']);

        }


    }
}













/*
    try{
        DB::beginTransaction();
            //code here (transaction with DB)
        DB::commit();

    }catch (\Exception $exception){
        DB::rollBack();
    }
*/
