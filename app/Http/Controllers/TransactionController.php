<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApproveTransactionRequest;
use App\Http\Requests\CreateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionType;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Transaction::with('owner:id,name')
            ->with('approver:id,name')
            ->when($request->from && $request->to, function ($q) use ($request) {
                $q->whereBetween('transaction_date', [$request->from, $request->to]);
            })
            ->when($request->type, function ($q) use ($request) {
                $q->where('transaction_type_id', $request->type);
            })
            ->when(!$request->from && !$request->to, function ($q) use ($request) {
                $q->whereBetween('transaction_date', [
                    request('from', now()->subDay(30)->toDateString()),
                    request('to', now()->toDateString())
                ]);
            })
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTransactionRequest $request)
    {
        $transaction = new Transaction($request->all());
        $transaction->category()->associate(Category::find($request->get('category_id')));
        $transaction->type()->associate(TransactionType::find($request->get('transaction_type_id')));
        $transaction->save();

        return response()->json(['message' => 'Transaction created successfully!'], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        return response()->json($transaction, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTransactionRequest $request, Transaction $transaction)
    {
        $transaction->fill($request->all());
        $transaction->save();
        return response()->json(['message' => 'Transaction updated successfully!'], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ApproveTransactionRequest  $request
     * @param  Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function approve(ApproveTransactionRequest $request, Transaction $transaction)
    {
        $transaction->approver()->associate(auth()->user());
        $transaction->approved_at = now()->toDateTimeString();
        $transaction->save();
        return response()->json(['message' => 'Transaction updated successfully!'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
