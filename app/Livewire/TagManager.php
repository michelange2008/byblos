<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tag;

class TagManager extends Component
{
    public $name = '';
    public $editingId = null;

    public function render()
    {
        return view('livewire.tag-manager', [
            'tags' => Tag::orderBy('name')->get()
        ]);
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
        ]);

        if ($this->editingId) {
            $tag = Tag::findOrFail($this->editingId);
            $tag->update(['name' => $this->name]);
        } else {
            Tag::create(['name' => $this->name]);
        }

        $this->resetForm();
    }

    public function edit($id)
    {
        $tag = Tag::findOrFail($id);
        $this->editingId = $tag->id;
        $this->name = $tag->name;
    }

    public function cancelEdit()
    {
        $this->resetForm();
    }

    public function delete($id)
    {
        Tag::findOrFail($id)->delete();
    }

    private function resetForm()
    {
        $this->name = '';
        $this->editingId = null;
    }
}
