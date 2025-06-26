<?php

namespace App\Http\Controllers;

use App\Models\FormAnswerModel;
use App\Models\GenbaEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GenbaController extends Controller
{
    public function index()
    {
        return view('ori_app.form_temuan');
    }
    public function dashboard()
    {
        $temuan = FormAnswerModel::all();
        $sum_temuan = FormAnswerModel::count();
        $sum_none_temuan = FormAnswerModel::where('status', 'none')->count();
        $sum_ongoing_temuan = FormAnswerModel::where('status', 'on going')->count();
        $sum_done_temuan = FormAnswerModel::where('status', 'done')->count();

        // Get data for priority line chart (grouped by month)
        $priorityData = $this->getPriorityTrendData();

        // Get data for donut chart (priority distribution)
        $donutData = $this->getPriorityDistributionData();

        return view('ori_app.dashboard_ehs', compact(
            'temuan',
            'sum_temuan',
            'sum_none_temuan',
            'sum_ongoing_temuan',
            'sum_done_temuan',
            'priorityData',
            'donutData',
        ));
    }

    public function addGenba(){
        return view('ori_app.add_event_genba');
    }

    private function getPriorityTrendData()
    {
        // Get all months that have data
        $months = FormAnswerModel::selectRaw('MONTH(created_at) as month, MONTHNAME(created_at) as month_name')
            ->groupBy('month', 'month_name')
            ->orderBy('month')
            ->get();

        // Initialize data structure
        $labels = [];
        $criticalData = [];
        $highData = [];
        $mediumData = [];
        $lowData = [];

        foreach ($months as $month) {
            $labels[] = $month->month_name;

            $criticalData[] = FormAnswerModel::where('tingkat_prioritas', 'a')
                ->whereMonth('created_at', $month->month)
                ->count();

            $highData[] = FormAnswerModel::where('tingkat_prioritas', 'b')
                ->whereMonth('created_at', $month->month)
                ->count();

            $mediumData[] = FormAnswerModel::where('tingkat_prioritas', 'c')
                ->whereMonth('created_at', $month->month)
                ->count();
        }

        return [
            'labels' => $labels,
            'datasets' => [
                'critical' => $criticalData,
                'high' => $highData,
                'medium' => $mediumData,
            ]
        ];
    }

    private function getPriorityDistributionData()
    {
        $critical = FormAnswerModel::where('tingkat_prioritas', 'a')->count();
        $high = FormAnswerModel::where('tingkat_prioritas', 'b')->count();
        $medium = FormAnswerModel::where('tingkat_prioritas', 'c')->count();

        return [
            'labels' => ['Grade A', 'Grade B', 'Grade C'],
            'data' => [$critical, $high, $medium,]
        ];
    }
    public function bod()
    {
        $tgl = GenbaEvent::selectRaw('DATE(start_date) as date_only')
            ->distinct()
            ->pluck('date_only')
            ->toArray();
        return view('ori_app.bod',compact('tgl'));
    }
    public function bodData(Request $request)
    {
        $data = FormAnswerModel::all();
        $perPage = 5;
        $page = $request->input('page', 1);
        $paginated = FormAnswerModel::paginate($perPage, ['*'], 'page', $page);
        $search = $request->input('search');
        if ($search) {
            $paginated = FormAnswerModel::whereDate('created_at', $search)
                ->paginate($perPage, ['*'], 'page', $page);
        }
        return response()->json($paginated);
    }
    // public function bodRepair()
    // {
    //     return view('ori_app.bod_repair');
    // }
    // public function bodRepairData(Request $request)
    // {
    //     $perPage = 5;
    //     $page = $request->input('page', 1);
    //     $paginated = FormAnswerModel::where('status', 'done')->paginate($perPage, ['*'], 'page', $page);
    //     return response()->json($paginated);
    // }
    public function update(Request $request)
    {
        try {
            // Validate the request data
            $validated = $request->validate([
                'id' => 'required|string|max:255',
                'area' => 'sometimes|required|string|max:255',
                'detail_area' => 'sometimes|required|string|max:255',
                'potensi_bahaya' => 'sometimes|required|string|max:255',
                'deskripsi' => 'sometimes|required|string',
                'masukan' => 'sometimes|required|string|max:255',
                'tingkat_prioritas' => 'sometimes|required|in:a,b,c',
                'pic' => 'sometimes|required|string|max:255',
                'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Find the record to update
            $formAnswer = \App\Models\FormAnswerModel::findOrFail($validated['id']);

            // Handle image upload if present
            if ($request->hasFile('image')) {
                if ($formAnswer->img_path && Storage::disk('public')->exists($formAnswer->img_path)) {
                    Storage::disk('public')->delete($formAnswer->img_path);
                }
                $imagePath = $request->file('image')->store('inspection_images', 'public');
                $validated['img_path'] = $imagePath;
            }

            $formAnswer->update($validated);

            return redirect()->back()->with('success', 'Inspection updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error updating inspection: ' . $e->getMessage()]);
        }
    }
    public function form(Request $request)
    {
        try {
            $request->validate([
                'area' => 'required|string|max:255',
                'detail_area' => 'required|string|max:255',
                'img_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'deskripsi' => 'required|string|max:1000',
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
            $formAnswer->id = 'FORM-' . date('YmdHis') . '-' . $request->input('pic');
            $formAnswer->area = $request->input('area');
            $formAnswer->detail_area = $request->input('detail_area');
            $formAnswer->img_path = $path;
            $formAnswer->kategori_temuan = $request->input('kategori_temuan');
            $formAnswer->deskripsi = $request->input('deskripsi');
            $formAnswer->potensi_bahaya = $request->input('potensi_bahaya');
            $formAnswer->masukan = $request->input('masukan');
            $formAnswer->tingkat_prioritas = $request->input('tingkat_prioritas');
            $formAnswer->pic = $request->input('pic');
            $formAnswer->save();

            // Check if logged in as npk ehs
            $user = auth()->user();
            if ($user && isset($user->npk) && strtolower($user->npk) === 'ehs') {
                return redirect()->route('bod')->with('success', 'Form submitted successfully!');
            } else {
                return redirect()->back()->with('success', 'Form submitted successfully!');
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while loading the form.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function repair($id)
    {
        $data = FormAnswerModel::findOrFail($id);
        return view('ori_app.form_repair', compact('data'));
    }
    public function repairUpdate(Request $request, $id)
    {
        try {
            $request->validate([
            'img_path_repair' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi_repair' => 'required|string|max:1000',
            ]);

            $formAnswer = FormAnswerModel::findOrFail($id);

            // Handle file upload
            if ($request->hasFile('img_path_repair')) {
            if ($formAnswer->img_path_repair && Storage::disk('public')->exists($formAnswer->img_path_repair)) {
                Storage::disk('public')->delete($formAnswer->img_path_repair);
            }
            $imagePath = $request->file('img_path_repair')->store('repair_images', 'public');
            $formAnswer->img_path_repair = $imagePath;
            }

            $formAnswer->deskripsi_repair = $request->input('deskripsi_repair');
            $formAnswer->status = 'done'; // Update status to done
            $formAnswer->save();

            return redirect()->route('bod')->with('success', 'Repair updated successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error updating repair: ' . $e->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $data = FormAnswerModel::findOrFail($id);
            if ($data->img_path && Storage::disk('public')->exists($data->img_path)) {
                Storage::disk('public')->delete($data->img_path);
            }
            $data->delete();
            return redirect()->back()->with('success', 'Inspection deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error deleting inspection: ' . $e->getMessage()]);
        }
    }
}
