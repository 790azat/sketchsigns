<x-layout :title="$category->name" :description="strip_tags((string) $category->description) ?: null">
    <x-page-hero :title="$category->name" eyebrow="Shop by category" :crumbs="array_filter(['Shop' => route('shop'), $category->parent?->name => $category->parent ? route('category', $category->parent) : null, $category->name => null], fn ($v, $k) => $k !== '', ARRAY_FILTER_USE_BOTH)">
        {{ \Illuminate\Support\Str::limit(trim(html_entity_decode(strip_tags((string) $category->description))), 220) }}
    </x-page-hero>
    <section class="container-x py-12">
        @if ($category->children->isNotEmpty())
            <div class="mb-8 flex flex-wrap gap-2">
                @foreach ($category->children as $child)
                    <a href="{{ route('category', $child) }}" class="rounded-full border border-slate-300 px-4 py-2 text-sm font-medium hover:border-brand-500 hover:text-brand-600">{{ $child->name }}</a>
                @endforeach
            </div>
        @endif
        <livewire:shop-browser :category="$category->slug" />
    </section>
    <x-cta-band />
</x-layout>
