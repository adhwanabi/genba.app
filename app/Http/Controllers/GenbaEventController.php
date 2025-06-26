<?php

namespace App\Http\Controllers;

use App\Models\GenbaEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenbaEventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('genba-event.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('genba-event.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:a,b,c',
            'pic' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $event = GenbaEvent::create($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Event berhasil ditambahkan',
                'data' => $event
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get events for calendar
     */
    public function calendarEvents()
    {
        $events = GenbaEvent::all()->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->event_name,
                'start' => $event->start_date,
                'end' => $event->end_date,
                'extendedProps' => [
                    'priority' => $event->priority,
                    'location' => $event->location,
                    'pic' => $event->pic,
                    'description' => $event->description
                ],
                'className' => 'event-' . $event->priority,
            ];
        });

        return response()->json($events);
    }

    /**
     * Get paginated list of events for table
     */
    public function eventList(Request $request)
    {
        $search = $request->input('search', '');
        $perPage = 10;
        
        $query = GenbaEvent::query()
            ->orderBy('start_date', 'asc');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('event_name', 'like', "%$search%")
                  ->orWhere('location', 'like', "%$search%")
                  ->orWhere('pic', 'like', "%$search%");
            });
        }

        $events = $query->paginate($perPage);

        return response()->json($events);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GenbaEvent $genbaEvent)
    {
        return response()->json([
            'status' => 'success',
            'data' => $genbaEvent
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GenbaEvent $genbaEvent)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'priority' => 'required|in:a,b,c',
            'pic' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $genbaEvent->update($request->all());

            return response()->json([
                'status' => 'success',
                'message' => 'Event berhasil diperbarui',
                'data' => $genbaEvent
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal memperbarui event',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GenbaEvent $genbaEvent)
    {
        try {
            $genbaEvent->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Event berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus event',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}