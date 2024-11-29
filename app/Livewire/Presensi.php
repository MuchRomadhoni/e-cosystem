<?php

namespace App\Livewire;

use App\Models\Attendence;
use Livewire\Component;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Presensi extends Component
{
    public $latitude;
    public $longitude;
    public $insideRadius = false;
    public $timeNow;
    public function render()
    {
        $schedule = Schedule::where('user_id', Auth::user()->id)->first();
        $attendance = Attendence::where('user_id', Auth::user()->id)
            ->whereDate('created_at', date('Y-m-d'))
            ->first();
        return view('livewire.presensi', [
            'schedule' => $schedule,
            'insideRadius' => $this->insideRadius,
            'attendance' => $attendance
        ]);
    }

    //store data presensi
    public function store()
    {
        $this->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $schedule = Schedule::where('user_id', Auth::user()->id)->first();

        if ($schedule) {
            $attendance = Attendence::where('user_id', Auth::user()->id)
                ->whereDate('created_at', date('Y-m-d'))
                ->first();

            if (!$attendance) {
                Attendence::create([
                    'user_id' => Auth::user()->id,
                    'schedule_latitude' => $schedule->kantor->latitude,
                    'schedule_longitude' => $schedule->kantor->longitude,
                    'schedule_start_time' => $schedule->shift->start_time,
                    'schedule_end_time' => $schedule->shift->end_time,
                    'start_latitude' => $this->latitude,
                    'start_longitude' => $this->longitude,
                    'start_time' => Carbon::now('Asia/Jakarta')->toTimeString(),
                ]);
            } else {
                $timeNow = Carbon::now('Asia/Jakarta');

                if ($timeNow->greaterThan($schedule->shift->end_time)) {
                    $attendance->update([
                        'end_latitude' => $this->latitude,
                        'end_longitude' => $this->longitude,
                        'end_time' => Carbon::now('Asia/Jakarta')->toTimeString(),
                    ]);
                }
            }
            return redirect()->route('presensi', [
                'schedule' => $schedule,
                'insideRadius' => false,
            ]);
        }
    }
}