<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenbaController extends Controller
{
    public function index(){
        return view('ori_app.form_temuan');
    }
    public function bod(){
        $data = \App\Models\FormAnswerModel::all();
        return view('ori_app.bod', compact('data'));
    }
    public function form(Request $request){
        try {
            $request->validate([
                'area' => 'required|string|max:255',
                'detail_area' => 'required|string|max:255',
                'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'kategori_temuan' => 'required|string|max:255',
                'deskripsi' => 'required|string|max:1000',
                'potensi_bahaya' => 'required|string|max:1000',
                'masukan' => 'required|string|max:1000',
                'tingkat_prioritas' => 'required|string|max:50',
            ]);
            // Handle file upload
            if ($request->hasFile('img_path')) {
                $file = $request->file('img_path');
                $path = $file->store('uploads', 'public');
            } else {
                return redirect()->back()->withErrors(['img_path' => 'Image is required.']);
            }
            // Create a new form answer record
            $formAnswer = new \App\Models\FormAnswerModel();
            $formAnswer->id = 'FORM-' . date('YmdHis') . '-' . auth()->user()->name;
            $formAnswer->area = $request->input('area');
            $formAnswer->detail_area = $request->input('detail_area');
            $formAnswer->img_path = $path;
            $formAnswer->kategori_temuan = $request->input('kategori_temuan');
            $formAnswer->deskripsi = $request->input('deskripsi');
            $formAnswer->potensi_bahaya = $request->input('potensi_bahaya');
            $formAnswer->masukan = $request->input('masukan');
            $formAnswer->tingkat_prioritas = $request->input('tingkat_prioritas');
            $formAnswer->pic = auth()->user()->name;
            $formAnswer->save();
            return redirect()->route('bod')->with('success', 'Form submitted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('form')->withErrors(['error' => 'An error occurred while loading the form.']);
        }
    }
}
