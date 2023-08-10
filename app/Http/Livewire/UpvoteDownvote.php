<?php

namespace App\Http\Livewire;

use App\Models\Post;
use App\Models\UpvoteDownvote as ModelsUpvoteDownvote;
use Livewire\Component;

class UpvoteDownvote extends Component
{
    public Post $post;

    public function mount(Post $post)
    {
        $this->post = $post;
    }

    public function render()
    {
        $upVotes = ModelsUpvoteDownvote::where('post_id', $this->post->id)
            ->where('is_upvote', true)
            ->count();

        $downVotes = ModelsUpvoteDownvote::where('post_id', $this->post->id)
            ->where('is_upvote', false)
            ->count();

        $hasUpvote = null;
        /** @var \App\Models\User $user */
        $user = request()->user();
        if ($user) {
            $model = ModelsUpvoteDownvote::where('post_id', $this->post->id)->where('user_id', $user->id)->first();
            if ($model) $hasUpvote = !!$model->is_upvote;
        }

        return view('livewire.upvote-downvote', compact('upVotes', 'downVotes','hasUpvote'));
    }

    public function upvoteDownvote($upVote = true)
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        if (!$user) return $this->redirect('login');

        if (!$user->hasVerifiedEmail()) return $this->redirect(route('verification.notice'));

        $model = ModelsUpvoteDownvote::where('post_id', $this->post->id)->where('user_id', $user->id)->first();

        if (!$model) {
            ModelsUpvoteDownvote::create([
                'is_upvote' => $upVote,
                'post_id' => $this->post->id,
                'user_id' => $user->id
            ]);
            return;
        }

        if ($upVote && $model->is_upvote || !$upVote && !$model->is_upvote) {
            $model->delete();
        } else {
            $model->is_upvote = $upVote;
            $model->save();
        }
    }
}
