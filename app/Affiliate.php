<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    //

    protected function get_social_works($patient_id) {
    	$my_social_works = Affiliate::select('affiliates.id', 'plans.id as plan_id', 'social_works.name', 'plans.name as plan', 'affiliate_number', 'expiration_date')
        ->plan()
        ->socialWork()
        ->where('patient_id', $patient_id)
        ->get();

    	return $my_social_works;
    }

    public function scopePlan($query) {
		return $query->join('plans', 'plans.id', '=', 'affiliates.plan_id');
	}

    public function scopeSocialWork($query) {
        return $query->join('social_works', 'social_works.id', '=', 'plans.social_work_id');
    }
}
