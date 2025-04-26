<?php

namespace App\Exports;

use App\Models\Paguyuban;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PaguyubanExport implements WithMultipleSheets
{
    protected $paguyuban;

    public function __construct(Paguyuban $paguyuban)
    {
        $this->paguyuban = $paguyuban;
    }

    public function sheets(): array
    {
        return [
            new ProductsSheet($this->paguyuban),
            new SummarySheet($this->paguyuban),
        ];
    }
}

class ProductsSheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    protected $paguyuban;

    public function __construct(Paguyuban $paguyuban)
    {
        $this->paguyuban = $paguyuban;
    }

    public function collection()
    {
        return $this->paguyuban->products()
            ->select('products.id', 'products.name', 'products.price', 'products.image')
            ->withPivot('price as special_price')
            ->get()
            ->map(function ($product) {
                $discount = $product->price > 0 
                    ? round(100 - ($product->special_price / $product->price * 100), 2)
                    : 0;
                    
                return [
                    'ID' => $product->id,
                    'Product Name' => $product->name,
                    'Regular Price' => 'Rp ' . number_format($product->price, 0, ',', '.'),
                    'Special Price' => 'Rp ' . number_format($product->special_price, 0, ',', '.'),
                    'Discount' => $discount . '%',
                    'Savings' => 'Rp ' . number_format($product->price - $product->special_price, 0, ',', '.'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Nama Produk',
            'Harga Normal',
            'Harga Khusus',
            'Diskon',
            'Total Hemat'
        ];
    }

    public function title(): string
    {
        return 'Produk Khusus';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            'A:F' => ['alignment' => ['horizontal' => 'center']],
        ];
    }
}

class SummarySheet implements FromCollection, WithHeadings, WithTitle, WithStyles, ShouldAutoSize
{
    protected $paguyuban;

    public function __construct(Paguyuban $paguyuban)
    {
        $this->paguyuban = $paguyuban;
    }

    public function collection()
    {
        $totalProducts = $this->paguyuban->products()->count();
        $discountedProducts = $this->paguyuban->products()
            ->whereColumn('paguyuban_product.price', '<', 'products.price')
            ->count();
            
        $averageDiscount = $this->paguyuban->products()
            ->whereColumn('paguyuban_product.price', '<', 'products.price')
            ->selectRaw('AVG((1 - (paguyuban_product.price / products.price)) * 100) as avg_discount')
            ->value('avg_discount') ?? 0;
        
        return collect([
            ['Informasi Paguyuban', ''],
            ['Nama Paguyuban', $this->paguyuban->name],
            ['Status', $this->paguyuban->is_active ? 'Aktif' : 'Tidak Aktif'],
            ['Tanggal Dibuat', $this->paguyuban->created_at->format('d-m-Y H:i')],
            ['', ''],
            ['Statistik Produk', ''],
            ['Total Produk Khusus', $totalProducts],
            ['Produk Diskon', $discountedProducts],
            ['Rata-rata Diskon', round($averageDiscount, 2) . '%'],
        ]);
    }

    public function headings(): array
    {
        return [
            'Keterangan',
            'Nilai'
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
            6 => ['font' => ['bold' => true]],
            'A:B' => ['alignment' => ['horizontal' => 'left']],
        ];
    }
}