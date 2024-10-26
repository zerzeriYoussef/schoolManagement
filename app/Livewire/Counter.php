<?php

namespace App\Livewire;

use App\Models\My_Parent;
use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class Counter extends Component
{
    public $currentStep = 1 ;
    public $successMessage = '';
    // Father_INPUTS
    public $catchError,$updateMode = false,$photos,$show_table = true,$Parent_id;

    public $Email, $Password,//chouf blade 3ibara name wire:model="Password"
    $Name_Father, $Name_Father_en,
    $National_ID_Father, $Passport_ID_Father,
    $Phone_Father, $Job_Father, $Job_Father_en,
    $Nationality_Father_id, $Blood_Type_Father_id,
    $Address_Father, $Religion_Father_id,

    // Mother_INPUTS
    $Name_Mother, $Name_Mother_en,
    $National_ID_Mother, $Passport_ID_Mother,
    $Phone_Mother, $Job_Mother, $Job_Mother_en,
    $Nationality_Mother_id, $Blood_Type_Mother_id,
    $Address_Mother, $Religion_Mother_id;
    public $count = 0;
    protected $rules = [
        'Email' => 'required|email',
        'Password' => 'required|min:8',
        'Name_Father' => 'required|string|min:3',
        'Name_Father_en' => 'required|string|min:3',
        'National_ID_Father' => 'required|string|min:10|max:10|regex:/[0-9]{9}/',
        'Passport_ID_Father' => 'nullable|min:10|max:10',
        'Phone_Father' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
        'Address_Father' => 'required|string|min:5',
        'Job_Father' => 'required|string',
        'Job_Father_en' => 'required|string',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function render()
    {
        return view('livewire.counter');
    }
      //firstStepSubmit
      public function firstStepSubmit()
      {
        $this->validate();

          $this->currentStep = 2;
      }
  
      //secondStepSubmit
      public function secondStepSubmit()
      {
        $this->validate();
          $this->currentStep = 3;
      }
  
  
      //back
      public function back($step)
      {
          $this->currentStep = $step;
      }
      
    public function submitForm(){
        
            $My_Parent = new My_Parent();
            // Father_INPUTS
            $My_Parent->Email = $this->Email;
            $My_Parent->Password = Hash::make($this->Password);
            $My_Parent->Name_Father = ['en' => $this->Name_Father_en, 'ar' => $this->Name_Father];
            $My_Parent->National_ID_Father = $this->National_ID_Father;
            $My_Parent->Passport_ID_Father = $this->Passport_ID_Father;
            $My_Parent->Phone_Father = $this->Phone_Father;
            $My_Parent->Job_Father = ['en' => $this->Job_Father_en, 'ar' => $this->Job_Father];
            $My_Parent->Address_Father = $this->Address_Father;

            // Mother_INPUTS
            $My_Parent->Name_Mother = ['en' => $this->Name_Mother_en, 'ar' => $this->Name_Mother];
            $My_Parent->National_ID_Mother = $this->National_ID_Mother;
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Phone_Mother = $this->Phone_Mother;
            $My_Parent->Job_Mother = ['en' => $this->Job_Mother_en, 'ar' => $this->Job_Mother];
            $My_Parent->Passport_ID_Mother = $this->Passport_ID_Mother;
            $My_Parent->Address_Mother = $this->Address_Mother;

            $My_Parent->save();
            $this->successMessage = trans('messages.success');
            $this->clearForm();
            $this->currentStep = 1;
       
    }

public function clearForm()
    {
        $this->Email = '';
        $this->Password = '';
        $this->Name_Father = '';
        $this->Job_Father = '';
        $this->Job_Father_en = '';
        $this->Name_Father_en = '';
        $this->National_ID_Father ='';
        $this->Passport_ID_Father = '';
        $this->Phone_Father = '';
        $this->Nationality_Father_id = '';
        $this->Blood_Type_Father_id = '';
        $this->Address_Father ='';
        $this->Religion_Father_id ='';

        $this->Name_Mother = '';
        $this->Job_Mother = '';
        $this->Job_Mother_en = '';
        $this->Name_Mother_en = '';
        $this->National_ID_Mother ='';
        $this->Passport_ID_Mother = '';
        $this->Phone_Mother = '';
        $this->Nationality_Mother_id = '';
        $this->Blood_Type_Mother_id = '';
        $this->Address_Mother ='';
        $this->Religion_Mother_id ='';

    }
}