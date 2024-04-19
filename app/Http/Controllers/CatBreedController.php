<?php

namespace App\Http\Controllers;

use App\Models\CatBreed;
use Illuminate\Support\Facades\DB;
use App\Models\CatBreedSearch;
use App\Models\CatBreedsImage;
use App\Models\User;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;

class CatBreedController extends Controller
{   
    public function show(Request $request, $id)
    {
        $this->authorize('isAdmin', User::class);
        try {
            $breed = CatBreed::with('image')->find($id);
            foreach ($breed->image as $image) {
                if ($image->image && file_exists(public_path('images/'.$image->image))) {
                    $image->image = asset($image->image);
                } else {
                    // If the image doesn't exist, return the path string
                    $image->image = $image->image;
                }
            }
            // dd($breed);
            return response()->json($breed);
        } catch (RequestException $e) {
            $statusCode = $e->getResponse()->getStatusCode();
            if ($statusCode === 400) {
                return response()->json([           
                    'error' => 'Cat breed with the provided ID was not found.',
                ], 404);
            }
            return response()->json([
                'error' => 'Failed to fetch cat breed data',
            ], 500);
        }
    }

    public function getPopularCatBreeds(Request $request)
    {
        $popularBreeds = CatBreed::with('image')->orderBy('search_count', 'desc')->take(10  )->get();
        
        return response()->json($popularBreeds);
    }

    public function searchCatBreeds(Request $request)
    {
        $query = $request->query('name');
    
        try {   
            // Search for the breeds by name partially matching the query and order them by relevance
            $breeds = CatBreed::where('name', 'like', $query . '%')
                              ->orderBy('name')
                              ->get();
    
            // Check if any breeds are found
            if ($breeds->isNotEmpty()) {
                // foreach ($breeds as $breed) {
                //     $breed->increment('search_count');
                // }
                return response()->json($breeds);
            } else {
                return response()->json([
                    'error' => 'No cat breeds found for the provided query.',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to search for cat breeds.',
            ], 500);
        }
    }
    public function searchedCatBreedDetails($id){ 
        {
            try {
                $breed = CatBreed::with('image')->find($id);
                // dd($breed);
                $breed->increment('search_count');
                return response()->json($breed);
            } catch (RequestException $e) {
                $statusCode = $e->getResponse()->getStatusCode();
                if ($statusCode === 400) {
                    return response()->json([           
                        'error' => 'Cat breed with the provided ID was not found.',
                    ], 404);
                }
                return response()->json([
                    'error' => 'Failed to fetch cat breed data',
                ], 500);
            }
        }
    }
    public function PopularCatsSummary()
    {
        $popularBreeds = CatBreed::with('image')->orderBy('search_count', 'desc')->take(4)->get();
        return response()->json($popularBreeds);  
    }
    public function index()
    {
        $this->authorize('isAdmin', User::class);   
        $catBreeds = CatBreed::with('image')->get();
        foreach ($catBreeds as $catBreed) {
            foreach ($catBreed->image as $image) {
                if ($image->image && file_exists(public_path('images/'.$image->image))) {
                    
                    $image->image = asset($image->image);
                } else {
                    // If the image doesn't exist, return the path string
                    $image->image = $image->image;
                }
            }
        }
        return response()->json($catBreeds);  
    }

    public function store(Request $request)
    {
        $this->authorize('isAdmin', User::class);
        $request->validate([
            'id' => 'required|unique:cat_breeds|string|max:255',
            'name'=> 'required|string',
            'description' => 'required|string',
            'temperament' => 'required|string',
            'origin' => 'required|string',
            'life_span' => 'required|string',
            'adaptability' => 'required|integer|between:1,5',
            'affection_level' => 'required|integer|between:1,5',
            'child_friendly' => 'required|integer|between:1,5',
            'grooming' => 'required|integer|between:1,5',
            'intelligence' => 'required|integer|between:1,5',
            'health_issues' => 'required|integer|between:1,5',
            'social_needs' => 'required|integer|between:1,5',
            'stranger_friendly' => 'required|integer|between:1,5',
        ]);
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images'), $imageName);
        $catBreedImage = CatBreedsImage::create([
            'image' => $imageName,
            'cat_breed_id' => $request->id,
        ]);
        $catBreedData = $request->except('image');
        $catBreed = CatBreed::create($catBreedData);
        return response()->json($catBreed, 201);
    }
    

    public function update(Request $request, $id)
{
    $this->authorize('isAdmin', User::class);
    $catBreed = CatBreed::find($id);
    if (!$catBreed) {
        return response()->json(['error' => 'Cat breed not found'], 404);
    }

    $request->validate([
        'description' => 'required|string',
        'temperament' => 'required|string',
        'origin' => 'required|string',
        'life_span' => 'required|string',
        'adaptability' => 'required|integer|between:1,5',
        'affection_level' => 'required|integer|between:1,5',
        'child_friendly' => 'required|integer|between:1,5',
        'grooming' => 'required|integer|between:1,5',
        'intelligence' => 'required|integer|between:1,5',
        'health_issues' => 'required|integer|between:1,5',
        'social_needs' => 'required|integer|between:1,5',
        'stranger_friendly' => 'required|integer|between:1,5',
    ]);

    $catBreed->update($request->all());
    return response()->json($catBreed, 200);
}

    public function destroy($id)
    {
        $this->authorize('isAdmin', User::class);
        $catBreed = CatBreed::find($id);
        if (!$catBreed) {
            return response()->json(['error' => 'Cat breed not found'], 404);
        }
        $catBreed->delete();
        return response()->json(['message' => 'Cat breed deleted'], 200);
    }
    public function getCatBreedsFromExternal(Request $request)
    {
        $client = new Client();
        $response = $client->get('https://api.thecatapi.com/v1/breeds');
        $breeds = json_decode($response->getBody(), true);
        return response()->json($breeds);
    }

        public function fetchCatBreeds(Request $request)
    {
        $client = new Client();
        $response = $client->get('https://api.thecatapi.com/v1/breeds?limit=60');
        $breeds = json_decode($response->getBody(), true);

        foreach ($breeds as $breed) {
            DB::table('cat_breeds')->insert([
                'id' => $breed['id'],
                'name' => $breed['name'],
                'description' => $breed['description'],
                'temperament' => $breed['temperament'],
                'origin' => $breed['origin'],
                'life_span' => $breed['life_span'],
                'adaptability' => $breed['adaptability'],
                'affection_level' => $breed['affection_level'],
                'child_friendly' => $breed['child_friendly'],
                'grooming' => $breed['grooming'],
                'intelligence' => $breed['intelligence'],
                'health_issues' => $breed['health_issues'],
                'social_needs' => $breed['social_needs'],
                'stranger_friendly' => $breed['stranger_friendly'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
   
}
