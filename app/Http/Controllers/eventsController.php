<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\events;

class eventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $eventos = events::all();

        response()->json(['eventos'=>$eventos], 201,
             ["Content-Type"=>"application/json"]);
 
         return response()-> view('events.index', compact('eventos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('events.create');
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
        $storeData = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
            'fechaInicio' => 'required|max:255|date',
            'fechaFin' => 'required|max:255|date',
        ]);

        $evento = events::create($storeData);
        
        // return response()->json(['mensaje'=>'creación de evento exitoso'], 201);
        return redirect()->route('events.index')->with('success', 'Evento actualizado con éxito');
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
            //bring 
            if (isset($id)) {
                $ev = DB::table('events')->find($id);
                return response()->json(['evento'=>$ev]);
            }
            else {
                return response()->json(['mensaje'=>'No se encontró el evento']);
    
            }
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
        $eventos = Event::findOrFail($id);
        return view('events.edit', compact('eventos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
           //
           $updateData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'required|max:255',
            'fechainicio' => 'required|max:255|date',
            'fechafin' => 'required|max:255|date',
        ]);
        Event::whereId($id)->update($updateData);
        return redirect()->route('events.index')->with('success', 'Evento actualizado con éxito');
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
        $ev = events::find($id);
        
        $ev->delete();
        return redirect('/events')->with('completed', 'asasd');   
    }
}