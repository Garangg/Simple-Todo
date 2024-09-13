<?php

namespace App\Livewire;

use App\Models\Todo;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithPagination;

class TodoList extends Component
{
    use WithPagination;

    #[Rule('required|min:2|max:255')]
    public $name;
    public $search;
    public $idEdit;
    public $nameEdit;

    public function create(){
        $validated = $this->validateOnly('name');

        Todo::create($validated);

        $this->reset('name');

        session()->flash('success', 'Todo Created Successfully.');
    }

    public function delete($id){
        Todo::findOrFail($id)->delete();
    }

    public function toggle($id){
        $todo = Todo::findOrFail($id);
        $todo->completed= !$todo->completed;
        $todo->save();
    }

    public function edit($id){
        $todo = Todo::findOrFail($id);
        $this->idEdit = $todo->id;
        $this->nameEdit = $todo->name;
    }

    public function update(){
        $this->validateOnly('nameEdit');

        Todo::findOrFail($this->idEdit)->update(['name' => $this->nameEdit]);


        $this->cancelEdit();

        session()->flash('success', 'Todo Updated Successfully.');
    }

    public function cancelEdit(){
        $this->reset('idEdit', 'nameEdit');
    }

    public function render()
    {
        return view('livewire.todo-list', [
            'todos' => Todo::latest()->where('name', 'like', '%'.$this->search.'%')->paginate(6),
        ]);
    }
}
