<li class="nav-item ml-4">       
    <a href="{{ route('admin.comments.latest') }}" class="text-dark">
        <i class="bi bi-chat" style="font-size: 1.5rem;"></i>
        <span class="badge badge-primary badge-pill">
            {{ $comments ?? 0 }}
        </span>
    </a>
</li>