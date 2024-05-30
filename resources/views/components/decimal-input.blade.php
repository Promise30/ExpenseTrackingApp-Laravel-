<!-- resources/views/components/decimal-input.blade.php -->
@props(['disabled' => false, 'min' => 0, 'step' => '0.01'])

<input 
    type="number" 
    {{ $disabled ? 'disabled' : '' }} 
    min="{{ $min }}" 
    step="{{ $step }}"
    {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}
>
