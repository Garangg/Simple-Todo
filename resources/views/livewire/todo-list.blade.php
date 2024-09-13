<div class="md:flex min-h-screen">
    <div class="w-full md:w-2/5 px-3 h-full">
        @include('livewire.includes.create-todo-box')
        @if (session('success'))
            <span class="text-green-500 text-xs">{{ session('success') }}</span>
        @endif
    </div>
    <div class="w-full md:w-3/5 py-1 px-3 border-l-2">
        @include('livewire.includes.search-todo')
        <div id="todos-list">
            @foreach ($todos as $todo)
                @include('livewire.includes.todo-card')
            @endforeach
            <div class="my-2">
                {{ $todos->links() }}
            </div>
        </div>
    </div>
</div>
