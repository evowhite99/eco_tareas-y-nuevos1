<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Papelera extends Component
{
    use WithPagination;

    public $search;

    public function updatingSearch() {
        $this->resetPage();
    }

    public function eliminarPermanente($userId) {
        $user = User::onlyTrashed()->findOrFail($userId);
        $user->forceDelete();

    }

    public function restaurar($id) {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

    }

    public function render() {
        $users = User::onlyTrashed()
            ->where(function ($query) {
                $query->where('name', 'LIKE', '%' . $this->search . '%')
                    ->orWhere('email', 'LIKE', '%' . $this->search . '%');
            })
            ->orderBy('id')
            ->paginate();
        return view('livewire.admin.papelera', compact('users'))
            ->layout('layouts.admin');
    }
}
