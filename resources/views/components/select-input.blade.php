<!-- resources/views/components/select.blade.php -->
@props(['id', 'name', 'options' => [], 'selected' => null, 'class' => '', 'disabled' => false])

<select id="{{ $id }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' . $class]) !!}>
    <option value="" disabled {{ is_null($selected) ? 'selected' : '' }}>Select Category</option>
    @foreach($options as $value => $label)
        <option value="{{ $value }}" {{ $value == $selected ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>

