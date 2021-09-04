<li class="nav-item ml-5">       
    <a href="{{ route('admin.answers.latest') }}" class="text-dark">
        <i class="bi bi-newspaper" style="font-size: 1.5rem;"></i>
        <span class="badge badge-primary badge-pill">
            {{ $answers ?? 0 }}
        </span>
    </a>
</li>