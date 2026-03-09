<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;

class CategorySelector extends Component
{
    public $categories, $subCategories = [], $subSubCategories = [];
    public $category_id, $sub_category_id, $sub_sub_category_id;

    public function mount($category_id = null, $sub_category_id = null, $sub_sub_category_id = null)
    {
        $this->categories = Category::all();
        $this->category_id = $category_id;
        $this->sub_category_id = $sub_category_id;
        $this->sub_sub_category_id = $sub_sub_category_id;

        if ($this->category_id) {
            $this->subCategories = SubCategory::where('category_id', $this->category_id)->get();
        }

        if ($this->sub_category_id) {
            $this->subSubCategories = SubSubCategory::where('sub_category_id', $this->sub_category_id)->get();
        }
    }

    public function updatedCategoryId($categoryId)
{
    $categoryId = (int) $categoryId;
    logger('Selected category ID: '.$categoryId);

    $this->subCategories = SubCategory::where('category_id', $categoryId)->get();
    $this->sub_category_id = null;
    $this->sub_sub_category_id = null;
    $this->subSubCategories = [];
}

    public function updatedSubCategoryId($subCategoryId)
    {
        $this->subSubCategories = SubSubCategory::where('sub_category_id', $subCategoryId)->get();
        $this->sub_sub_category_id = null;
    }

    public function render()
    {
        return view('livewire.category-selector');
    }
}
