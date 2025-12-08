@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center justify-center w-full rounded-lg px-4 py-4 text-sm font-medium bg-indigo-50 text-indigo-700 transition duration-150 ease-in-out'
            : 'flex items-center justify-center w-full rounded-lg px-4 py-4 text-sm font-medium text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
