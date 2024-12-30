@if ($blogs->lastPage() > 1)
    @for ($page = 1; $page <= $blogs->lastPage(); $page++)
        <a class="{{ $page == $blogs->currentPage() ? 'active' : '' }}" 
           href="{{ $blogs->url($page) }}">
            {{ $page }}
        </a>
    @endfor
@endif
