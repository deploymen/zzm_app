<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameSubjectSchedule extends Eloquent {

    use SoftDeletes;

    public $table = 't0133_game_subject_schedule';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $dates = ['deleted_at'];
    protected $hidden = [];

    public function scopePrev() {

        $schedule = self::where('subject_category', $this->subject_category)
                ->where('sequence', $this->sequence - 1)
                ->first();
        if (!$schedule) {
            return false;
        }

        return $schedule;
    }

    public function scopeNext() {
        $schedule = self::where('subject_category', $this->subject_category)
                ->where('sequence', $this->sequence + 1)
                ->first();
        if (!$schedule) {
            return false;
        }

        return $schedule;
    }

    public function subject() {
        return $this->belongsTo('App\Models\GameSubject');
    }

}
