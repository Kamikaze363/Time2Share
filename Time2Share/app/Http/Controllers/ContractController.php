<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractController extends Controller
{
    public function create($itemId)
    {
        $item = Item::findOrFail($itemId);
        return view('contracts.create', compact('item'));
    }

    public function store(Request $request, $itemId)
    {
        $validatedData = $request->validate([
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
        ]);

        $item = Item::findOrFail($itemId);

        $contract = new Contract([
            'item_id' => $item->id,
            'lender_id' => $item->owner_id,
            'borrower_id' => Auth::id(),
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'is_accepted' => false, // default value
        ]);

        $contract->save();

        return redirect()->route('dashboard', $item->id)->with('success', 'Borrow request created successfully!');
    }

    public function accept(Request $request, Contract $contract)
    {
        // Check if the current user is the lender (owner) of the item
        if ($contract->lender_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $contract->is_accepted = true;
        $contract->save();

        return redirect()->route('pendingRequests')->with('success', 'Borrow request accepted');
    }

    public function reject(Request $request, Contract $contract)
    {
        // Check if the current user is the lender (owner) of the item
        if ($contract->lender_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $contract->delete();

        return redirect()->route('pendingRequests')->with('success', 'Borrow request rejected');
    }

    public function return(Request $request, Contract $contract)
    {
        // Check if the current user is the lender (owner) of the item
        if ($contract->borrower_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $contract->delete();

        return redirect()->route('borrowedItems')->with('success', 'Item returned successfully!');
    }
}
