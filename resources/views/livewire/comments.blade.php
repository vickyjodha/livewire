<div class=" mt-3">
    <h1 class="text-center">Comments</h1>

    @if (session()->has('message'))
    <div class="alert alert-success rounded shadow-sm">
        {{ session('message') }}
    </div>
    @endif
    @if($image)
    <img src="{{$image}}" class="mb-5" width="200px" alt="">
    @endif
    <section>


        <input type="file" name="" id="image" wire:change="$emit('filechoosen')">
    </section>
    <form wire:submit.prevent="addComment">
        <div>
            <div class="d-flex justify-content mb-5 mt-5">
                <input type="text" name="" id="" class="flex-left form-control @error('newcomment') is-invalid @enderror  W-100 rounded-lg  " placeholder="what's in your mind." wire:model.debounce.500ms="newcomment">
                <button type="submit" class=" flex-right  btn  btn-success rounded-lg ml-2">Add</button>
            </div>
            @error('newcomment')
            <span class="invalid-feedback" role="alert">
                <strong>{{$message}}</strong>
            </span>
            @enderror
        </div>



    </form>
    @foreach($comments as $comment)

    <div class="card mb-3">
        @if($comment->image)
        <img src="{{'storage/'.$comment->image}}" class="card-img-top" width="50px" alt="">
        @endif
        <div class="card-body">
            <h5 class="card-title">{{$comment->creator->name}} </h5>
            <p class="card-text">{{$comment->body}}</p>
            <p class="card-text"><small class="text-muted">{{$comment->created_at->diffForHumans()}}</small> </p>
            <i wire:click="remove({{$comment->id}})" class="cursor: pointer text-danger fa fa-times  " aria-hidden="true"></i>
        </div>
    </div>


    @endforeach



    <!-- normaliy use link so default use but change so use code  -->
    {{$comments->links('custom-pagination-links')}}
</div>
<script>
    window.livewire.on('filechoosen', () => {
        let inputField = document.getElementById('image')
        let file = inputField.files[0];
        let reader = new FileReader();
        reader.onloadend = () => {

            window.livewire.emit('fileupload', reader.result)
        }
        reader.readAsDataURL(file);
    })
</script>