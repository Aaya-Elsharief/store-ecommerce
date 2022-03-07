<?php

namespace App\Observers;

use App\Models\Main_category;

class MainCategoryObserver
{
    /**
     * Handle the Main_category "created" event.
     *
     * @param  \App\Models\Main_category  $main_category
     * @return void
     */
    public function created(Main_category $main_category)
    {
        //
    }

    /**
     * Handle the Main_category "updated" event.
     *
     * @param  \App\Models\Main_category  $main_category
     * @return void
     */
    public function updated(Main_category $main_category)
    {
        $main_category -> vendors() -> update(['active' => $main_category -> active]);
    }

    /**
     * Handle the Main_category "deleted" event.
     *
     * @param  \App\Models\Main_category  $main_category
     * @return void
     */
    public function deleted(Main_category $main_category)
    {
        $main_category -> category_translations() -> delete();
    }

    /**
     * Handle the Main_category "restored" event.
     *
     * @param  \App\Models\Main_category  $main_category
     * @return void
     */
    public function restored(Main_category $main_category)
    {
        //
    }

    /**
     * Handle the Main_category "force deleted" event.
     *
     * @param  \App\Models\Main_category  $main_category
     * @return void
     */
    public function forceDeleted(Main_category $main_category)
    {
        //
    }
}
