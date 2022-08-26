<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class PayLinkGateway
{

    protected function getToken(): string
    {

        try {
            $client = new Client();

            $response = $client->request('POST', 'https://restpilot.paylink.sa/api/auth', [
                'body' => json_encode([
                    'apiId' => 'APP_ID_1123453311',
                    'persistToken' => false,
                    'secretKey' => '0662abb5-13c7-38ab-cd12-236e58f43766'
                ]),

                'headers' => [
                    'Accept' => '*/*',
                    'Content-Type' => 'application/json',
                ]
            ]);

            return json_decode($response->getBody(),true)["id_token"];

        } catch (\Exception $exception) {

            abort($exception->getCode());
        }

    }

    public function CreateNewInvoice(Request $request): RedirectResponse
    {
        $data_request = $request->input();

        $user_data = json_decode($request->input()["data"],true);

        $package = Package::where('id', '=', $data_request['package_id'])->first();

        if ($data_request["billing_interval"] === 'monthly') {

            $amount = (double)$package->rate_monthly;

        } else if ($data_request["billing_interval"] === 'yearly') {

            $amount = (double)$package->rate_yearly;
        }

        if ($amount < 5)
        {
            return redirect()->route('user.show', ['user_id' => auth()->user()->getAuthIdentifier()])->with(['danger_alert' => __('You should paid more than 5 rs')]);

        }

        $token = $this->getToken();

        try {
            $client = new Client();

            $response = $client->request('POST', 'https://restpilot.paylink.sa/api/addInvoice', [
                'body' => json_encode([
                    'amount' => $amount,
                    'callBackUrl' => 'http://127.0.0.1:8000/payLink',
                    'clientEmail' => "{$user_data["email"]}",
                    'clientMobile' => "{$user_data["phone"]}",
                    'clientName' => "{$user_data["name"]}",
                    'note' => 'Add New Invoice.',
                    'orderNumber' => uniqid("package_id_{$data_request["package_id"]}_{$data_request["billing_interval"]}_"),
                ]),

                'headers' => [
                    'Accept' => 'application/json;charset=UTF-8',
                    'Authorization' => $token,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $data_response = json_decode($response->getBody(),true);
            return redirect()->away($data_response["url"]);

        } catch (\Exception $exception){
            abort($exception->getCode());
        }
    }

    protected function getInvoiceData($transactionNo): array
    {
        $token = $this->getToken();

        $client = new Client();

        try {

            $response = $client->request('GET', 'https://restpilot.paylink.sa/api/getInvoice/'.$transactionNo, [
                'headers' => [
                    'Accept' => 'application/json;charset=UTF-8',
                    'Authorization' => $token,
                ],
            ]);

            return json_decode($response->getBody(),true);

        } catch (\Exception $exception){

            abort($exception->getCode());
        }
    }

    public function payLinkSuccess(Request $request): RedirectResponse
    {
        $data_request = $request->input();

        $data_transaction = $this->getInvoiceData($data_request["transactionNo"]);

        $transaction_number = $data_transaction["transactionNo"];

        $order_data = explode("_", $data_transaction["gatewayOrderRequest"]["orderNumber"]);

        if (Transaction::query()->where('code', $transaction_number)->count())  return abort(403);

        $gateway = 'payLink';
        $bank_id = User::where('name', '=', 'bank')->value('id');

        // user transaction (plus)
        $transaction = new Transaction();
        $transaction->code = $transaction_number;
        $transaction->user_id = auth()->user()->getAuthIdentifier();
        $transaction->user2_id = $bank_id;
        $transaction->type = 'topup';
        $transaction->amount = $data_transaction["amount"];
        $transaction->data = json_encode($data_transaction);
        $transaction->save();

        $date= Carbon::now();
        DB::table('users')
            ->where('id', auth()->user()->getAuthIdentifier())
            ->update([
                'billing_start' => $date->toDateTime(),
                'billing_end' => $date->addMonth()->toDateTime(),
                'package_id'=> $order_data[2],
                'billing_interval' => $order_data[3]
            ]);

        File::ensureDirectoryExists(public_path("users/" . auth()->user()->getAuthIdentifier() . "/topup"));
        file_put_contents(public_path("users/" . auth()->user()->getAuthIdentifier() . "/topup/{$gateway}_{$data_transaction["transactionNo"]}.json"), json_encode($data_transaction));
        return redirect()->route('user.show', ['user_id' => auth()->user()->getAuthIdentifier()])->with(['success_alert' => __('Top up successful!')]);
    }
}
