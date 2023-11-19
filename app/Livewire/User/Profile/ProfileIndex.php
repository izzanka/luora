<?php

namespace App\Livewire\User\Profile;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class ProfileIndex extends Component
{
    use WithFileUploads;

    public string $username = '';

    public string $credential = '';

    public string $description = '';

    public $image;

    public $current_image;

    public int $total_followers = 0;

    public int $total_following = 0;

    public int $total_answers = 0;

    public int $total_questions = 0;

    public $answers = null;

    public $questions = null;

    public $user_followers = null;

    public $user_following = null;

    public $followed_topics = null;

    public bool $followed;

    public array $employment_credential = [];

    public array $education_credential = [];

    public array $location_credential = [];

    public $user;

    #[Locked]
    public bool $show;

    public function rules()
    {
        return [
            'username' => ['required', 'string', 'max:25', Rule::unique('users')->ignore(auth()->id())],
            'credential' => ['string', 'max:60'],
            'description' => ['string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
        ];
    }

    public function mount(User $user)
    {
        $user->load(['answers', 'questions', 'employment', 'education', 'location']);

        $this->user = $user;
        $this->username = $user->username;
        $this->credential = $user->credential ?? '';
        $this->description = $user->description ?? '';
        $this->current_image = $user->image;
        $this->total_followers = $user->userFollowers()->count();
        $this->total_following = $user->userFollowing()->count();
        $this->followed = auth()->user()->userIsFollowing($user->id);
        $this->total_answers = $user->answers()->count();
        $this->total_questions = $user->questions()->count();
        $this->employment_credential = $user->employment()->exists() ? $this->employmentCredential() : $this->employment_credential = [];
        $this->education_credential = $user->education()->exists() ? $this->educationCredential() : $this->education_credential = [];
        $this->location_credential = $user->location()->exists() ? $this->locationCredential() : $this->location_credential = [];
        $this->followed_topics = $user->topicFollowing()->latest()->get() ?? null;

        $user->id != auth()->id() ? $this->show = false : $this->show = true;
    }

    public function employmentCredential()
    {
        $year_or_currently = $this->user->employment->currently ? 'present' : $this->user->employment->end_year;
        $year_or_null = $year_or_currently ? $this->user->employment->start_year.' - '.$year_or_currently : $this->user->employment->start_year;

        return [
            'credential' => $this->user->employment->position.' at '.$this->user->employment->company,
            'year' => $year_or_null,
        ];
    }

    public function educationCredential()
    {
        $year_or_currently = $this->user->education->graduation_year ? ' Graduated '.$this->user->education->graduation_year : null;

        return [
            'credential' => $this->user->education->degree_type.' in '.$this->user->education->major.', '.$this->user->education->school,
            'year' => $year_or_currently,
        ];
    }

    public function locationCredential()
    {
        $year_or_currently = $this->user->location->currently ? 'present' : $this->user->location->end_year;
        $year_or_null = $year_or_currently ? $this->user->location->start_year.' - '.$year_or_currently : $this->user->location->start_year;

        return [
            'credential' => 'Lives in '.$this->user->location->location,
            'year' => $year_or_null,
        ];
    }

    public function follow()
    {
        try {

            if ($this->user->id != auth()->id()) {
                auth()->user()->userFollow($this->user->id);
                $this->followed = true;
                $this->total_followers = $this->user->userFollowers()->count();
                $this->showReset();
                $this->render();
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Follow failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function unfollow()
    {
        try {

            if ($this->user->id != auth()->id()) {
                auth()->user()->userUnfollow($this->user->id);
                $this->followed = false;
                $this->total_followers = $this->user->userFollowers()->count();
                $this->showReset();
                $this->render();
            }

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Unfollow failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function updateProfile()
    {
        $this->validate();

        try {

            if ($this->user->id == auth()->id()) {
                $username_slug = str()->slug($this->username);
                $image = $this->current_image;

                if ($this->image) {
                    if($image != null){
                        Storage::delete($image);
                    }
                    $image = $this->image->store('images/photos');
                }

                auth()->user()->update([
                    'username' => $this->username,
                    'username_slug' => $username_slug,
                    'image' => $image,
                    'credential' => $this->credential,
                    'description' => $this->description,
                ]);

                $this->dispatch('toastify',
                    text: 'Edit profile success ',
                    background: '#2D9655',
                );
            }

            $this->redirect(route('profile.index', $username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Edit profile failed, please try again later',
                background: '#CB4B10',
            );
        }
    }

    public function showReset()
    {
        $this->answers = null;
        $this->questions = null;
        $this->user_followers = null;
        $this->user_following = null;
    }

    public function showAnswers()
    {
        try {

            $this->showReset();
            $this->answers = $this->user->answers()->select(['id', 'user_id', 'question_id', 'answer', 'created_at'])->with('question:id,title,title_slug')->latest()->get();
            $this->render();

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Get user answers failed, please try again later ',
                background: '#CB4B10',
            );
        }

    }

    public function showQuestions()
    {
        try {

            $this->showReset();
            $this->questions = $this->user->questions()->latest()->get();
            $this->render();

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Get user questions failed, please try again later ',
                background: '#CB4B10',
            );
        }

    }

    public function showFollowers()
    {
        try {

            $this->showReset();
            $this->user_followers = $this->user->userFollowers()->get();
            $this->render();

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Get user followers failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function showFollowing()
    {
        try {

            $this->showReset();
            $this->user_following = $this->user->userFollowing()->get();
            $this->render();

        } catch (\Throwable $th) {
            $this->dispatch('toastify',
                text: 'Get user following failed, please try again later ',
                background: '#CB4B10',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.profile.profile-index');
    }
}
