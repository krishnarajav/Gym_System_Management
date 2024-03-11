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
use App\Models\GymSession;
use App\Models\Pay_Transaction;
use App\Models\Personal_Details;
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
        $customers = DB::select("SELECT * FROM Customers");

        return view('.includes.Customers.customersview', ['customers' => $customers]);
    }

    //Plans
    public function plansView()
    {
        $plans = DB::select("SELECT * FROM Plans");

        return view('.includes.Plans.plansview', ['plans' => $plans]);
    }

    public function createPlan()
    {
        $result = DB::select("SELECT MAX(id) as max_id FROM Plans");
        if (empty($result) || $result[0]->max_id === null) {
            $id = 1;
        } 
        else {
            $id = $result[0]->max_id + 1;
        }
        $p_id = 'PID' . str_pad($id, 3, '0', STR_PAD_LEFT);

        return view('.includes.Plans.planform', ['p_id' => $p_id]);
    }

    public function storePlan(Request $request)
    {
        $request->validate([
            'p_id' => 'required|unique:plans,p_id',
            'name' => 'required|max:50',
            'period' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        DB::insert(
            "INSERT INTO Plans (id, p_id, name, period, price) 
            VALUES (?, ?, ?, ?, ?)",
            [
                DB::table('Plans')->max('id') + 1,
                $request->input('p_id'),
                $request->input('name'),
                $request->input('period'),
                $request->input('price'),
            ]
        );

        return redirect()->route('plans')->with('success', 'Plan created successfully.');
    }

    public function editPlan($id)
    {
        $plan = DB::select("SELECT * FROM Plans WHERE id = ?", [$id])[0];

        return view('.includes.Plans.editplan', ['plan' => $plan]);
    }


    public function updatePlan(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'period' => 'required|numeric',
            'price' => 'required|numeric',
        ]);
        DB::update(
            "UPDATE Plans 
            SET name = ?, period = ?, price = ? 
            WHERE id = ?",
            [
                $request->input('name'), 
                $request->input('period'), 
                $request->input('price'), 
                $id
            ]
        );

        return redirect()->route('plans')->with('success', 'Plan updated successfully!');
    }

    public function deletePlan($id)
    {
        $plan = DB::select("SELECT * FROM Plans WHERE id = ?", [$id])[0];
        $customers = DB::select("SELECT * FROM Customers WHERE p_id = ?", [$plan->p_id]);
        foreach ($customers as $customer) {
            DB::update(
                "UPDATE Customers 
                SET p_id = null, p_start = null, p_end = null, p_status = 'EXPIRED'
                WHERE id = ?",
                [$customer->id]
            );
        }
        DB::delete("DELETE FROM Plans WHERE id = ?", [$id]);

        return redirect()->route('plans')->with('success', 'Plan deleted successfully!');
    }

    //Customers
    public function customersView()
    {
        $customers = DB::select(
            "SELECT Customers.*, Personal_Details.*
            FROM Customers
            LEFT JOIN Personal_Details ON Customers.c_id = Personal_Details.c_id"
        );

        return view('.includes.Customers.customersview', ['customers' => $customers]);
    }

    public function createCustomer()
    {
        $result = DB::select("SELECT MAX(id) as max_id FROM Customers");
        if (empty($result) || $result[0]->max_id === null) {
            $id = 1;
        } 
        else {
            $id = $result[0]->max_id + 1;
        }
        $c_id = 'CID' . str_pad($id, 3, '0', STR_PAD_LEFT);
        $plans = DB::select("SELECT * FROM Plans");

        return view('.includes.Customers.customerform', ['c_id' => $c_id, 'plans' => $plans]);
    }

    public function storeCustomer(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'address' => 'required|max:50',
            'mobile' => 'required|max:15',
            'p_id' => 'required|exists:plans,p_id', 
            'p_start' => 'required|date',
        ]);

        $dob = new \DateTime($request->input('dob'));
        $currentDate = new \DateTime(now());
        $age = $dob->diff($currentDate)->y;
        $plan = DB::table('Plans')->where('p_id', $request->input('p_id'))->first();
        $p_start = Carbon::parse($request->input('p_start'));
        $p_end = $p_start->copy()->addDays($plan->period);
        $p_status = 'ACTIVE';

        DB::insert(
            "INSERT INTO Customers (id, c_id, p_id, p_start, p_end, p_status) 
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                DB::table('Customers')->max('id') + 1,
                $request->input('c_id'),
                $request->input('p_id'),
                $request->input('p_start'),
                $p_end,
                $p_status
            ]
        );

        $t_id = null;
        DB::insert(
            "INSERT INTO Personal_Details (c_id, t_id, name, dob, age, gender, height, weight, address, mobile) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
        [
            $request->input('c_id'),
            $t_id,
            $request->input('name'),
            $request->input('dob'),
            $age,
            $request->input('gender'),
            $request->input('height'),
            $request->input('weight'),
            $request->input('address'),
            $request->input('mobile'),
        ]
    );
    
        return redirect()->route('customers')->with('success', 'Customer created successfully.');
    } 

    public function editCustomer($id)
    {
        $customerdetails = DB::select(
            "SELECT Customers.*, Personal_Details.*
            FROM Customers
            LEFT JOIN Personal_Details ON Customers.c_id = Personal_Details.c_id
            WHERE Customers.id = ?",[$id]
        );
        $customer = $customerdetails[0];
        $plans = DB::select("SELECT * FROM Plans");

        return view('.includes.Customers.editcustomer', ['customer' => $customer, 'plans' => $plans]);
    }

    public function updateCustomer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'address' => 'required|max:50',
            'mobile' => 'required|max:15',
            'p_id' => 'required|exists:plans,p_id', 
            'p_start' => 'required|date',
        ]);

        $dob = new \DateTime($request->input('dob'));
        $currentDate = new \DateTime(now());
        $age = $dob->diff($currentDate)->y;
        $plan = DB::table('Plans')->where('p_id', $request->input('p_id'))->first();
        $p_start = Carbon::parse($request->input('p_start'));
        $p_end = $p_start->copy()->addDays($plan->period);
        $p_status = 'ACTIVE';
        
        DB::update(
            "UPDATE Customers 
            SET p_id = ?, p_start = ?, p_end = ?, p_status = ?, updated_at = NOW()
            WHERE id = ?",
            [
                $request->input('p_id'),
                $request->input('p_start'),
                $p_end,
                $p_status,
                $id
            ]
        );   

        $c_id = DB::select(
            "SELECT c_id from Customers
            where id = ?",[$id]
        )[0]->c_id;

        DB::update(
            "UPDATE Personal_Details 
            SET name = ?, dob = ?, age = ?, gender = ?, height = ?, weight = ?, address = ?, mobile = ?, updated_at = NOW()
            WHERE c_id = ?",
            [
                $request->input('name'),
                $request->input('dob'),
                $age,
                $request->input('gender'),
                $request->input('height'),
                $request->input('weight'),
                $request->input('address'),
                $request->input('mobile'),
                $c_id
            ]
        );   

        return redirect()->route('customers')->with('success', 'Customer updated successfully!');
    }

    public function deleteCustomer($id)
    {
        DB::delete("DELETE FROM Customers WHERE id = :id", ['id' => $id]);

        return redirect()->route('customers')->with('success', 'Customer deleted successfully!');
    }

    //Trainers
    public function trainersView() 
    {
        $trainers = DB::select(
            "SELECT Trainers.*, Personal_Details.*
            FROM Trainers
            LEFT JOIN Personal_Details ON Trainers.t_id = Personal_Details.t_id"
        );

        return view('.includes.Trainers.trainersview', ['trainers' => $trainers]);
    }

    public function createTrainer()
    {
        $result = DB::select("SELECT MAX(id) as max_id FROM Trainers");
        if (empty($result) || $result[0]->max_id === null) {
            $id = 1;
        } 
        else {
            $id = $result[0]->max_id + 1;
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
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'experience' => 'required|integer',
            'address' => 'required|max:50',
            'mobile' => 'required|max:15',
            'salary' => 'required|numeric',
        ]);

        $dob = new \DateTime($request->input('dob'));
        $currentDate = new \DateTime(now());
        $age = $dob->diff($currentDate)->y;
        
        DB::insert(
            "INSERT INTO Trainers (id, t_id, experience, salary) 
             VALUES (?, ?, ?, ?)",
            [
                DB::table('Trainers')->max('id') + 1,
                $request->input('t_id'),
                $request->input('experience'),
                $request->input('salary'),
            ]
        );

        $c_id = null;
        DB::insert(
            "INSERT INTO Personal_Details (c_id, t_id, name, dob, age, gender, height, weight, address, mobile) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
            [
                $c_id,
                $request->input('t_id'),
                $request->input('name'),
                $request->input('dob'),
                $age,
                $request->input('gender'),
                $request->input('height'),
                $request->input('weight'),
                $request->input('address'),
                $request->input('mobile'),
            ]
        );

        return redirect()->route('trainers')->with('success', 'Trainer created successfully.');
    }

    public function editTrainer($id)
    {
        $trainerdetails = DB::select(
            "SELECT Trainers.*, Personal_Details.*
            FROM Trainers
            LEFT JOIN Personal_Details ON Trainers.t_id = Personal_Details.t_id
            WHERE Trainers.id = ?",[$id]
        );
        $trainer = $trainerdetails[0];

        return view('.includes.Trainers.edittrainer', ['trainer' => $trainer]);
    }

    public function updateTrainer(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'address' => 'required|max:50',
            'mobile' => 'required|max:15',
            'experience' => 'required|integer',
            'salary' => 'required|numeric',
        ]);

        $dob = new \DateTime($request->input('dob'));
        $currentDate = new \DateTime(now());
        $age = $dob->diff($currentDate)->y;

        DB::update(
            "UPDATE Trainers
            SET experience = ?, salary = ?, updated_at = NOW()
            WHERE id = ?",
            [
                $request->input('experience'),
                $request->input('salary'),
                $id
            ]
        ); 

        $t_id = DB::select(
            "SELECT t_id from Trainers
            where id = ?",[$id]
        )[0]->t_id;

        DB::update(
            "UPDATE Personal_Details 
            SET name = ?, dob = ?, age = ?, gender = ?, height = ?, weight = ?, address = ?, mobile = ?, updated_at = NOW()
            WHERE t_id = ?",
            [
                $request->input('name'),
                $request->input('dob'),
                $age,
                $request->input('gender'),
                $request->input('height'),
                $request->input('weight'),
                $request->input('address'),
                $request->input('mobile'),
                $t_id
            ]
        );

        return redirect()->route('trainers')->with('success', 'Trainer updated successfully!');
    }

    public function deleteTrainer($id)
    {
        DB::delete("DELETE FROM Trainers WHERE id = :id", ['id' => $id]);

        return redirect()->route('trainers')->with('success', 'Trainer deleted successfully!');
    }

    //Equiments
    public function equipmentsView()
    {
        $equipments = DB::select("SELECT * FROM Equipments");
     
        return view('.includes.Equipments.equipmentsview', ['equipments' => $equipments]);
    }

    public function createEquipment()
    {
        $result = DB::select("SELECT MAX(id) as max_id FROM Equipments");
        if (empty($result) || $result[0]->max_id === null) {
            $id = 1;
        } 
        else {
            $id = $result[0]->max_id + 1;
        }
        $e_id = 'EQPID' . str_pad($id, 3, '0', STR_PAD_LEFT);

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

        DB::insert(
            "INSERT INTO Equipments (id, e_id, name, brand, serial, price, purchased_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                DB::table('Equipments')->max('id') + 1,
                $request->input('e_id'),
                $request->input('name'),
                $request->input('brand'),
                $request->input('serial'),
                $request->input('price'),
                $request->input('purchased_date'),
            ]
        );

        return redirect()->route('equipments')->with('success', 'Equipment created successfully.');
    }

    public function editEquipment($id)
    {
        $equipment = DB::select("SELECT * FROM Equipments WHERE id = ?", [$id])[0];

        return view('.includes.Equipments.editequipment', ['equipment' => $equipment]);
    }

    public function updateEquipment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:50',
            'brand' => 'required|max:50',
            'serial' => 'required|unique:Equipments,serial,' . $id,
            'price' => 'required|numeric',
            'purchased_date' => 'required|date',
        ]);
        DB::update(
            "UPDATE equipments 
            SET name = ?, brand = ?, serial = ?, price = ?, purchased_date = ? 
            WHERE id = ?",
            [
                $request->input('name'),
                $request->input('brand'),
                $request->input('serial'),
                $request->input('price'),
                $request->input('purchased_date'),
                $id
            ]
        );

        return redirect()->route('equipments')->with('success', 'Equipment updated successfully!');
    }

    public function deleteEquipment($id)
    {
        DB::delete("DELETE FROM Equipments WHERE id = :id", ['id' => $id]);

        return redirect()->route('equipments')->with('success', 'Equipment deleted successfully!');
    }

    //Pay_Transactions
    public function paytransactionsView() 
    {
        $paytransactions = DB::select("SELECT * FROM Pay_Transactions");

        return view('.includes.Pay_Transactions.paytransactionsview', ['paytransactions'=> $paytransactions]);
    }
    
    public function createPayTransaction() 
    {
        $result = DB::select("SELECT MAX(id) as max_id FROM Pay_Transactions");
        if (empty($result) || $result[0]->max_id === null) {
            $id = 1;
        } 
        else {
            $id = $result[0]->max_id + 1;
        }

        return view('.includes.Pay_Transactions.paytransactionform', ['id' => $id]);
    } 

    public function storePayTransaction(Request $request)
    {
        $request->validate([
            'payer_id' => [
                'required',
                'max:10',
                function ($attribute, $value, $fail) {
                    if (!Customer::where('c_id', $value)->exists() && !Admin::where('id', $value)->exists()) {
                        $fail("Invalid Payer ID");
                    }
                },
            ],
            'payee_id' => [
                'required',
                'max:10',
                'different:payer_id',
                function ($attribute, $value, $fail) use ($request) {
                    $payerId = $request->input('payer_id');
    
                    if (Customer::where('c_id', $payerId)->exists() && !Admin::where('id', $value)->exists()) {
                        $fail("Invalid Payee ID.");
                    }
    
                    if (!Admin::where('id', $value)->exists() && !Trainer::where('t_id', $value)->exists()) {
                        $fail("Invalid Payee ID");
                    }
                },
            ],
            'payment_mode' => 'required|max:20',
            'pay_date' => 'required|date',
            'amount' => 'required|numeric',
            'transaction_id' => 'nullable|max:20|unique:pay_transactions,transaction_id',
        ]);
        DB::insert(
            "INSERT INTO Pay_Transactions (id, payer_id, payee_id, payment_mode, pay_date, amount, transaction_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?)",
            [
                DB::table('Pay_Transactions')->max('id') + 1,
                $request->input('payer_id'),
                $request->input('payee_id'),
                $request->input('payment_mode'),
                $request->input('pay_date'),
                $request->input('amount'),
                $request->input('transaction_id'),
            ]
        );

        return redirect()->route('paytransactions')->with('success', 'Payment Transaction created successfully.');
    }

    public function deletePayTransaction($id)
    {
        DB::delete("DELETE FROM Pay_Transactions WHERE id = :id", ['id' => $id]);

        return redirect()->route('paytransactions')->with('success', 'Payment Transaction deleted successfully!');
    }

    //Sessions
    public function sessionsView() 
    {
        $gsessions = DB::select("SELECT * FROM Gym_Sessions");

        return view('.includes.Sessions.sessionsview', ['gsessions' => $gsessions]);
    }

    public function createSession() {
        $result = DB::select("SELECT MAX(id) as max_id FROM Gym_Sessions");
        if (empty($result) || $result[0]->max_id === null) {
            $id = 1;
        } 
        else {
            $id = $result[0]->max_id + 1;
        }
        $customers = DB::select("SELECT * FROM Customers");
        $trainers = DB::select("SELECT * FROM Trainers");

        return view('.includes.Sessions.sessionform', ['id' => $id, 'customers' => $customers, 'trainers' => $trainers]);
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

            $existingSession = GymSession::where([
                's_date' => $request->input('s_date'),
                's_time' => $request->input('s_time'),
                'c_id' => $request->input('c_id'),
            ])->first();

            if ($existingSession) {
                return redirect()->back()->with('error', 'A session with the same date, time, and customer already exists.');
            }
            DB::insert(
                "INSERT INTO Gym_Sessions (id, s_date, s_time, c_id, t_id) 
                VALUES (?, ?, ?, ?, ?)",
                [
                    DB::table('Gym_Sessions')->max('id') + 1,
                    $request->input('s_date'),
                    $request->input('s_time'),
                    $request->input('c_id'),
                    $request->input('t_id'),
                ]
            );

            return redirect()->route('sessions')->with('success', 'Session created successfully.');
        } 
        catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }
    
    public function editSession($id)
    {
        $gsession = DB::select("SELECT * FROM Gym_Sessions WHERE id = ?", [$id])[0];
        $customers = DB::select("SELECT * FROM Customers");
        $trainers = DB::select("SELECT * FROM Trainers");

        return view('.includes.Sessions.editsession', ['gsession' => $gsession, 'customers' => $customers, 'trainers' => $trainers]);
    }

    public function updateSession(Request $request, $id)
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

            DB::update(
                "UPDATE Gym_Sessions 
                SET s_date = ?, s_time = ?, c_id = ?, t_id = ? 
                WHERE id = ?",
                [
                    $request->input('s_date'),
                    $request->input('s_time'),
                    $request->input('c_id'),
                    $request->input('t_id'),
                    $id
                ]
            );
    
            return redirect()->route('sessions')->with('success', 'Session updated successfully.');
        } 
        catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function deleteSession($id)
    {
        DB::delete("DELETE FROM Gym_Sessions WHERE id = :id", ['id' => $id]);

        return redirect()->route('sessions')->with('success', 'Session deleted successfully!');
    }
}