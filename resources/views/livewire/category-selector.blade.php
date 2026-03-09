<div class="row g-3">
    {{-- Hidden inputs so they submit with the main form --}}
    <input type="hidden" name="category_id" value="{{ $category_id }}">
    <input type="hidden" name="sub_category_id" value="{{ $sub_category_id }}">
    <input type="hidden" name="sub_sub_category_id" value="{{ $sub_sub_category_id }}">

    {{-- Category --}}
    <div class="col-md-4">
        <label class="form-label">Category</label>
        <select wire:model="category_id" class="form-select">
            <option value="">Select</option>
            @foreach($categories as $cat)
                <option value="{{ (int)$cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Sub Category --}}
    @if(!empty($subCategories))
    <div class="col-md-4">
        <label class="form-label">Sub Category</label>
        <select wire:model="sub_category_id" class="form-select">
            <option value="">Select</option>
            @foreach($subCategories as $sub)
                <option value="{{ $sub->id }}">{{ $sub->name }}</option>
            @endforeach
        </select>
    </div>
    @endif

    {{-- Sub Sub Category --}}
    @if(!empty($subSubCategories))
    <div class="col-md-4">
        <label class="form-label">Sub Sub Category</label>
        <select wire:model="sub_sub_category_id" class="form-select">
            <option value="">Select</option>
            @foreach($subSubCategories as $subsub)
                <option value="{{ $subsub->id }}">{{ $subsub->name }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <pre>
Category ID: {{ $category_id }}
Sub Category ID: {{ $sub_category_id }}
Sub Sub Category ID: {{ $sub_sub_category_id }}
</pre>
</div>
