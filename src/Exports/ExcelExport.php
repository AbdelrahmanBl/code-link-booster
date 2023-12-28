<?php

namespace CodeLink\Booster\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelExport implements FromCollection, WithHeadings, WithMapping
{
    public $collect;
    public $thead;
    public $map;

    /**
     * @return \Illuminate\Support\Collection
     * $map=[
     *  'column_name' => user.name // default column name
     *  'column_name' => fn($i) => $i->name
     */
    public function __construct($collect, $map, $thead = [])
    {
        $this->collect = $collect;
        $header = [];
        $maps = [];
        foreach ($map as $key => $value) {
            $header[] = __('base.' . (is_int($key) ? $value : $key));
            if (is_array($value)){
                $maps[] = [...$value,'key'=>$key];
            }else{
                $maps[] = $value;
            }
        }
        $this->thead = empty($thead) ? $header : $thead;
        $this->map = $maps;
    }

    public function collection()
    {
        return $this->collect;
    }

    public function headings(): array
    {
        return $this->thead;
    }

    public function map($item): array
    {
        $row = [];

        foreach ($this->map as $c) {
            $z = $item;

            if (is_callable($c)){
                // callback to transform column value
                $z = call_user_func($c, $z);
            }

            else {
                foreach ((explode('.', $c)) as $t) {
                    $z = $z[$t] ?? null;
                    if (is_bool($z)) {
                        $z = ($z == 1 ? '✔' : '✖');
                    }
                    /*
                     * to solve problem when cast enum in model
                     * */
                    if (gettype($z) === 'object') {
                        if (isset($z->value))
                            $z = $z->value;
                    }
                }
            }

            $row[] = $z;
        }

        return $row;
    }
}
