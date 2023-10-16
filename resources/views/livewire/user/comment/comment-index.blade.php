<div>
    <hr class="mt-3 mb-3">
        <livewire:user.comments.comment-create :answer-id="$answer->id" :commentModel="null" :parentId="null" :showProfile="true" :isEditing="false"/>
    {{-- <hr class="mt-3 mb-2"> --}}
    <div>
        @if($comments->count() > 0)
            @foreach($comments as $comment)
                <livewire:user.comments.comment-item wire:key="{{ $comment->id }}" :comment="$comment" />
            @endforeach
        @endif
    </div>
</div>
