<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Request;
use Illuminate\View\Component;

class Navbar extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $links = [
            ['link' => route('pages.articles'), 'label' => 'Articoli', 'active' => Request::is('articoli*')],
            ['link' => route('pages.books'), 'label' => 'Libri', 'active' => Request::is('libri*')],
            ['link' => route('pages.events'), 'label' => 'Eventi', 'active' => Request::is('eventi*')],
            ['link' => route('pages.aboutUs'), 'label' => 'Chi siamo', 'active' => Request::is('chi-siamo')],
            ['link' => route('pages.contacts'), 'label' => 'Contatti', 'active' => Request::is('contatti')],
        ];

        return view('components.navbar', [
            'links' => $links,
        ]);
    }
}