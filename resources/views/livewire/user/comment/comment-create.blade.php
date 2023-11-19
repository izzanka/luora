<div>
    <form wire:submit="createComment" x-data="{
        focused: {{ $parentId ? 'true' : 'false' }},
        isEdit: {{ $commentModel ? 'true' : 'false' }},
        init() {
            if (this.isEdit || this.focused) {
                this.$refs.input.focus();
            }
            $wire.on('close-comment-box-from-create', () => {
                this.focused = false;
            })
            $wire.on('hide-comment-form', () => {
                this.focused = false;
                this.isEdit = false;
            })
        }
        }">
                {{-- <div class="flex items-start gap-2 justify-start">
                    @if($showProfile)
                        <div class="overflow-hidden rounded-full w-8 h-8">
                        </div>
                    @endif
                    <div class="flex-1">
                        <textarea
                            x-ref="input"
                            name="comment"
                            @click="focused = true"
                            id="comment"
                            wire:model.lazy="comment"
                            placeholder="Write a comment..."
                            class="block w-full border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset sm:text-sm sm:leading-6 font-medium transition-all duration-300 ease-in-out"
                            :rows="focused || isEdit ? 4 : 1"></textarea>
                        @error('comment')
                        @enderror
                    </div>
                </div>
                <div class="text-right mt-4 {{ strlen($comment) > 0 ? 'block' : 'hidden' }}">
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Post</button>
                    <button wire:click="resetForm" type="button" class="inline-flex items-center px-4 py-2 border border-transparent font-semibold text-xs text-gray-800 uppercase tracking-widest hover:text-gray-700 focus:text-gray-700 active:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Cancel</button>
                </div> --}}
        <div class="row">
            @if(!$isEditing)
                <div class="col-1">
                    @if ($showProfile)
                        <span class="avatar rounded-circle avatar-sm" style="background-image: url(@if(auth()->user()->image == null) 'https://ui-avatars.com/api/?name={{ auth()->user()->username }}&background=DE6060&color=fff&rounded=true&size=56' @else {{ asset('storage/' . auth()->user()->image) }} @endif)"></span>
                    @endif
                </div>
            @endif
            <div class="@if($isEditing) col-8 @else col-7 @endif">
                <input type="text"
                x-ref="input"
                @click="focused = true"
                wire:model="comment"
                placeholder="Add a comment..."
                class="form-control form-control-rounded @error('comment') is-invalid @enderror">
                @error('comment')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="col-4 text-end">
                @if ($isEditing)
                    <a href="#" class="btn btn-ghost-secondary btn-pill" wire:click.prevent="resetForm">
                        Cancel
                    </a>
                @endif
                <button class="btn btn-primary btn-pill" type="submit">
                    @if ($isEditing)
                        Edit
                    @else
                        Add Comment
                    @endif
                </button>
            </div>
        </div>
    </form>
</div>
