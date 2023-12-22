<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\UnitPrice;


class UniqueUnitPriceCombination implements Rule
{
    private $category_id;
    private $sub_category_id;
    private $package_id;

    public function __construct($category_id, $sub_category_id)
    {
        $this->category_id     = $category_id;
        $this->sub_category_id = $sub_category_id;
        // $this->package_id      = $package_id;
    }

    public function passes($attribute, $value)
    {
        $category_id     = $this->category_id;
        $sub_category_id = $this->sub_category_id;
        // $package_id      = $this->package_id;
        
        // Check if the combination exists in the database
        return !UnitPrice::where([
            'type'                     => $value,
            'estimate_category_id'     => $category_id,
            'estimate_sub_category_id' => $sub_category_id,
            // 'package_id'               => $package_id,
        ])->exists();
    }

    public function message()
    {
        return 'The combination of type, category, sub-category, and package already exists.';
    }
}
