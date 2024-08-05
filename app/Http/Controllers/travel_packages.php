<?php

namespace App\Http\Controllers;

use App\Models\cities;
use App\Models\countries;
use App\Models\Document;
use App\Models\LocationProduct;
use App\Models\TravelPackage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class travel_packages extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        // Mengambil data dari TravelPackage dan melakukan inner join dengan tabel users
        $data = TravelPackage::select('travel_packages.*', 'users.custom_fields as author_phone')
            ->where('travel_packages.status', '<>', 0)
            ->join('users', 'travel_packages.author', '=', 'users.id')
            ->get();

        // Ubah iso2 menjadi nama negara
        $data->each(function ($package) {
            $package->countries = collect($package->countries)->map(function ($iso2) {
                return countries::where('iso2', $iso2)->value('name');
            })->toArray();

            $package->cities = collect($package->cities)->map(function ($id) {
                return cities::where('id', $id)->value('name');
            })->toArray();

            // Dekode JSON dan ambil nilai phone
            $customFields = json_decode($package->author_phone, true);
            $phone = $customFields['phone'] ?? null;

            // Format harga
            $package->price = number_format($package->price, 0, ',', '.');

            // Tambahkan URL WhatsApp di depan nilai phone
            $package->author_phone = $phone ? 'https://api.whatsapp.com/send?phone=' . $phone : null;

            //  Mengubah thumb_img menjadi URL lengkap
            $package->thumb_img = $package->thumb_img ? asset('storage/' . $package->thumb_img) : null;

            // Mengubah setiap image_name menjadi URL lengkap
            $package->image_name = collect($package->image_name)->map(function ($image) {
                return asset('storage/' . $image);
            })->toArray();

            // Menyembunyikan field yang tidak diinginkan
            $package->makeHidden(['deleted_at', 'created_at', 'updated_at', 'author', 'status']);
        });

        return response()->json($data);
    }

    public function visadata()
    {
        $data = Document::where('status', '<>', 0)->get();

        $data->each(function ($item) {
            // Ambil data negara berdasarkan id negara yang ada di item data
            $countries = countries::whereIn('id', array_column($item->country, 'country'))
                ->get(['iso2', 'name']);

            // Tambahkan iso2 dan name ke dalam item data
            $item->iso2 = $countries->pluck('iso2')->map(fn ($iso2) => strtolower($iso2))->toArray();
            $item->country_names = $countries->pluck('name')->toArray();

            // Sembunyikan field yang tidak diinginkan
            $item->makeHidden(['country', 'status', 'deleted_at', 'created_at', 'updated_at']);
        });

        return response()->json($data);
    }

    public function product_location()
    {
        $data = LocationProduct::where('status', '<>', 0)->get();

        $data->each(function ($item) {
            // Ambil data negara berdasarkan id negara yang ada di item data
            $item->countries = countries::where('iso2', $item->countries)->value('name');
            $item->cities = cities::where('id', $item->cities)->value('name');

            // Sembunyikan field yang tidak diinginkan
            $item->makeHidden(['deleted_at', 'created_at', 'updated_at', 'status']);
        });

        return response()->json($data);
    }

    public function visa_country()
    {
        // Ambil semua dokumen
        $documents = Document::all();

        // Ambil negara dari setiap dokumen dan hapus duplikat
        // $countryIds = $documents->flatMap(function ($document) {
        //     return $document->country;
        // })->pluck('country')->unique();

        // // Format menjadi array of objects seperti [{1}, {2}, {102}]
        // $formattedCountries = $countryIds->map(function ($id) {
        //     return ['country' => $id];
        // });

        return response()->json($documents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TravelPackage $travelPackage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TravelPackage $travelPackage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TravelPackage $travelPackage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TravelPackage $travelPackage)
    {
        //
    }
}
