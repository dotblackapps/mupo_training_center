<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PopupContent extends Component
{
    /**
     * MUPO Training Center does not display the legacy LMS promotional popup.
     *
     * The PopupContent module can remain installed for administration/data
     * compatibility, but the public component is intentionally disabled on
     * every page.
     */
    public function render()
    {
        $popup = false;
        $modal = false;

        return view(theme('components.popup-content'), compact('popup', 'modal'));
    }
}
