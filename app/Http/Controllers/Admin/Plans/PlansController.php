<?php

namespace App\Http\Controllers\Admin\Plans;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class PlansController extends Controller
{
    public function create()
    {

        return view('admin.plans.create');
    }

    public function createPlan(Request $request)
    {
        $data = $request->all();
        // dd($data);
        $amount = number_format($data['amount'], 2,'.', ',');

        // dd($amount);

        $response = Http::withHeaders([
            'Accept' => 'application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1',
            'Content-type' => 'application/json'

        ])->post(
            'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals/request/?email=caiquefaria86@gmail.com&token=DC86A35A3AF24D5283E9266D7C8F578E',
            [
                'reference' => $data['nickname'],
                'preApproval' => [
                    'name' => $data['name'],
                    'charge' => 'AUTO',
                    'period' => 'MONTHLY',
                    'amountPerPayment' => $data['amount'],
                    'trialPeriodDuration' => '30'
                ]
            ]
        );
        // name 	reference 	code 	amount 	period 	trialPeriodDuration 	status 	date
        // dd($response->json());
        if($response->json()):
            $code = $response->json()['code'];

            $plan = new Plan();
            $plan->name         = $data['name'];
            $plan->reference    = $data['nickname'];
            $plan->code         = $code;
            $plan->amount         = $amount;
            $plan->period         = 'MOTHLY';
            $plan->trialPeriodDuration = 30;
            $plan->date         = $response->json()['date'];
            $plan->status       = true;
            $plan->save();

            return redirect()->back()->with('success', 'Plano criado com sucesso');
        else:
            return redirect()->back()->with('error', 'Erro ao criar o plano');
        endif;

    }
}
