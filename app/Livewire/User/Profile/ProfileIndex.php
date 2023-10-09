<?php

namespace App\Livewire\User\Profile;

use App\Models\User;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class ProfileIndex extends Component
{
    use WithFileUploads;

    public $username;
    public $credential;
    public $description;
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
    public bool $show;
    public bool $followed;
    public $employment_credential;
    public $education_credential;
    public $location_credential;
    public $user;


    public function rules()
    {
        return [
            'username' => ['required','string','max:25', Rule::unique('users')->ignore(auth()->id())],
            'credential' => ['string','max:60'],
            'description' => ['string','max:255'],
            'image' => ['nullable','image','max:2048']
        ];
    }

    public function mount(User $user)
    {
        $user->load(['answers','questions','employment','education','location']);

        $this->user = $user;
        $this->username = $user->username;
        $this->credential = $user->credential;
        $this->description = $user->description;
        $this->current_image = $user->image;
        $this->total_followers = $user->followers()->count();
        $this->total_following = $user->following()->count();
        $this->followed = auth()->user()->isFollowing($user->id);
        $this->total_answers = $user->answers()->count();
        $this->total_questions = $user->questions()->count();
        $this->employment_credential = $user->employment()->exists() ? $this->employmentCredential() : $this->employment_credential = null;
        $this->education_credential = $user->education()->exists() ? $this->educationCredential() : $this->education_credential = null;
        $this->location_credential = $user->location()->exists() ? $this->locationCredential() : $this->location_credential = null;

        $user->id != auth()->id() ? $this->show = false : $this->show = true;
    }

    public function employmentCredential()
    {
        $year_or_currently = $this->user->employment->currently ? 'present' : $this->user->employment->end_year;
        $year_or_null = $year_or_currently ?  $this->user->employment->start_year . ' - ' . $year_or_currently : $this->user->employment->start_year;

        return [
            'credential' => $this->user->employment->position . ' at ' . $this->user->employment->company,
            'year' => $year_or_null,
        ];
    }

    public function educationCredential()
    {
        $year_or_currently = $this->user->education->graduation_year ? ' Graduated ' . $this->user->education->graduation_year : null;
        return [
            'credential' => $this->user->education->degree_type . ' in ' . $this->user->education->major . ', ' . $this->user->education->school,
            'year' => $year_or_currently,
        ];
    }

    public function locationCredential()
    {
        $year_or_currently = $this->user->location->currently ? 'present' : $this->user->location->end_year;
        $year_or_null = $year_or_currently ? $this->user->location->start_year . ' - ' . $year_or_currently : $this->user->location->start_year;

        return [
            'credential' => 'Lives in ' . $this->user->location->location,
            'year' => $year_or_null,
        ];
    }

    public function follow()
    {
        try {

            if($this->user->id != auth()->id())
            {
                auth()->user()->follow($this->user->id);
                $this->followed = true;
                $this->total_followers = $this->user->followers()->count();
                $this->showReset();
                $this->render();
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Follow error',
                icon: 'error',
            );
        }
    }

    public function unfollow()
    {
        try {

            if($this->user->id != auth()->id())
            {
                auth()->user()->unfollow($this->user->id);
                $this->followed = false;
                $this->total_followers = $this->user->followers()->count();
                $this->showReset();
                $this->render();
            }

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Unfollow error',
                icon: 'error',
            );
        }
    }

    public function updateProfile()
    {
        $this->validate();

        try {

            if($this->user->id == auth()->id())
            {
                $username_slug = str()->slug($this->username);
                $image = $this->current_image;

                if($this->image)
                {
                    $temp_image = $this->image->store('/public/images/photos');
                    $image = str_replace('public', 'storage', $temp_image);
                }

                auth()->user()->update([
                    'username' => $this->username,
                    'username_slug' => $username_slug,
                    'image' => $image,
                    'credential' => $this->credential,
                    'description' => $this->description
                ]);

                $this->dispatch('swal',
                    title: 'Edit profile success',
                    icon: 'success',
                );
            }

            $this->redirect(route('profile.index', $username_slug));

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Edit profile error ' . $th->getMessage(),
                icon: 'error',
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
            $this->answers = $this->user->answers()->select(['id','user_id','question_id','answer','created_at'])->with('question:id,title,title_slug')->latest()->get();
            $this->render();

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Get user answers error',
                icon: 'error',
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
            $this->dispatch('swal',
                title: 'Get user questions error',
                icon: 'error',
            );
        }

    }

    public function showFollowers()
    {
        try {

            $this->showReset();
            $this->user_followers = $this->user->followers()->get();
            $this->render();

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Get user followers error',
                icon: 'error',
            );
        }
    }

    public function showFollowing()
    {
        try {

            $this->showReset();
            $this->user_following = $this->user->following()->get();
            $this->render();

        } catch (\Throwable $th) {
            $this->dispatch('swal',
                title: 'Get user following error',
                icon: 'error',
            );
        }
    }

    public function render()
    {
        return view('livewire.user.profile.profile-index');
    }
}
