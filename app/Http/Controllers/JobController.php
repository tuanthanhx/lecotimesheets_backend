<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // Display a listing of the jobs.
    public function index(Request $request)
    {
        // $jobs = Job::all();
        // return response()->json($jobs);

        // Start the query
        $query = Job::orderBy('id', 'desc');

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
            $jobs = $query->get(); // Fetch all jobs matching the criteria
            $total = $jobs->count(); // Count the jobs

            // Prepare the response for 'all' data
            $response = [
                'data' => $jobs,
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
            $jobs = $query->paginate($limit, ['*'], 'page', $page);
            $total = $jobs->total(); // This ensures total counts all matches, not just the paginated subset

            // Prepare the response with pagination
            $response = [
                'data' => $jobs->items(),
                'total' => $total,
                'limit' => $limit,
                'currentPage' => $jobs->currentPage(),
                'lastPage' => $jobs->lastPage(),
            ];
        }

        return response()->json($response);
    }




    // Show the form for creating a new job.
    public function create()
    {
        // Generally, the create method isn’t used for APIs, as the form handling is on the client side.
    }

    // Store a newly created job in storage.
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|integer',
            'revenue' => 'required|numeric',
            'material_cost' => 'required|numeric',
            'detail' => 'required|string',
            'date' => 'nullable|date',
        ]);

        $job = Job::create($validated);
        return response()->json($job, 201);
    }

    // Display the specified job.
    public function show(Job $job)
    {
        return response()->json($job);
    }

    // Show the form for editing the specified job.
    public function edit(Job $job)
    {
        // Similarly, the edit method is not typically used in APIs.
    }

    // Update the specified job in storage.
    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'name' => 'string|max:255',
            'status' => 'integer',
            'revenue' => 'numeric',
            'material_cost' => 'numeric',
            'detail' => 'string',
            'date' => 'date',
        ]);

        $job->update($validated);
        return response()->json($job);
    }





    /**
     * Activate the specified job in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $job->update(['status' => 1]);

        return response()->json(['message' => 'Job activated successfully'], 200);
    }



    /**
     * Deactivate the specified job in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $job->update(['status' => 2]);

        return response()->json(['message' => 'Job deactivated successfully'], 200);
    }


    /**
     * Remove the specified job from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $job = Job::find($id);

        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $job->delete();

        return response()->json(['message' => 'Job deleted successfully'], 200);
    }
}
