<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use Illuminate\Http\Request;

class TimesheetController extends Controller
{
    // Display a listing of the timesheets.
    public function index(Request $request)
    {
        // $timesheets = Timesheet::all();
        // return response()->json($timesheets);

        // Start the query
        $query = Timesheet::with([
            'user' => function ($query) {
                $query->select('id', 'name');
            },
            'job' => function ($query) {
                $query->select('id', 'name');
            }
        ])->orderBy('id', 'desc');

        // Check if a keyword was provided
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%");
            });
        }

        // Check if a status was provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Validate and set the limit parameter, converting it to an integer
        $limit = intval($request->input('limit', 10)); // Default to 10 if limit is not valid or provided

        // Validate and set the page parameter, converting it to an integer
        $page = intval($request->input('page', 1)); // Default to page 1 if page is not valid or provided
        if ($page <= 0) {
            $page = 1; // Ensure that page is positive
        }

        // Handle 'show all' case when limit is set to -1
        if ($limit == -1) {
            $timesheets = $query->get(); // Fetch all timesheets matching the criteria
            $total = $timesheets->count(); // Count the timesheets

            // Prepare the response for 'all' data
            $response = [
                'data' => $timesheets,
                'total' => $total,
                'limit' => -1,
                'currentPage' => 1,
                'lastPage' => 1,
            ];
        } else {
            // Ensure that limit is positive for regular pagination
            if ($limit <= 0) {
                $limit = 10;
            }

            // Apply pagination if limit is not -1
            $timesheets = $query->paginate($limit, ['*'], 'page', $page);
            $total = $timesheets->total(); // This ensures total counts all matches, not just the paginated subset

            // Prepare the response with pagination
            $response = [
                'data' => $timesheets->items(),
                'total' => $total,
                'limit' => $limit,
                'currentPage' => $timesheets->currentPage(),
                'lastPage' => $timesheets->lastPage(),
            ];
        }

        return response()->json($response);
    }


    /**
     * Store a newly created timesheet in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'revenue' => 'nullable|numeric',
            'material_cost' => 'nullable|numeric',
            'status' => 'nullable|integer',
        ]);

        // Create and save the new timesheet
        $timesheet = Timesheet::create([
            'name' => $validatedData['name'],
            'detail' => $validatedData['detail'],
            'revenue' => $validatedData['revenue'],
            'material_cost' => $validatedData['material_cost'],
            'status' => $validatedData['status'] ?? null,
        ]);

        return response()->json(['message' => 'Job created successfully', 'timesheet' => $timesheet], 201);
    }

    // Display the specified timesheet.
    // public function show(Job $timesheet)
    // {
    //     return response()->json($timesheet);
    // }

    /**
     * Update the specified timesheet in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::find($id);
        if (!$timesheet) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'detail' => 'nullable|string',
            'revenue' => 'nullable|numeric',
            'material_cost' => 'nullable|numeric',
            'status' => 'nullable|integer',
        ]);

        $timesheet->update($validatedData);

        return response()->json(['message' => 'Job updated successfully', 'timesheet' => $timesheet]);
    }



    /**
     * Activate the specified timesheet in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $timesheet->update(['status' => 1]);

        return response()->json(['message' => 'Job activated successfully'], 200);
    }



    /**
     * Deactivate the specified timesheet in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $timesheet->update(['status' => 2]);

        return response()->json(['message' => 'Job deactivated successfully'], 200);
    }


    /**
     * Remove the specified timesheet from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $timesheet = Timesheet::find($id);

        if (!$timesheet) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $timesheet->delete();

        return response()->json(['message' => 'Job deleted successfully'], 200);
    }
}
