<?php

namespace App\Http\Controllers;

use App\Models\CatBreed;
use App\Models\CatBreedsImage;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatBreedsImageController extends Controller
{

    public function index(Request $request){
        $images= CatBreedsImage::all();
       // dd($images);
        return response()->json($images);
    }
    public function fetchCatBreedsImages(Request $request)
    {
        $client = new Client();
        $breeds= CatBreed::all();
        foreach($breeds as $breed){
            $response = $client->get('https://api.thecatapi.com/v1/images/search?limit=10&breed_ids='.$breed->id);
            $images=json_decode($response->getBody(), true);
            foreach($images as $image){
                //dd($image['url']);
                DB::table('cat_breeds_images')->insert(
                    [
                        'cat_breed_id'=>$breed->id,
                        'image'=>$image['url'],
                    ]
            );
            }
           
        }
    

    }
}
