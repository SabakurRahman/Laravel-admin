<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreAttributeValueRequest;
use App\Http\Requests\UpdateAttributeValueRequest;
use Illuminate\Support\Facades\Schema;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $attributevalue;

    public function __construct()
    {
        $this->attributevalue = new AttributeValue();
    }



    final public function index(Request $request)
    {


        $page_content = [
            'page_title'      => __('Attribute Value Page'),
            'module_name'     => __('Attribute Value'),
            'sub_module_name' => __('List'),
            'module_route'    => route('attribute-value.create'),
            'button_type'    => 'create' //create, update
        ];
        $columns = Schema::getColumnListing('attribute_values');
        $filters = $request->all();
        $attributevalue = $this->attributevalue->getAttributeValueList($request);
        $attributeOptions = (new Attribute())->getAttributeOption();
        return view('attributevalueview.index', compact('page_content',
            'attributevalue','columns','filters','attributeOptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
      final   public function create()
    {


        $attributeOptions = (new Attribute())->getAttributeOption();

        $page_content = [
            'page_title'      => __('Attribute Value Create'),
            'module_name'     => __('Attribute Value'),
            'sub_module_name' => __('Create'),
            'module_route'    => route('attribute-value.index'),
            'button_type'    => 'list' //create, update
        ];
        return view('attributevalueview.create', compact('page_content','attributeOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    final public function store(StoreAttributeValueRequest $request)
    {

        try{
            $this->attributevalue->create($this->attributevalue->prepareAttributeValue($request));
            return redirect()->route('attribute-value.index')->with('success', 'Attribute Value created successfully');}
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(AttributeValue $attributeValue)
    {
        $page_content = [
            'page_title'      => __('Attribute Value  Details'),
            'module_name'     => __('Attribute Value'),
            'sub_module_name' => __('Details'),
            'module_route'    => route('attribute-value.index'),
            'button_type'    => 'list' //create
        ];
        return view('attributevalueview.show',compact('attributeValue','page_content'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    final public function edit(AttributeValue $attributeValue)
    {
        $attributeOptions = (new Attribute())->getAttributeOption();
        $page_content = [
            'page_title'      => __('Attribute Value Edit'),
            'module_name'     => __('Attribute Value'),
            'sub_module_name' => __('Edit'),
            'module_route'    => route('attribute-value.index'),
            'button_type'    => 'list' //create, update
        ];
        return view('attributevalueview.edit', compact('page_content','attributeValue','attributeOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    final public function update(UpdateAttributeValueRequest $request, AttributeValue $attributeValue)
    {
        try{
            $original  = $attributeValue->getOriginal();
            $updated   = $this->attributevalue->updateAttributeValue($this->attributevalue->prepareAttributeValue($request,$attributeValue),$attributeValue);
            $changed   =  $updated->getChanges();
            (new ActivityLog())->storeActivityLog($request,$original,$changed,$attributeValue);
            return redirect()->route('attribute-value.index')->with('success', 'Attribute Value updated successfully');
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    final public function destroy(Request $request,AttributeValue $attributeValue)
    {
        try{
            $original = $attributeValue->getOriginal();
            $changed = null;
            (new ActivityLog())->storeActivityLog($request, $original, $changed, $attributeValue);
            $this->attributevalue->deleteAttributeValue($attributeValue);
            return redirect()->route('attribute-value.index')->with('success', 'Attribute Value deleted successfully');
        }
        catch(\Exception $e){
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }
}
