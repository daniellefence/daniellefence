<?php

namespace App\Livewire;

use App\Models\Career;
use App\Models\JobApplication;
use Livewire\Component;
use Livewire\WithFileUploads;

class Apply extends Component
{
    use WithFileUploads;

    public $job_position;

    public $first_name;

    public $last_name;

    public $phone;

    public $email;

    public $resume;

    public function placeholder()
    {
        return view('lazy-loader');
    }

    public function mount($id = false)
    {
        if ($id) {
            $this->job_position = Career::findOrFail($id)->title;
        }
    }

    public function save()
    {
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'email|required',
            'resume' => 'sometimes',
        ]);
        $application = JobApplication::create([
            'job_position' => $this->job_position,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);
        if ($this->resume) {
            $application->attachments()->create([
                'path' => $this->resume->store('attachments'),
            ]);
        }
        danielle()->sendMail('application', $application);
        $this->redirect(route('thanks'));
    }

    public function cancel()
    {
        $this->resetExcept([
            'job_position',
        ]);
        $this->resetErrorBag();
    }

    public function render()
    {
        return view('livewire.apply');
    }
}
