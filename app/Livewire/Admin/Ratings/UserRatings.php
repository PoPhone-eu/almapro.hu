<?php

namespace App\Livewire\Admin\Ratings;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\DB;

#[Layout('layouts.adminapp')]
class UserRatings extends Component
{
    use WithPagination;
    public $search;
    public $user_id;
    public $user;
    public $rating_id;
    public $rating;
    public $author_name;
    public $rating_description;
    public $rating_value;
    public $rating_title;
    public $sortAsc = false;
    public $sortField  = 'created_at';

    public function mount($user_id)
    {
        $this->user_id  = $user_id;
        $this->user     = User::find($user_id);
    }

    public function deleteitem($id)
    {
        DB::table('reviews')->where('id', $id)->delete();
        $this->render();
    }

    public function openModal($rating_id)
    {
        $this->resetValues();
        $this->rating_id = $rating_id;
        $this->rating = DB::table('reviews')->where('id', $rating_id)->first();
        $author = \App\Models\User::find($this->rating->author_id);
        if ($author) $this->author_name = $author->full_name;
        $this->rating_description = $this->rating->body;
        $this->rating_value = $this->rating->rating;
        $this->rating_title = $this->rating->title;
        $this->dispatch('open-admin-modal');
    }
    #[On('closeModal')]
    public function closeModal()
    {
        $this->resetValues();
        $this->dispatch('close-modal');
    }

    public function resetValues()
    {
        $this->rating_id = null;
        $this->rating = null;
        $this->author_name = null;
        $this->rating_description = null;
        $this->rating_value = null;
        $this->rating_title = null;
    }

    public function sortBy($field)
    {
        $this->sortField = $field;
        if ($this->sortField === $field) {
            $this->sortAsc = !$this->sortAsc;
        } else {
            $this->sortAsc = true;
        }

        $this->sortField = $field;
    }

    public function render()
    {
        $search = '%' . $this->search . '%';
        return view(
            'livewire.admin.ratings.user-ratings',
            [
                'ratings' => DB::table('reviews')->where('reviewrateable_id', $this->user_id)
                    ->when($this->search, function ($query) use ($search) {
                        return $query->where('author_name', 'like', $search);
                    })
                    ->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')
                    ->paginate(20)
            ]
        );
    }
}
