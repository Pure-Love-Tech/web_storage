<?php

namespace App\Http\Controllers\Premium\Payments\Manual;

use App\Events\TransactionCreated;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Validator;

class ProcessController extends Controller
{
    public static function process($trx)
    {
        $data['view'] = "premium.gateways.manual";
        return json_encode($data);
    }

    public function execute(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'payment_proof' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        $trx = Transaction::where([['id', $id], ['user_id', auth()->user()->id]])->unpaid()->firstOrFail();
        $fileUpload = storageFileUpload($request->file('payment_proof'), 'uploads/transactions/', 'local', $trx->id);
        if ($fileUpload) {
            $trx->proof = $fileUpload;
            $trx->status = Transaction::STATUS_PENDING;
            $trx->update();
            event(new TransactionCreated($trx));
            toastr()->success(translate('Payment proof has been sent successfully', 'premium'));
            return redirect()->route('user.settings.subscription');
        } else {
            toastr()->success(translate('File Upload Error', 'premium'));
            return redirect()->route('premium.index');
        }
    }
}
