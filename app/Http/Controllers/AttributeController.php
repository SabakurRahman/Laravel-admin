<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreAttributeRequest;
use App\Http\Requests\UpdateAttributeRequest;
use Illuminate\Support\Facades\Schema;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $attribute;

    public function __construct()
    {
        $this->attribute = new Attribute();
    }

    final public function index(Request $request)
    {


        $page_content = [
            'page_title'      => __('Attribute List'),
            'module_name'     => __('Attribute'),
            'sub_module_name' => __('list'),
            'module_route'    => route('attribute.create'),
            'button_type'    => 'create' //create, update

       ];

        $columns = Schema::getColumnListing('attributes');
        $filters = $request->all();
        $attribute = $this->attribute->getAttributeList($request);


        return view('attributeview.index', compact('page_content','attribute','filters','columns'));

    }

    /**
     * Show the form for creating a new resource.
     */
    final public function create()
    {
        $page_content = [
            'page_title'      => __('Attribute Create'),
            'module_name'     => __('Attribute'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('attribute.index'),
            'button_type'    => 'list' //create, update
        ];
        return view('attributeview.create', compact('page_content'));
    }

    /**
     * Store a newly created resource in storage.
     */
      final public function store(StoreAttributeRequest $request)
    {
        try{
            $this->attribute->create($this->attribute->prepareAttributeData($request));
            return redirect()->route('attribute.index')->with('success', 'Attribute created successfully');}
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('attribute.index')->with('error', 'Something went wrong, please try again later.');
        }
        }

    /**
     * Display the specified resource.
     */
    final public function show(Attribute $attribute)
    {
        $page_content = [
            'page_title'      => __('Attribute  Details'),
            'module_name'     => __('Attribute'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('attribute.index'),
            'button_type'    => 'list' //create
        ];
        return view('attributeview.show',compact('attribute','page_content'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(Attribute $attribute)
    {
        $page_content = [
            'page_title'      => __('Attribute Edit'),
            'module_name'     => __('Attribute'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('attribute.index'),
            'button_type'    => 'list' //create, update
        ];
        return view('attributeview.edit', compact('page_content','attribute'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        try{
            $original = $attribute->getOriginal();
            $updated  =$this->attribute->updateAttribute($attribute,$this->attribute->prepareAttributeData($request,$attribute));
            $changed  =$updated->getChanges();
            (new ActivityLog())->storeActivityLog($request,$original,$changed,$attribute);
            return redirect()->route('attribute.index')->with('success', 'Attribute updated successfully');

        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('attribute.index')->with('error', 'Something went wrong, please try again later.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request,Attribute $attribute)
    {
        try{
            $original = $attribute->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $attribute);
            $this->attribute->deleteAttribute($attribute);
            return redirect()->route('attribute.index')->with('success', 'Attribute deleted successfully');
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->route('attribute.index')->with('error', 'Something went wrong, please try again later.');
        }
    }
}
