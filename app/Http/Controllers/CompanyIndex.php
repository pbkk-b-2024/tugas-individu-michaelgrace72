<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
class CompanyIndex extends Controller
{
    //
    public $search='';
    public function index(Request $request)
    {
        $search = $request->input('search');
        $companies = Company::when($search, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%');
        })->paginate(5);

        // Send data to the view
        return view('company-index', compact('companies'));
    }
}
