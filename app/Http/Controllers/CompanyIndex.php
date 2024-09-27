<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Http;
use Str;
class CompanyIndex extends Controller
{
    //
    public $search='';
    public $TMDBID ='';
    public function create()
    {
        return view('company-create');
    }
    public function store(Request $request){
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            //code...
            $response = Http::get('https://api.themoviedb.org/3/company/'.$input.'?api_key='.$api_key);

            $existingCompany = Company::where('tmdb_id', $input)->first();
            if ($existingCompany) {
                return redirect()->route('admin.companies.index')
                    ->with('error', 'Company already exists.');
            }
            $newCompany = $response->json();
            try {
                Company::create([
                'tmdb_id' => $newCompany['id'],
                'name' => $newCompany['name'],
                'slug' => Str::slug($newCompany['name']),
                'logo_path' => $newCompany['logo_path'],
                'origin_country' => $newCompany['origin_country'],
            ]);
            return redirect()->route('admin.companies.index')
                ->with('success', 'Company created successfully.');

            } catch (\Throwable $th) {
                return redirect()->route('admin.companies.index')
                    ->with('error', 'Failed to create company.');    
                //throw $th;
            }
                        } catch (\Throwable $th) {
                //throw $th;
                return redirect()->route('admin.companies.index')
                    ->with('error', 'Company not found.');
            }
    }
    public function edit($id){
        $company = Company::find($id);
        return view('company-edit', compact('company'));
    }
    public function update(Request $request, $id){
        $company = Company::find($id);
        $company->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'logo_path' => $request->logo_path,
            'origin_country' => $request->origin_country,
        ]);
        return redirect()->route('admin.companies.index')
            ->with('success', 'Company updated successfully.');
    }
    public function delete($id){
        $company = Company::find($id);
        $company->delete();
        return redirect()->route('admin.companies.index')
            ->with('success', 'Company deleted successfully.');
    }
    public function index(Request $request)
    {
        $search = $request->input('search');
        $companies = Company::when($search, function ($query, $search) {
            return $query->whereRaw('LOWER(name) LIKE ?',[ '%' . strtolower($search) . '%']);
        })->orderBy('id')->paginate(5);

        // Send data to the view
        return view('company-index', compact('companies'));
    }
    public function showall(){
        $companies = Company::all();
        return response()->json($companies);
    }
    public function show($id){
        $company = Company::find($id);
        return response()->json($company);
    }
    public function storeapi(Request $request){
        $user = auth()->user();
        if(!$user->hasRole('admin')){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        try {
            $response = Http::get('https://api.themoviedb.org/3/company/'.$input.'?api_key='.$api_key);
            $existingCompany = Company::where('tmdb_id', $input)->first();
            if ($existingCompany) {
                return response()->json(['message' => 'Company already exists.'], 400);
            }
            $newCompany = $response->json();
            Company::create([
                'tmdb_id' => $newCompany['id'],
                'name' => $newCompany['name'],
                'slug' => Str::slug($newCompany['name']),
                'logo_path' => $newCompany['logo_path'],
                'origin_country' => $newCompany['origin_country'],
            ]);
            return response()->json(['message' => 'Company created successfully.', $newCompany], 201);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Company not found.'], 404);
        }
    }
    public function updateapi(Request $request, $id){
        $user = auth()->user();
        if(!$user->hasRole('admin')){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $input = $request->input('TMDBID');
        $api_key = env('TMDB_API_KEY');
        if($existingCompany = Company::where('tmdb_id', $input)->first()){
            return response()->json(['message' => 'Company already exists.'], 400);
        }
        try {
            $response = Http::get('https://api.themoviedb.org/3/company/'.$input.'?api_key='.$api_key);
            $newCompany = $response->json();
            $company = Company::find($id);
            $company->update([
                'tmdb_id' => $newCompany['id'],
                'name' => $newCompany['name'],
                'slug' => Str::slug($newCompany['name']),
                'logo_path' => $newCompany['logo_path'],
                'origin_country' => $newCompany['origin_country'],
            ]);
            return response()->json(['message' => 'Company updated successfully.'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Company not found.'], 404);
        }

    }
    public function deleteapi($id){
        $user = auth()->user();
        if(!$user->hasRole('admin')){
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $company = Company::find($id);
        $company->delete();
        return response()->json(['message' => 'Company deleted successfully.', $company], 200);
    }

}
