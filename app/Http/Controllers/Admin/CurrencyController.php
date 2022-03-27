<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    protected $rabidApiHost = 'currency-exchange.p.rapidapi.com';
    protected $rabidApiKey = '1367d1b391mshfab6f13c652cc8fp11a7c7jsn588eeab6e1d8';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('currencies.index');
        Carbon::setLocale(app()->getLocale());
        $currencies = Currency::latest();
        if($request->name) {
            $currencies->where('name', 'like', '%' . $request->name . '%');
        }
        if($request->code) {
            $currencies->where('code', 'like', '%' . $request->code . '%');
        }
        $currencies = $currencies->paginate(10);
        $defaultCurrency = Currency::where('default', 1)->first();
        if(count($currencies) > 0) {
            foreach($currencies as $currency) {
                $response = Http::withHeaders([
                    'X-RapidAPI-Host' => $this->rabidApiHost,
                    'X-RapidAPI-Key' => $this->rabidApiKey
                ])->get('https://currency-exchange.p.rapidapi.com/exchange', [
                    'from' => $currency->code,
                    'to' => $defaultCurrency->code,
                    'amount' => 1
                ]);
                if($response) {
                    $currency->exchange_rate = number_format($response->json(), 2);
                    $currency->save();
                }
            }
        }
        return view('currencies.index', compact('currencies'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        if($currency->default == 0) {
            $findedCurrency = Currency::where('default', 1)->first();
            if($findedCurrency) {
                $findedCurrency->default = 0;
                $findedCurrency->save();
            }
            $currency->default = 1;
            $currency->save();
            return redirect()->back()->with('success', translate('edit successfully'));
        } else {
            return redirect()->back()->with('error', translate("there is something error"));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
