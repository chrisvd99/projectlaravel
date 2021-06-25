<?php
  namespace App\Http\Controllers;

  use App\Http\Controllers\Controller;
  use App\Dagmeting;
  use App\Maanden;
  use App\Nieuwsbrief;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Validator;
  use Illuminate\Support\Facades\Log;

  class TemperatuurController extends Controller
  {
    public function index()
    {
      $metingen = Dagmeting::where('maandnr', '1')->orderBy('dagnr', 'asc')->get();
      $maanden = Maanden::select('*')->get();
      print($maanden[1]);
      return view('overzicht', array('maand'=>'1', 'metingen'=>$metingen, 'maanden'=>$maanden, 'eenheid'=>'C')); 
    }

    public function detail(Request $request)
    {
      //Validatie
      $validator = Validator::make($request->all(), [
        'maand'=>'required|min:1|max:12|integer'
      ]);
      if($validator->fails()) {
        Log:error ('Meegegeven maand is geen maandnummer (1-12): ', $request->all());
        return redirect('/');
      }

      $maand = $request->input('maand','1');
      $cf = $request->input("eenheid",'C');
      $metingen = Dagmeting::where('maandnr', $maand)->orderBy('dagnr', 'asc')->get();

      if ($cf == "F") {
        $metingen->map(function ($item, $key) {
          $item->minimum = (($item->minimum*9)/5)+32;
          $item->maximum = (($item->maximum*9)/5)+32;
          return $item;
        });
      }

      $maanden = Maanden::select('*')->get();
      
      return view('overzicht', array('maand'=>$maand, 'metingen'=>$metingen, 'maanden'=>$maanden, 'eenheid'=>$cf));
    }

    public function contact()
    {
      return view('contact');
    }

    public function nieuwsbrief(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'emailadres'=>'required|email'
      ]);
      if ($validator->fails()) {
        Log:error ('Meegegeven email is geen geldig emailadres: ', $request->all());
        return redirect('/');
      }
      $nieuwsbrief = new Nieuwsbrief();
      $nieuwsbrief->mailadres = $request->input('emailadres');
      $nieuwsbrief->save();
      return view('bedankt');
    }
  }