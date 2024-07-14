<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Product;
use Illuminate\Http\Request;

class FormController extends Controller
{
    public function index(){
        $forms = Form::with('product')->get()->groupBy('date');

        $summary = $forms->map(function ($group) {
            $totalForms = $group->count();
            $totalPrice = $group->reduce(function ($carry, $form) {
                $price = $form->product->price * $form->quantity - $form->discount;
                return $carry + $price;
            }, 0);

            return [
                'total_forms' => $totalForms,
                'total_price' => $totalPrice
            ];
        });

        return view('form.index', compact('summary', 'forms'));
    }
    public function info($date)
    {
        $forms = Form::whereDate('date', $date)->with('product')->get();
        return view('form.info', compact('forms', 'date'));
    }

    public function create()
    {
        $products = Product::all();
        return view('form.add', compact('products'));
    }

    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'status' => 'required|in:cash,loan',
            'quantity' => 'required|numeric|min:1',
            'discount' => 'nullable|numeric|min:0',
            'remark' => 'nullable|string|max:255',
        ]);

        // Create a new form entry
        $form = new Form();
        $form->date = $validatedData['date'];
        $form->product_id = $validatedData['product_id'];
        $form->status = $validatedData['status'];
        $form->quantity = $validatedData['quantity'];
        $form->discount = $validatedData['discount'];
        $form->remark = $validatedData['remark'];
        $form->save();

        // Update product quantity
        $product = Product::findOrFail($validatedData['product_id']);
        $product->quantity -= $validatedData['quantity'];
        $product->save();

        // Redirect back or to a success page
        return redirect()->route('forms.index')->with('message', 'Form created successfully');
    }

    public function edit(Form $form)
    {
        $products = Product::all();
        return view('form.edit', compact('form', 'products'));
    }

    public function update(Request $request, Form $form)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'status' => 'required|in:cash,loan',
            'quantity' => 'required|numeric|min:1',
            'discount' => 'nullable|numeric|min:0',
            'remark' => 'nullable|string|max:255',
        ]);

        // Update the form entry
        $form->date = $validatedData['date'];
        $form->product_id = $validatedData['product_id'];
        $form->status = $validatedData['status'];
        $form->quantity = $validatedData['quantity'];
        $form->discount = $validatedData['discount'];
        $form->remark = $validatedData['remark'];
        $form->save();

        // Update product quantity
        $product = Product::findOrFail($validatedData['product_id']);
        $product->quantity -= $validatedData['quantity'];
        $product->save();

        // Redirect back or to a success page
        return redirect()->route('forms.index')->with('message', 'Form updated successfully');
    }

    public function destroy(Form $form)
    {
        $form->delete();

        return redirect()->route('forms.index')->with('message', 'Form deleted successfully');
    }
}
