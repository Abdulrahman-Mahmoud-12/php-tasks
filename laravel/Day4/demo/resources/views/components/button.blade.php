@props(['class' => 'primary', 'content' => 'Button'])
<button {{ $attributes->merge(['class' => 'btn btn-' . $class]) }}>
    {{ $content }}
</button>