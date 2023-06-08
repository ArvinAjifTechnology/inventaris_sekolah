<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Borrow;

class RevenueChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build()
    {
        //     $pending = $borrows->where('borrow_status', 'pending')->count();
        //     $borrowed = $borrows->where('borrow_status', 'borrowed')->count();
        //     $completed = $borrows->where('borrow_status', 'completed')->count();
        // // dd($data);
        // return $this->chart->lineChart()
        //     ->setTitle('Count Of Borrowed')
        //     ->setSubtitle(date('Y'))
        //     ->addData('Borrow Status',[$pending, $borrowed, $completed])
        //     ->setLabels(['Pending', 'Borrowed', 'Completed']);
        $startDate = now()->subMonth()->startOfMonth();
        $endDate = now()->endOfDay();
        $borrows = Borrow::whereBetween('created_at', [$startDate, $endDate])->get();

        $data = $borrows->groupBy(function ($item) {
            return $item->created_at->toDateString();
        })->map(function ($group) {
            return $group->sum('sub_total');
        })->toArray();

        $revenueData = array_values($data);
        // Preprocess the data to convert it to the desired format
        $formattedRevenueData = array_map(function ($value) {
            return 'Rp ' . number_format($value, 0, ',', '.');
        }, $revenueData);

        $revenueChart = $this->chart->lineChart()
            ->setTitle('Revenue')
            ->setSubtitle(date('Y'))
            ->addData('Revenue', $revenueData)
            ->setLabels(convertToRupiah(array_keys($data)));

        // Convert sub_total values to rupiah format
        // $revenueChart->dataset('Revenue', 'line', $revenueData)
        //     ->options([
        //         'tooltip' => [
        //             'callbacks' => [
        //                 'label' => 'function(tooltipItem, data) {
        //             var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || "";
        //             var label = data.labels[tooltipItem.index];
        //             var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
        //             if (datasetLabel) {
        //                 label += ": " + convertToRupiah(value);
        //             }
        //             return label;
        //         }'
        //             ]
        //         ]
        //     ]);

        return $revenueChart;
    }
}
