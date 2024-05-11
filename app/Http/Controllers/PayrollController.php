<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\Timesheet;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    // Display a listing of the payrolls.
    public function index(Request $request)
    {

        // Start the query
        $query = Payroll::with(['timesheets', 'timesheets.job' => function ($query) {
            $query->select('id', 'name');
        }])->orderBy('id', 'desc');

        // Check if a user was provided
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
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
            $payrolls = $query->get(); // Fetch all payrolls matching the criteria
            $total = $payrolls->count(); // Count the payrolls

            // Prepare the response for 'all' data
            $response = [
                'data' => $payrolls,
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
            $payrolls = $query->paginate($limit, ['*'], 'page', $page);
            $total = $payrolls->total(); // This ensures total counts all matches, not just the paginated subset

            // Prepare the response with pagination
            $response = [
                'data' => $payrolls->items(),
                'total' => $total,
                'limit' => $limit,
                'currentPage' => $payrolls->currentPage(),
                'lastPage' => $payrolls->lastPage(),
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

        $authUser = auth()->user();

        // Validate incoming request data
        $rules = [
            'user_id' => 'required|integer',
            'amount' => 'required|numeric',
            'time_worked' => 'required|numeric',
        ];

        $validatedData = $request->validate($rules);

        // Prepare the data for the new item
        $data = [
            'user_id' => $validatedData['user_id'],
            'amount' => $validatedData['amount'] ?? null,
            'time_worked' => $validatedData['time_worked'] ?? null,
        ];

        // Create and save the new payroll
        $payroll = Payroll::create($data);

        Timesheet::where('user_id', $validatedData['user_id'])
            ->where('status', 2)
            ->update([
                'payroll_id' => $payroll->id,
                'status' => 3,
            ]);

        return response()->json(['message' => 'Payroll created successfully', 'payroll' => $payroll], 201);
    }
}
