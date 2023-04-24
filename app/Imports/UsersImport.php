<?php

namespace App\Imports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithChunkReading, SkipsEmptyRows, WithValidation, SkipsOnFailure
{
    use Importable, SkipsFailures;

    public $Err = [];

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $user = User::query()->where('code_user', $row['ma_sinh_vien'])->first();

        if ($user) {
            $error       = [
                'err' => ["Mã sinh viên: " . $row['ma_sinh_vien'] . " đã tồn tại!"],
                "row" => $row['stt']
            ];
            $this->Err[] = $error;
        }

        if (!$user) {
            $time     = new Carbon($row['ngay_sinh']);
            $password = (($time->day < 10) ? ('0' . $time->day) : ($time->day)) . (($time->month < 10) ? ('0' . $time->month) : ($time->day)) . $time->year;
            $pass     = Hash::make($password);

            $newUser = new User([
                'name'          => $row['ho_va_ten'],
                'email'         => $row['email'],
                'password'      => $pass,
                'code_user'     => $row['ma_sinh_vien'],
                'address'       => $row['dia_chi'],
                'phone'         => $row['so_dien_thoai'],
                'sex'           => $row['gioi_tinh'],
                'date_of_birth' => $time,
            ]);

            return $newUser->assignRole($row['vai_tro']);
        }
    }

    public function rules(): array
    {
        return [
            "*.ho_va_ten"    => "required",
            '*.email'        => "required",
            "*.ma_sinh_vien" => "required",
            "*.ngay_sinh"    => "required",
            "*.vai_tro"      => "required",
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ho_va_ten.required'    => 'Họ và tên không được bỏ trống',
            'email.required'        => 'Email không được bỏ trống',
            'ma_sinh_vien.required' => 'Mã sinh viên không được bỏ trống',
            'ngay_sinh.required'    => 'Ngày sinh không được bỏ trống',
            'vai_tro.required'      => 'Ngày sinh không được bỏ trống',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

}
