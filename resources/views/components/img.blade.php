@props(['src', 'alt' => ''])
<img src="{{ \App\Support\Catalog::media($src) }}" alt="{{ $alt }}"
     onerror="this.onerror=null;this.src='{{ asset('images/placeholder.svg') }}'"
     {{ $attributes->merge(['loading' => 'lazy', 'decoding' => 'async']) }}>
