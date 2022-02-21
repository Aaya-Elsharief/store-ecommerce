<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MainCategoriesRequest;
use App\Models\Main_category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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

            return redirect()->route('admin.maincategories')->with(['success' => 'تم إضافة القسم بنجاح']);

        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);

        }

    }


    public function edit($mainCategoryId)
    {
        //get specific categories with its tranlations
         $mainCategory = Main_category::with('categories')
            ->selection()
            -> find($mainCategoryId);

        if (!$mainCategory) {
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجودة']);
        }
        return view('admin.maincategories.edit',compact('mainCategory'));

    }


    public function update($mainCategoryId,MainCategoriesRequest $request){

      try {
        $maincategory = Main_category::find($mainCategoryId);

        if (!$maincategory)
            return redirect()->route('admin.maincategories')->with(['error' => 'هذا القسم غير موجودة']);


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
              $filePath = uploadImage('maincategories', $request->photo);
              Main_category::where('id', $mainCategoryId)->update([
                  'photo' => $filePath,
              ]);
          }


        return redirect()->route('admin.maincategories')->with(['success' => 'تم تعديل القسم بنجاح']);

      }catch (\Exception $exception){

          return redirect()->route('admin.maincategories')->with(['error' => 'هناك خطا ما يرجي المحاوله فيما بعد']);
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
