<li class="nav-item ml-4">       
    <a href="{{ route('admin.topics.latest') }}" class="text-dark">
        <i class="bi bi-journal" style="font-size: 1.5rem;"></i>
        <span class="badge badge-primary badge-pill">
            {{ $topics ?? 0 }}
        </span>
    </a>
</li>