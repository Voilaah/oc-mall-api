<?php

namespace Voilaah\MallApi\Http\Api;

use Illuminate\Routing\Controller;
use Voilaah\RestApi\Interfaces\ResourceInterface;
use View;

/**
 * Documentation Controller
 */
class Documentation extends Controller
{
    public function index() {
        return View::make('voilaah.mallapi::doc.index')->nest('content', 'voilaah.mallapi::doc.content', []);
    }
}
