<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// Load models
use App\Models\Menu;
use App\Http\Resources\Menu as MenuResource;

class MenuController extends Controller
{
    public function index()
    {
        // Return list of menu
        $result = Menu::all();
        return $this->sendResponse(MenuResource::collection($result));
    }
}
