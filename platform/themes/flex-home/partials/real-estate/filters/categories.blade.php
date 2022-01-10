@php
    $categories = app(\Botble\RealEstate\Repositories\Interfaces\CategoryInterface::class)->pluck('re_categories.name', 're_categories.id');
@endphp

<div class="form-group">
    <label for="select-category" class="control-label">{{ __('Category') }}</label>
    <div class="select--arrow">
        <select name="category_id" id="select-category" class="form-control">
            <option value="">{{ __('-- Select --') }}</option>
            @foreach($categories as $categoryId => $categoryName)
                <option value="{{ $categoryId }}" @if (request()->input('category_id') == $categoryId) selected @endif>{{ $categoryName }}</option>
            @endforeach
        </select>
        <i class="fas fa-angle-down"></i>
    </div>
</div>
