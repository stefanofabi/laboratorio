<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repository\SecurityCodeRepositoryInterface;

use App\Models\SecurityCode; 

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Exceptions\PrintException;
use App\Exceptions\NotImplementedException;
use Exception;

use Lang;

final class SecurityCodeRepository implements SecurityCodeRepositoryInterface
{

    private const SECURITY_CODE_LENGTH = 10;
    private const DAYS_TO_EXPIRATE_SECURITY_CODE = 10;

    protected $model;

    /**
     * SecurityCodeRepository constructor.
     *
     * @param SecurityCode $security_code
     */
    public function __construct(SecurityCode $security_code)
    {
        $this->model = $security_code;
    }

    public function all()
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function create(array $data)
    {         
        $new_security_code = Str::random(self::SECURITY_CODE_LENGTH);

        $date_today = date("Y-m-d");
        $new_expiration_date = date("Y-m-d", strtotime($date_today."+ ".self::DAYS_TO_EXPIRATE_SECURITY_CODE." days"));

        // It is included in a transaction to avoid that it can be used twice at the same time
        DB::beginTransaction();
        
        try {

            $this->model->updateOrCreate([
                'patient_id' => $data['patient_id']
            ], [    
                'security_code' => Hash::make($new_security_code),
                'expiration_date' => $new_expiration_date,
                'used_at' => null,
            ]);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            
            throw new PrintException(Lang::get('errors.generate_pdf'));
        }
        
        return [
            'security_code' => $new_security_code,
            'expiration_date' => $new_expiration_date
        ];
    }

    public function update(array $data, $id)
    {
        throw new NotImplementedException('Method has not implemented');
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function findOrFail($id)
    {
        return $this->model->findOrFail($id);
    }
}