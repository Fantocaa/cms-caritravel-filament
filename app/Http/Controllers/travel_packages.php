<?php

namespace App\Http\Controllers;

use App\Models\cities;
use App\Models\countries;
use App\Models\Document;
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

            // Menyembunyikan field yang tidak diinginkan
            $package->makeHidden(['deleted_at', 'created_at', 'updated_at', 'author', 'status']);
        });

        return response()->json($data);
    }

    public function visadata()
    {
        // Mengambil data dari Document dengan join ke tabel Country
        $data = Document::join('countries', 'documents.country', '=', 'countries.id')
            ->where('documents.status', '<>', 0)
            ->select('documents.*', 'countries.iso2', 'countries.name')
            ->get();

        // Mengubah iso2 menjadi lowercase dan mengganti countries dengan nama negara serta menambahkan URL flag
        $data->each(function ($item) {
            // Mengubah iso2 menjadi lowercase
            $item->iso2 = strtolower($item->iso2);

            // Menambahkan URL flag
            $item->flag = "https://flagcdn.com/w80/{$item->iso2}.png";

            // Menyembunyikan field yang tidak diinginkan
            $item->makeHidden(['deleted_at', 'created_at', 'updated_at', 'status', 'country']);
        });

        return response()->json($data);
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
