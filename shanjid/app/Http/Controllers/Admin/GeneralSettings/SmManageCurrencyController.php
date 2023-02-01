<?php

namespace App\Http\Controllers\Admin\GeneralSettings;


use App\SmCurrency;
use App\SmGeneralSettings;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\GeneralSettings\SmCurrencyRequest;

class SmManageCurrencyController extends Controller
{
    public function __construct()
    {
        $this->middleware('PM');

    }
  
    // manage currency
      public function manageCurrency()
      {
  
          try {
            
              $currencies = SmCurrency::whereIn('school_id', [1, Auth::user()->school_id])->get();
              return view('backEnd.systemSettings.manageCurrency', compact('currencies'));
          } catch (\Exception $e) {
              Toastr::error('Operation Failed', 'Failed');
              return redirect()->back();
          }
      }
  
      public function storeCurrency(SmCurrencyRequest $request)
      {
  
          $is_duplicate = SmCurrency::where('school_id', Auth::user()->school_id)->where('name', $request->name)->where('code', $request->code)->first();
  
          try {
              $s = new SmCurrency();
              $s->name = $request->name;
              $s->code = $request->code;
              $s->symbol = $request->symbol;
              $s->school_id = Auth::user()->school_id;
              $s->save();
              Toastr::success('Operation successful', 'Success');
              return redirect('manage-currency');
  
              $currencies = SmCurrency::whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
              return view('backEnd.systemSettings.manageCurrency', compact('currencies'));
          } catch (\Exception $e) {
              return $e->getMessage();
          }
      }
  
      public function storeCurrencyUpdate(SmCurrencyRequest $request)
      {
  
          try {
              $s = SmCurrency::findOrfail($request->id);
              $s->name = $request->name;
              $s->code = $request->code;
              $s->symbol = $request->symbol;
              $s->school_id = Auth::user()->school_id;
              $s->update();
  
              Toastr::success('Operation successful', 'Success');
              return redirect('manage-currency');
  
              $currencies = SmCurrency::whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
              return view('backEnd.systemSettings.manageCurrency', compact('currencies'));
          } catch (\Exception $e) {
              Toastr::error('Operation Failed', 'Failed');
              return redirect('manage-currency');
          }
      }
  
      public function manageCurrencyEdit($id)
      {
  
          try {
              $currencies = SmCurrency::whereOr(['school_id', Auth::user()->school_id], ['school_id', 1])->get();
              $editData = SmCurrency::where('id', $id)->first();
  
              return view('backEnd.systemSettings.manageCurrency', compact('editData', 'currencies'));
          } catch (\Exception $e) {
              Toastr::error('Operation Failed', 'Failed');
              return redirect('manage-currency');
          }
      }
  
      public function manageCurrencyDelete($id)
      {
          try {
              $current_currency = SmGeneralSettings::where('school_id', Auth::user()->school_id)->where('currency', @schoolConfig()->currency)->where('currency_symbol', @schoolConfig()->currency_symbol)->first();
              $del_currency = SmCurrency::findOrfail($id);
  
              if (!empty($current_currency) && $current_currency->currency == $del_currency->code && $current_currency->currency_symbol == $del_currency->symbol) {
                  Toastr::warning('You cannot delete current currency', 'Warning');
                  return redirect()->back();
              } else {
                  $currency = SmCurrency::findOrfail($id);
                  $currency->delete();
                  Toastr::success('Operation successful', 'Success');
                  return redirect()->back();
              }
          } catch (\Exception $e) {
  
              Toastr::error('Operation Failed', 'Failed');
              return redirect()->back();
          }
      }
  
      public function systemDestroyedByAuthorized()
      {
          try {
              return view('backEnd.systemSettings.manageCurrency', compact('editData', 'currencies'));
          } catch (\Exception $e) {
  
              Toastr::error('Operation Failed', 'Failed');
              return redirect()->back();
          }
      }
}
