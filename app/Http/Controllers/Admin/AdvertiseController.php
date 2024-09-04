<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertise;
use Illuminate\Http\Request;

class AdvertiseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $advertises = Advertise::orderBy('id','desc')->get();
        return view('admin.advertise.index', compact('advertises'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.advertise.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "company_name" => "required|max:255",
            "phone" => "required|digits:10",
            "link" => "required",
            "image" => "required",
          ]);

            $advertise = new Advertise();
            $advertise->company_name = $request->company_name;
            $advertise->phone = $request->phone;
            $advertise->link = $request->link;

            if ($request->hasFile('image')){
                $file = $request->image;
                $fileName = time().'.' . $file->getClientOriginalExtension();
                $file->move('images', $fileName);
                $advertise->image = "images/" . $fileName;
            }
            $advertise->save();
            toast('Record saved successfully!','success');
            return redirect()->route('advertise.index');
    }

    /**
     * Display the specified resource.
     */


    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $advertise = Advertise::find($id);
        return view('admin.advertise.edit', compact('advertise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            "company_name" => "required|max:255",
            "phone" => "required|digits:10",
            "link" => "required",
            "status" => "required",
          ]);

            $advertise = Advertise::find($id);
            $advertise->company_name = $request->company_name;
            $advertise->phone = $request->phone;
            $advertise->link = $request->link;
            $advertise->status = $request->status;

            if ($request->hasFile('image')){
                $file = $request->image;
                $fileName = time().'.' . $file->getClientOriginalExtension();
                $file->move('images', $fileName);
                $advertise->image = "images/" . $fileName;
            }
            $advertise->update();
            // return redirect()->back();
            toast('Record updated successfully!','success');
            return redirect()->route('advertise.edit', $advertise->id);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $advertise = Advertise::find($id);
        unlink(public_path($advertise->image));
        $advertise->delete();
        toast('Record deleted successfully!','success');
        return redirect()->back();
    }
}
