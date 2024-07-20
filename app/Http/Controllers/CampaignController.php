<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CampaignController extends Controller
{
    public function store(Request $request)
     {
    $request->validate([
        'campaign_name' => 'required|string|max:255',
        'contacts_csv' => 'required|file|mimes:csv,txt',
    ]);

    $csvData = array_map('str_getcsv', file($request->file('contacts_csv')->getRealPath()));

    foreach ($csvData as $row) {
        if (!isset($row[0]) || !isset($row[1]) || !filter_var($row[1], FILTER_VALIDATE_EMAIL)) {
            return back()->withErrors('Invalid CSV data.');
        }
    }

    $csvPath = $request->file('contacts_csv')->store('csvs');

    $campaign = Campaign::create([
        'name' => $request->input('campaign_name'),
        'csv_path' => $csvPath,
        'user_id' => auth()->id(),
    ]);

    ProcessCampaign::dispatch($campaign);

    return response()->json(['message' => 'Campaign created successfully']);
  }

}
