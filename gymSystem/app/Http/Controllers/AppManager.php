<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Customer;
use App\Models\Trainer;
use App\Models\Equipment;
use App\Models\Plan;
use App\Models\Sessions;
use App\Models\Pay_Transaction;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class AppManager extends Controller {
    function login() {
        if (Auth::check()) {
            return redirect(route('homepage'));
        }
        return view('login');
    }

    function registration() {
        if (Auth::check()) {
            return redirect(route('homepage'));
        }
        return view('registration');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    function loginPost(Request $request) {
        $credentials  = $request->only('id', 'password');
        if (Auth::attempt($credentials)) {
            $admin = Auth::user();
            session(['name' => $admin->name]);
            $customers = Customer::all();
            return view('.includes.Customers.customersview', ['customers' => $customers]);
        }
        return redirect(route('login'))->with('error', 'Login details are not valid.');
    }

    function registrationPost(Request $request) {
        $validator = Validator::make($request->all(), [
            'id' => 'required|unique:Admin,id|max:10',
            'password' => 'required|min:5|confirmed',
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return redirect(route('registration'))->with('error', $errorMessage);
        }

        $data['id'] = $request->id;
        $data['password'] = Hash::make($request->password);
        $data['name'] = $request->name;
        $admin = Admin::create($data);
        if(!$admin){
            return redirect(route('registration'))->with('error', 'Registration failed, try again.');
        }
        return redirect(route('login'))->with('success', 'Registration successful. Login to access the application.');
    }

    function logout() {
        Session::flush();
        Auth::logout();
        return redirect(route('login'));
    }

    public function showHomepage()
    {
        $customers = Customer::all();
        return view('.includes.Customers.customersview', ['customers' => $customers]);
    }

    //Plans
    public function plansView()
    {

        $plans = Plan::all();
        return view('.includes.Plans.plansview', ['plans' => $plans]);
    }

    public function createPlan()
    {
        if (Plan::count() === 0) {
        $id = 1;
        } else {
            $lastPlan = Plan::latest('id')->first();
            $id = $lastPlan->id + 1;
        }
        $p_id = 'PID' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('.includes.Plans.planform', ['p_id' => $p_id]);
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'p_id' => 'required|unique:Plans,p_id',
            'name' => 'required|max:50',
            'period' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        
        $values = [
            'id' => Plan::max('id') + 1,
            'p_id' => $request->input('p_id'),
            'name' => $request->input('name'),
            'period' => $request->input('period'),
            'price' => $request->input('price'),
        ];
        
        DB::table('Plans')->insert([$values]);

        return redirect()->route('plans')->with('success', 'Plan created successfully.');
    }

    public function editPlan($id)
    {
        $plan = Plan::findOrFail($id);

        return view('.includes.Plans.editplan', ['plan' => $plan]);
    }

    public function updatePlan(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'period' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $plan = Plan::findOrFail($id);

        $plan->update([
            'name' => $request->input('name'),
            'period' => $request->input('period'),
            'price' => $request->input('price'),
        ]);

        return redirect()->route('plans')->with('success', 'Plan updated successfully!');
    }

    public function deletePlan($id)
    {
        $plan = Plan::findOrFail($id);
        $customers = Customer::where('p_id', $plan->p_id)->get();
        foreach ($customers as $customer) {
            $customer->update([
                'p_id' => null,
                'p_start' => null,
                'p_end' => null,
            ]);
        }
        $plan->delete();

        return redirect()->route('plans')->with('success', 'Plan deleted successfully!');
    }

    //Customers
    public function customersView() 
    {
        $customers = Customer::all();
        return view('.includes.Customers.customersview', ['customers' => $customers]);
    }

    public function createCustomer()
    {
        if (Customer::count() === 0) {
        $id = 1;
        } else {
            $lastCustomer = Customer::latest('id')->first();
            $id = $lastCustomer->id + 1;
        }
        $c_id = 'CID' . str_pad($id, 3, '0', STR_PAD_LEFT);
        $plans = Plan::all();
        return view('.includes.Customers.customerform', ['c_id' => $c_id, 'plans' => $plans]);
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'required|max:50',
            'mobile' => 'required|max:15',
            'p_id' => 'required|exists:plans,p_id', 
            'p_start' => 'required|date',
        ]);
    
        $dob = new \DateTime($request->input('dob'));
        $currentDate = new \DateTime(now());
        $age = $dob->diff($currentDate)->y;

        $plan = Plan::where('p_id', $request->input('p_id'))->first();
        $p_start = Carbon::parse($request->input('p_start'));
        $p_end = $p_start->copy()->addDays($plan->period);
        
        $values = [
            'id' => Customer::max('id') + 1,
            'c_id' => $request->input('c_id'),
            'name' => $request->input('name'),
            'dob' => $request->input('dob'),
            'age' => $age,
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'mobile' => $request->input('mobile'),
            'p_id' => $request->input('p_id'),
            'p_start' => $request->input('p_start'),
            'p_end' => $p_end->toDateString(),
        ];
    
        DB::table('Customers')->insert([$values]);

        return redirect()->route('customers')->with('success', 'Customer created successfully.');
    } 

    public function editCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $plans = Plan::all();

        return view('.includes.Customers.editcustomer', ['customer' => $customer, 'plans' => $plans]);
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'address' => 'required|max:50',
            'mobile' => 'required|max:15',
            'p_id' => 'required|exists:plans,p_id', 
            'p_start' => 'required|date',
        ]);

        $customer = Customer::findOrFail($id);

        $dob = new \DateTime($request->input('dob'));
        $currentDate = new \DateTime(now());
        $age = $dob->diff($currentDate)->y;

        $plan = Plan::where('p_id', $request->input('p_id'))->first();
        $p_start = Carbon::parse($request->input('p_start'));
        $p_end = $p_start->copy()->addDays($plan->period);

        $customer->update([
            'name' => $request->input('name'),
            'dob' => $request->input('dob'),
            'gender' => $request->input('gender'),
            'address' => $request->input('address'),
            'mobile' => $request->input('mobile'),
            'p_id' => $request->input('p_id'),
            'p_start' => $request->input('p_start'),
            'p_end' => $p_end->toDateString(),
        ]);

        return redirect()->route('customers')->with('success', 'Customer updated successfully!');
    }

    public function deleteCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->route('customers')->with('success', 'Customer deleted successfully!');
    }

    public function equipmentsView()
    {
        return view('.includes.Equipments.equipmentsview');
    }

    public function createEquipment()
    {
        if (Equipment::count() === 0) {
        $id = 1;
        } else {
            $lastEquipment = Equipment::latest('id')->first();
            $id = $lastEquipment->id + 1;
        }
        $e_id = 'EQUIPID' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('.includes.Equipments.equipmentform', ['e_id' => $e_id]);
    }

    public function storeEquipment(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'brand' => 'required|max:50',
            'serial' => 'required|unique:Equipments,serial',
            'price' => 'required|numeric',
            'purchased_date' => 'required|date',
        ]);
        
        $values = [
            'id' => Equipment::max('id') + 1,
            'e_id' => $request->input('e_id'),
            'name' => $request->input('name'),
            'brand' => $request->input('brand'),
            'serial' => $request->input('serial'),
            'price' => $request->input('price'),
            'purchased_date' => $request->input('purchased_date'),
        ];
        
        DB::table('Equipments')->insert([$values]);

        return redirect()->route('equipments')->with('success', 'Equipment created successfully.');
    }

    public function paytransactionsView() 
    {
        return view('.includes.Pay_Transactions.paytransactionsview');
    }
    
    public function createPayTransaction() 
    {
        return view('.includes.Pay_Transactions.paytransactionform');
    } 

    public function storePayTransaction(Request $request)
    {
        $request->validate([
            'payer_id' => 'required|max:10',
            'payee_id' => 'required|max:10',
            'payment_mode' => 'required|max:20',
            'pay_date' => 'required|date',
            'amount' => 'required|numeric',
            'transaction_id' => 'required|max:20|unique:pay_transactions,transaction_id',
        ]);
        
        $values = [
            'payer_id' => $request->input('payer_id'),
            'payee_id' => $request->input('payee_id'),
            'payment_mode' => $request->input('payment_mode'),
            'pay_date' => $request->input('pay_date'),
            'amount' => $request->input('amount'),
            'transaction_id' => $request->input('transaction_id'),
        ];
        
        DB::table('Pay_Transactions')->insert([$values]);

        return redirect()->route('paytransactions')->with('success', 'Payment Transaction created successfully.');
    }

    public function trainersView() 
    {
        return view('.includes.Trainers.trainersview');
    }

    public function createTrainer()
    {
        if (Trainer::count() === 0) {
        $id = 1;
        } else {
            $lastTrainer = Trainer::latest('id')->first();
            $id = $lastTrainer->id + 1;
        }
        $t_id = 'TID' . str_pad($id, 3, '0', STR_PAD_LEFT);
        return view('.includes.Trainers.trainerform', ['t_id' => $t_id]);
    }

    public function storeTrainer(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'experience' => 'required|integer',
            'address' => 'required|max:50',
            'mobile' => 'required|max:15',
            'salary' => 'required|numeric',
        ]);
    
        $dob = new \DateTime($request->input('dob'));
        $currentDate = new \DateTime(now());
        $age = $dob->diff($currentDate)->y;
        
        $values = [
            'id' => Trainer::max('id') + 1,
            't_id' => $request->input('t_id'),
            'name' => $request->input('name'),
            'dob' => $request->input('dob'),
            'age' => $age,
            'gender' => $request->input('gender'),
            'experience' => $request->input('experience'),
            'address' => $request->input('address'),
            'mobile' => $request->input('mobile'),
            'salary' => $request->input('salary'),
        ];
        
        DB::table('Trainers')->insert([$values]);

        return redirect()->route('trainers')->with('success', 'Trainer created successfully.');
    }

    public function sessionsView() 
    {
        return view('.includes.Sessions.sessionsview');
    }

    public function createSession() {
        return view('.includes.Sessions.sessionform');
    }

    public function storeSession(Request $request)
    {
        try {
            $request->validate([
                's_date' => 'required|date',
                's_time' => 'required|max:20',
                'c_id' => 'required|exists:customers,c_id',
                't_id' => 'nullable|exists:trainers,t_id',
            ], [
                'c_id.exists' => 'The selected Customer ID is not available in the database.',
                't_id.exists' => 'The selected Trainer ID is not available in the database.',
            ]);
        
            $values = [
                's_date' => $request->input('s_date'),
                's_time' => $request->input('s_time'),
                'c_id' => $request->input('c_id'),
                't_id' => $request->input('t_id'),
            ];
            
            DB::table('Sessions')->insert([$values]);

            return redirect()->route('sessions')->with('success', 'Session created successfully.');
        } 
        catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }   

}