<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Livewire\WithPagination;
use App\Comment;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic;

class Comments extends Component
{
    use WithPagination;
    // not comment for paginate page so use $comments then 
    //public $comments
    public function render()
    {
        return view(
            'livewire.comments',
            // add for new page so use only for paginate 
            [
                'comments' => Comment::where('support_ticket_id', $this->ticketId)->latest()->paginate(2)
            ]
        );
    }
    public $newcomment;
    public $image;
    public $ticketId;
    protected $listeners = [
        'fileupload' => 'handleFileUpload',
        'ticketSelected'
    ];

    public function ticketSelected($ticketId)
    {
        $this->ticketId = $ticketId;
    }

    public function handleFileUpload($imagedata)
    {
        $this->image = $imagedata;
    }
    // uncomment for not use paginate so use mount 
    // public function mount()
    // {
    //     $this->comments = Comment::latest()->get();
    // }
    public function updated($field)
    {
        $this->validateOnly($field, ['newcomment' => 'required|max:255|min:5',]);
    }
    public function remove($commentid)
    {
        //dd($commentid);
        $comment = Comment::find($commentid);
        Storage::disk('public')->delete($comment->image);
        $comment->delete();
        // uncomment this comment code for not use paginate  
        // $this->comments = $this->comments->except($commentid);
        session()->flash('message', "comment deleted  successfult 😄");
    }
    public function storeImage()
    {
        if (!$this->image) {
            return null;
        }
        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        $name  = Str::random() . '.jpg';
        Storage::disk('public')->put($name, $img);
        return $name;
    }

    public function addComment()
    {

        $this->validate(['newcomment' => 'required',]);
        $image = $this->storeImage();
        $createdcomment = Comment::create([
            'body' => $this->newcomment,
            'user_id' => 1,
            'image' => $image,
            'support_ticket_id' => $this->ticketId,
        ]);
        // demummy contnet add this new content add 
        //$this->comments->prepend($createdcomment);
        // array_unshift($this->comments, [
        //     'body' => $this->newcomment,
        //     'created_at' => Carbon::now()->diffForHumans(),
        //     'creator' => 'vikram singh',
        // ]);
        $this->newcomment = "";
        $this->image = "";
        session()->flash('message', "comment added successfult 😍 ");
    }
    public function getImageAttribute()
    {
        return Storage::disk('public')->url($this->image);
    }
}
