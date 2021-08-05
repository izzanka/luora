@if($errors->isNotEmpty())
    @foreach ($errors->get($name) as $error)
        <small class="text-danger">
            {{ $error }}
        </small>
    @endforeach
@endif