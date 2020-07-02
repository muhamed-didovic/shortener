<?php

namespace MuhamedDidovic\Shortener\Controllers;

use Illuminate\Routing\Controller as BaseController;
use MuhamedDidovic\Shortener\Models\Link;

/**
 * Class SinglePageController.
 */
class SinglePageController extends BaseController
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show()
    {
        //when code is found in DB
        if ($code = request()->segment(1) && count(request()->segments()) == 1) {
            $link = Link::byCode($code)->first();

            if ($link) {
                $link->increment('used_count', 1);
                $link->touchTimestamp('last_used');

                return redirect($link->original_url); //301
            }
        }

        //return VUE spa app
        return view('shortener::shortener');
    }
}
