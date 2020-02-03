<div class="form-group">
    <label for="name">Category Name</label>
    <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Category Name" value="{{ isset($category->name) ? $category->name : '' }}" required>
</div>
<div class="form-group">
    <label for="name">Category Level</label>
    <select class="form-control" name="parent_id" id="">
    	<option value="0">Main Category</option>
    	@foreach($levels as $level)
			<option value="{{ $level->id }}" @if(isset($category)) {{ ($category->parent_id == $level->id) ? 'selected' : '' }} @endif >{{ $level->name }}</option>

    	@endforeach
    </select>
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control" name="description" id="description" placeholder="Description" >{{ isset($category->description) ? $category->description : '' }}</textarea>
</div>

<div class="form-group">
    <label for="description">URL</label>
    <input type="text" class="form-control" name="url" id="url" placeholder="url" value="{{ isset($category->url) ? $category->url : '' }}" required>
</div>