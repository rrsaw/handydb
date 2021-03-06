<?php

namespace handy\Services\v1;

use Validator;
use handy\Loan;
use handy\User;

class LoanService
{
    public function getLoans($parameters)
    {
        if (empty($parameters)) {
            return $this->filterLoans(Loan::all());
        }

        if (isset($parameters['include'])) {
            $includeParms = explode(',', $parameters['include']);
        }
    }

    protected $rules = [
    'id' => 'required',
    'start_date' => 'required|date',
    'end_date' => 'required|date',
    'id_owner' => 'required',
    'id_receiver' => 'required',
    'id_item' => 'required',
    'loan_confirmation' => 'required|loan_confirmation',
    'return_confirmation' => 'required|loan_confirmation',
  ];

    public function validate($loan)
    {
        $validator = Validator::make($loan, $this->rules);
        $validator->validate();
    }

    public function getLoan($id)
    {
        return $this->filterLoans(Loan::where('id', $id)->get());
    }

    public function createLoan($req)
    {
        $id = $req->input('id');

        $loan = new Loan();
        $loan->id = $req->input('id');
        $loan->start_date = $req->input('start_date');
        $loan->id_owner = $req->input('id_owner');
        $loan->start_date = $req->input('start_date');
        $loan->id_receiver = $req->input('id_receiver');
        $loan->id_item = $req->input('id_item');
        $loan->loan_confirmation = $req->input('loan_confirmation');
        $loan->return_confirmation = $req->input('return_confirmation');

        $loan->save();

        return $this->filterLoans([$loan]);
    }

    public function updateLoan($req, $id)
    {
        $loan = Loan::where('id', $id)->firstOrFail();

        $loan->id = $req->input('id');
        $loan->start_date = $req->input('start_date');
        $loan->id_owner = $req->input('id_owner');
        $loan->start_date = $req->input('start_date');
        $loan->id_receiver = $req->input('id_receiver');
        $loan->id_item = $req->input('id_item');
        $loan->loan_confirmation = $req->input('loan_confirmation');
        $loan->return_confirmation = $req->input('return_confirmation');

        $loan->save();

        return $this->filterLoans([$loan]);
    }

    public function deleteLoan($id)
    {
        $loan = Loan::where('id', $id)->firstOrFail();
        $loan->delete();
    }

    protected function filterLoans($loans)
    {
        $data = [];
        foreach ($loans as $loan) {
            $entry = [
              'id' => $loan->id,
              'start_date' => $loan->start_date,
              'end_date' => $loan->end_date,
              // 'href' => route('loans.show', ['id' => $loan->id])
              'id_owner' => $loan->id_owner,
              'id_receiver' => $loan->id_receiver,
              'id_item' => $loan->id_item,
              'loan_confirmation' => $loan->loan_confirmation,
              'return_confirmation' => $loan->return_confirmation,
          ];

            $data[] = $entry;
        }
        return $data;
    }
}
