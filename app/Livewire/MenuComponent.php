<?php

namespace App\Livewire;

use App\Models\Menu;
use Livewire\Component;

class MenuComponent extends Component
{
    public $menus;

    public function mount()
    {
        $this->menus = Menu::whereNull('parent_id')->with('children.children')->get();
    }


    public function render()
    {
        return view('livewire.menu-component');
    }
}
