<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\FaqPage;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFaqPageRequest;
use App\Http\Requests\UpdateFaqPageRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Throwable;

class FaqPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page_content = [
            'page_title'      => __('Faq Page List'),
            'module_name'     => __('Faq Page '),
            'sub_module_name' => __('List'),
            'module_route'    => route('faq-pages.create'),
            'button_type'    => 'create' //create
        ];
        $columns = Schema::getColumnListing('faq_pages');
        $filters = $request->all();
        $faqPageList = (new FaqPage())->allFaqPageList($request);
        return view('faq_pages.index',compact('faqPageList',
            'page_content','filters','columns'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $page_content = [
            'page_title'      => __('Faq Page Create'),
            'module_name'     => __('Faq Page'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('faq-pages.index'),
            'button_type'    => 'list' //create
        ];

        return view('faq_pages.create', compact('page_content'));
    }

    /**
     * @param StoreFaqPageRequest $request
     * @return RedirectResponse
     */
    final public function store(StoreFaqPageRequest $request): RedirectResponse
    {
        try {
            DB::beginTransaction();
            (new FaqPage())->createFaqPages($request);
            DB::commit();
            $message = 'FAQ pages added successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('FAQ_PAGES_SAVE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('faq-pages.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FaqPage $faqPage)
    {
        $page_content = [
            'page_title'      => __('FaqPage  Details'),
            'module_name'     => __('Faq Page '),
            'sub_module_name' => __('Details'),
            'module_route'    => route('faq-pages.index'),
            'button_type'    => 'list' //create
        ];
        return view('faq_pages.show',compact('faqPage','page_content'));

    }

    /**
     * @param FaqPage $faqPage
     * @return View
     */
    final public function edit(FaqPage $faqPage):View
    {
        $page_content = [
            'page_title'      => __('Faq Page Edit'),
            'module_name'     => __('Faq Page'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('faq-pages.index'),
            'button_type'    => 'list' //create
        ];

        return view('faq_pages.edit', compact('page_content', 'faqPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFaqPageRequest $request, FaqPage $faqPage)
    {
        try {
            DB::beginTransaction();
            $original = $faqPage->getOriginal();
            $updated   = (new FaqPage())->updateFaqPages($request,$faqPage);
            $changed = $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $faqPage);
            DB::commit();
            $message = 'FAQ pages update successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('FAQ_PAGES_UPDATE_FAILED', ['data' => $request->all(), 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->route('faq-pages.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FaqPage $faqPage,Request $request)
    {
        try {
            DB::beginTransaction();
            $original = $faqPage->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $faqPage);
            $faqPage->delete();
            DB::commit();
            $message = 'Faq Page Information Delete successfully';
            $class   = 'success';
        } catch (Throwable $throwable) {
            DB::rollBack();
            Log::info('FAQ_PAGE_INFORMATION_DELETE_FAILED', ['data' => $faqPage, 'error' => $throwable]);
            $message = 'Failed! ' . $throwable->getMessage();
            $class   = 'danger';
        }
        session()->flash('message', $message);
        session()->flash('class', $class);
        return redirect()->back();

    }
}
