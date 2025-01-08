<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // show company
    public function show(Company $company)
    {
        $company = Company::find(1);
        return view("pages.company.show", compact('company'));
    }

    // show edit company
    public function edit(Company $company)
    {
        return view('pages.company.edit', compact('company'));
    }

    // update company
    public function update(Request $request, Company $company)
    {
        $validated = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
            'radius_km' => 'required',
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $company->update($validated);

        return redirect()->route('companies.show', $company->id)->with('success', 'Company Updated Successfully');
    }
}
