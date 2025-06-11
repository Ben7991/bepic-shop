<?php

declare(strict_types=1);

namespace App\View\Components\Molecules;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserProfile extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public string $initials,
        public string $name,
        public string $role
    ) {}

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.molecules.user-profile');
    }
}
