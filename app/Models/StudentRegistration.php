<?php

namespace App\Models;

use Database\Factories\StudentRegistrationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentRegistration extends Model
{
    /** @use HasFactory<StudentRegistrationFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name_km',
        'name_en',
        'date_of_birth',
        'gender',
        'nationality',
        'phone',
        'email',
        'current_province_id',
        'current_district_id',
        'current_commune_id',
        'current_village_id',
        'current_house',
        'current_street',
        'permanent_province_id',
        'permanent_district_id',
        'permanent_commune_id',
        'permanent_village_id',
        'permanent_house',
        'permanent_street',
        'father_name',
        'father_occupation',
        'father_phone',
        'mother_name',
        'mother_occupation',
        'mother_phone',
        'emergency_name',
        'emergency_phone',
        'high_school',
        'graduation_year',
        'education_province_id',
        'certificate_path',
    ];

    protected function casts(): array
    {
        return [
            'date_of_birth' => 'date',
            'graduation_year' => 'integer',
        ];
    }

    public function currentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'current_province_id');
    }

    public function currentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'current_district_id');
    }

    public function currentCommune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'current_commune_id');
    }

    public function currentVillage(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'current_village_id');
    }

    public function permanentProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'permanent_province_id');
    }

    public function permanentDistrict(): BelongsTo
    {
        return $this->belongsTo(District::class, 'permanent_district_id');
    }

    public function permanentCommune(): BelongsTo
    {
        return $this->belongsTo(Commune::class, 'permanent_commune_id');
    }

    public function permanentVillage(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'permanent_village_id');
    }

    public function educationProvince(): BelongsTo
    {
        return $this->belongsTo(Province::class, 'education_province_id');
    }
}
