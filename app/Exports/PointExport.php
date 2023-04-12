<?php

namespace App\Exports;

use App\Models\Point;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PointExport implements FromQuery, Responsable, WithHeadings, WithColumnWidths
{
    use Exportable;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $list = Point::query()->join('users', 'points.id_user', '=', 'users.id')
            ->join('classes', 'classes.id', '=', 'points.id_class')
            ->select('users.name as name_user', 'users.code_user', 'classes.name_class', 'classes.code_class',
                'points.score_component', 'points.score_test', 'points.score_final');

        if ($this->request->query('code_user')) {
            $list = $list->where('code_user', $this->request->query('code_user'));
        }
        if ($this->request->query('id_class')) {
            $list = $list->where('id_class', $this->request->query('id_class'));
        }

        return $list;
    }

    public function headings(): array
    {
        return [
            'Tên sinh viên',
            'Mã sinh viên',
            'Tên lớp học phần',
            'Mã lớp học phần',
            'Điểm thành phần',
            'Điểm thi',
            'Điểm tổng kết'
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 20,
            'C' => 30,
            'D' => 20,
            'E' => 15,
            'F' => 15,
            'G' => 15,
        ];
    }

}
