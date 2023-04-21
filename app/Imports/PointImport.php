<?php

namespace App\Imports;

use App\Models\Class_HP;
use App\Models\ClassUser;
use App\Models\Point;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PointImport implements ToModel, WithHeadingRow, WithChunkReading, SkipsEmptyRows, WithValidation, SkipsOnFailure
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
        $user  = User::query()->where('code_user', $row['ma_sinh_vien'])->first();
        $class = Class_HP::query()->where('code_class', $row['ma_lop_hoc_phan'])->first();

        if (!$user) {
            $error       = [
                'err' => ["Mã sinh viên: " . $row['ma_sinh_vien'] . " không tồn tại!"],
                "row" => $row['stt']
            ];
            $this->Err[] = $error;
        }
        if (!$class) {
            $error       = [
                'err' => ["Lớp học phần " . $row['ma_lop_hoc_phan'] . " không tồn tại!"],
                "row" => $row['stt']
            ];
            $this->Err[] = $error;
        }

        if ($user && $class) {
            $point = Point::query()->where('id_user', $user['id'])->where('id_class', $class['id'])->first();
            if ($point) {
                $error       = [
                    'err' => ["Đã tồn tại điểm của sinh viên cho lớp học phần này: " . $row['ma_sinh_vien'] . " - " . $row['ma_lop_hoc_phan']],
                    "row" => $row['stt']
                ];
                $this->Err[] = $error;
            }

            $user_in_class = ClassUser::query()->where('id_user', $user['id'])->where('id_class', $class['id'])->first();
            if (!$user_in_class) {
                $error       = [
                    'err' => ["Sinh viên: " . $row['ma_sinh_vien'] . " - không có trong lớp học phần: " . $row['ma_lop_hoc_phan']],
                    "row" => $row['stt']
                ];
                $this->Err[] = $error;
            }

            if (Point::query()->where('id_user', $user['id'])->where('id_class', $class['id'])->doesntExist()
                && User::query()->where('code_user', $row['ma_sinh_vien'])->exists()
                && Class_HP::query()->where('code_class', $row['ma_lop_hoc_phan'])->exists()
                && ClassUser::query()->where('id_user', $user['id'])->where('id_class', $class['id'])->exists()) {
                return new Point([
                    'score_component' => $row['diem_thanh_phan'],
                    'score_test'      => $row['diem_thi'],
                    'score_final'     => $row['diem_tong_ket'],
                    'id_user'         => $user['id'],
                    'id_class'        => $class['id'],
                ]);
            }
        }
    }

    public function rules(): array
    {
        return [
            "*.diem_thanh_phan" => "required",
            '*.diem_thi'        => "required",
            "*.diem_tong_ket"   => "required",
            "*.ma_sinh_vien"    => "required",
            "*.ma_lop_hoc_phan" => "required",
        ];
    }

    public function customValidationMessages()
    {
        return [
            'diem_thanh_phan.required' => 'Điểm thành phần không được bỏ trống',
            'diem_thi.required'        => 'Điểm thi không được bỏ trống',
            'diem_tong_ket.required'   => 'Điểm tổng kết không được bỏ trống',
            'ma_sinh_vien.required'    => 'Mã sinh viên không được bỏ trống',
            'ma_lop_hoc_phan.required' => 'Mã lớp học phần không được bỏ trống',
        ];
    }

    public function chunkSize(): int
    {
        return 500;
    }

}
