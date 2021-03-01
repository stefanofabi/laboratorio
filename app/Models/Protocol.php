<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Traits\LogsActivity;

class Protocol extends Model
{
    //

    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['completion_date', 'observations'];

    protected static $logFillable = true;

    protected function index($filter, $offset, $length)
    {

        /* ID - COMPLETION_DATE - PATIENT_ID - PATIENT - TYPE */
        $derived_protocols = DB::table('protocols')
            ->select('protocols.id', 'protocols.completion_date', 'derived_patients.id as patient_id', 'derived_patients.full_name as patient', DB::raw('"derived" as type'))
            ->join('derived_protocols', 'protocols.id', '=', 'derived_protocols.protocol_id')
            ->join('derived_patients', 'derived_protocols.patient_id', '=', 'derived_patients.id')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("protocols.id", "like", "$filter%")
                        ->orWhere("derived_patients.full_name", "like", "%$filter%")
                        ->orWhere("derived_patients.key", "like", "$filter%");
                }
            });

        $protocols = DB::table('our_protocols')
            ->select('protocols.id', 'protocols.completion_date as completion_date', 'patients.id as patient_id', 'patients.full_name as patient', DB::raw('"our" as type'))
            ->join('patients', 'patients.id', '=', 'our_protocols.patient_id')
            ->join('protocols', 'protocols.id', '=', 'our_protocols.protocol_id')
            ->where(function ($query) use ($filter) {
                if (! empty($filter)) {
                    $query->orWhere("protocols.id", "like", "$filter%")
                        ->orWhere("patients.full_name", "like", "%$filter%")
                        ->orWhere("patients.key", "like", "$filter%")
                        ->orWhere("patients.owner", "like", "%$filter%");
                }
            })
            ->union($derived_protocols)
            ->orderBy('id', 'desc')
            ->get();

        return $protocols;
    }

    /**
     * Get the practices for the protocol.
     */
    public function practices()
    {
        return $this->hasMany(Practice::class);
    }

    /**
     * Get the our protocol associated with the protocol.
     */
    public function our_protocol()
    {
        return $this->hasOne(OurProtocol::class);
    }
}
