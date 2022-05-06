<?php

namespace App\Http\Controllers;

use App\Models\WorkshopCategory;
use Illuminate\Http\Request;

class WorkshopCategoryController extends Controller
{
    public function index()
    {
        return WorkshopCategory::all();
    }
}
