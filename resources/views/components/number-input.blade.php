<!-- resources/views/components/number-input.blade.php -->
@props(['disabled' => false, 'min' => 1])

<input 
    type="number" 
    {{ $disabled ? 'disabled' : '' }} 
    min="{{ $min }}"
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}
>
