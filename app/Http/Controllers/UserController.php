<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class UserController extends Controller
{
    //
    public function index()
    {
        // return UserResource::collection(User::orderBy('hourly_rate', 'Desc')->get());
        $user = User::factory()->count(1)->make();
        $user = $user->first();
        return $user;
    } //end of index method

    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        return new UserResource($user);
    } //end of store method

    public function show(User $user, Request $request)
    {
        $convertion = $this->convertCurrency($user->currency, $request->currency, $user->hourly_rate);
        $user =  new UserResource($user);
        $response = [
            'user' => $user,
            'convertion' => $convertion
        ];
        return  $response;
    } //end of Show method

    public function Update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();
        $user->update($data);
        return new UserResource($user);
    } // end of Update method

    public function Destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted'], 200);
    } // end of Destroy method

    private function ConvertCurrency($fromCurrency, $toCurrency, $hourlyRate)
    {
        //get the currency symbols from the env file
        $currencyArray = explode(',', env('CURRENCIES'));
        $toCurrency = strtoupper($toCurrency);
        if (!in_array($toCurrency, $currencyArray)) {
            return response()->json(['error' => 'Please enter a valid and accepted currency!']);
        }

        $conversionDriver = env('CURRENCY_CONVERSION_DRIVER');

        switch ($conversionDriver) {
            case 'third_party':
                return $this->convertWithApi($fromCurrency, $toCurrency, $hourlyRate, $currencyArray);
                break;
            case 'local':
            default:
                return $this->convertWithLocalDriver($fromCurrency, $toCurrency, $hourlyRate);
        }
    } // end of ConvertCurrency method

    private function convertWithApi($fromCurrency, $toCurrency, $hourlyRate, $currencyArray): array
    {
        $response = Http::get('http://api.exchangeratesapi.io/v1/latest', [
            'access_key' => env('EXCHANGE_RATE_API_KEY'),
            'symbols' => implode(',', $currencyArray),
        ]);
        if ($response->status() === 200) {
            $response = $response->json();
            return [
                'from' => $fromCurrency,
                'to' => $toCurrency,
                'converted_hourly_rate' => $response['rates'][$toCurrency] * $hourlyRate,
            ];
        }
    }


    private function convertWithLocalDriver($fromCurrency, $toCurrency, $hourlyRate): array
    {
        return [
            'from' => $fromCurrency,
            'to' => $toCurrency,
            'converted_hourly_rate' => $hourlyRate * env($fromCurrency . '_TO_' . $toCurrency . '_RATE'),
        ];
    }
}
