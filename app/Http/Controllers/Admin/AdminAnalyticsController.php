<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsEvent;
use Illuminate\Http\Request;

class AdminAnalyticsController extends Controller
{
    public function index()
    {
        return view('admin.analytics.index');
    }

    public function realtime()
    {
        $since = now()->subMinutes(60);
        $active = AnalyticsEvent::ofType('pageview')
            ->where('created_at', '>=', $since)
            ->count();

        $locations = AnalyticsEvent::ofType('pageview')
            ->where('created_at', '>=', $since)
            ->whereNotNull('country')
            ->distinct('country')
            ->orderByDesc('created_at')
            ->limit(5)
            ->pluck('country')
            ->unique()
            ->values();

        return response()->json([
            'active'    => $active,
            'locations' => $locations,
        ]);
    }

    public function data(Request $request)
    {
        $period = $request->input('period', '30');
        $from   = match($period) {
            '7'      => now()->subDays(6)->startOfDay(),
            '30'     => now()->subDays(29)->startOfDay(),
            '365'    => now()->subDays(364)->startOfDay(),
            'custom' => \Carbon\Carbon::parse($request->input('from'))->startOfDay(),
            default  => now()->subDays(29)->startOfDay(),
        };
        $to = $period === 'custom'
            ? \Carbon\Carbon::parse($request->input('to'))->endOfDay()
            : now()->endOfDay();

        $types = ['pageview', 'wa_click'];
        $summary = [];
        foreach ($types as $type) {
            $summary[$type] = AnalyticsEvent::ofType($type)->whereBetween('created_at', [$from, $to])->count();
        }

        $leadsCount = \App\Models\Lead::whereBetween('created_at', [$from, $to])->count();
        $summary['leads'] = $leadsCount;
        $summary['ctr'] = $summary['pageview'] > 0 ? round(($leadsCount / $summary['pageview']) * 100, 2) : 0;

        // Daily chart pageviews
        $daily = AnalyticsEvent::ofType('pageview')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->orderBy('date')
            ->pluck('count', 'date');

        // Daily chart wa clicks
        $waDaily = AnalyticsEvent::ofType('wa_click')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->orderBy('date')
            ->pluck('count', 'date');

        // Daily chart leads
        $leadsDaily = \App\Models\Lead::whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->orderBy('date')
            ->pluck('count', 'date');

        $days   = (int) $from->diffInDays($to) + 1;
        $labels = [];
        $visitorValues = [];
        $waValues = [];
        $leadsValues = [];
        for ($i = 0; $i < $days; $i++) {
            $date     = $from->copy()->addDays($i)->format('Y-m-d');
            $labels[] = $from->copy()->addDays($i)->format('d/m');
            $visitorValues[] = $daily[$date] ?? 0;
            $waValues[] = $waDaily[$date] ?? 0;
            $leadsValues[] = $leadsDaily[$date] ?? 0;
        }

        // Device breakdown
        $devices = AnalyticsEvent::ofType('pageview')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('device_type, COUNT(*) as count')
            ->groupBy('device_type')
            ->pluck('count', 'device_type');

        // Top pages
        $topPages = AnalyticsEvent::ofType('pageview')
            ->whereBetween('created_at', [$from, $to])
            ->selectRaw('page_url, COUNT(*) as views')
            ->groupBy('page_url')
            ->orderByDesc('views')
            ->limit(10)
            ->get();

        // Top Locations
        $locations = AnalyticsEvent::ofType('pageview')
            ->whereBetween('created_at', [$from, $to])
            ->whereNotNull('country')
            ->selectRaw('country, COUNT(*) as count')
            ->groupBy('country')
            ->orderByDesc('count')
            ->limit(10)
            ->pluck('count', 'country');

        return response()->json([
            'summary'   => $summary,
            'labels'    => $labels,
            'visitorValues' => $visitorValues,
            'waValues'      => $waValues,
            'leadsValues'   => $leadsValues,
            'devices'   => $devices,
            'top_pages' => $topPages,
            'locations' => $locations,
        ]);
    }

    public function exportXls(Request $request)
    {
        if (!$request->start_date || !$request->end_date) {
            return back()->with('error', 'Silakan filter periode tanggal terlebih dahulu sebelum men-download laporan.');
        }

        $from = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $to   = \Carbon\Carbon::parse($request->end_date)->endOfDay();
        $days = (int) $from->diffInDays($to) + 1;

        $pageviews = AnalyticsEvent::ofType('pageview')->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->pluck('count', 'date');
            
        $waClicks = AnalyticsEvent::ofType('wa_click')->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->pluck('count', 'date');

        $leads = \App\Models\Lead::whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->pluck('count', 'date');

        $filename = "Laporan_Cyclevent_{$from->format('Ymd')}_{$to->format('Ymd')}.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($days, $from, $pageviews, $waClicks, $leads) {
            $file = fopen('php://output', 'w');
            
            // Watermark / Info
            fputcsv($file, ['Generated By:', 'System hvmdigital.id']);
            fputcsv($file, ['Periode:', $from->format('d/M/Y') . ' - ' . $from->copy()->addDays($days-1)->format('d/M/Y')]);
            fputcsv($file, []);

            fputcsv($file, ['Tanggal', 'Bulan', 'Tahun', 'Visitor', 'Klik WA', 'Leads', 'CTR (%)']);

            for ($i = 0; $i < $days; $i++) {
                $dateObj = $from->copy()->addDays($i);
                $dateStr = $dateObj->format('Y-m-d');

                $v = $pageviews[$dateStr] ?? 0;
                $w = $waClicks[$dateStr] ?? 0;
                $l = $leads[$dateStr] ?? 0;
                $c = $v > 0 ? round(($l / $v) * 100, 2) : 0;

                fputcsv($file, [
                    $dateObj->format('d'),
                    $dateObj->format('M'),
                    $dateObj->format('Y'),
                    $v,
                    $w,
                    $l,
                    $c
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        if (!$request->start_date || !$request->end_date) {
            return back()->with('error', 'Silakan filter periode tanggal terlebih dahulu sebelum men-download laporan.');
        }

        $from = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $to   = \Carbon\Carbon::parse($request->end_date)->endOfDay();
        $days = (int) $from->diffInDays($to) + 1;

        $pageviews = AnalyticsEvent::ofType('pageview')->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->pluck('count', 'date');
            
        $waClicks = AnalyticsEvent::ofType('wa_click')->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->pluck('count', 'date');

        $leads = \App\Models\Lead::whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')->pluck('count', 'date');

        $data = [];
        $totals = ['v' => 0, 'w' => 0, 'l' => 0];

        for ($i = 0; $i < $days; $i++) {
            $dateObj = $from->copy()->addDays($i);
            $dateStr = $dateObj->format('Y-m-d');

            $v = $pageviews[$dateStr] ?? 0;
            $w = $waClicks[$dateStr] ?? 0;
            $l = $leads[$dateStr] ?? 0;
            $c = $v > 0 ? round(($l / $v) * 100, 2) : 0;

            $totals['v'] += $v;
            $totals['w'] += $w;
            $totals['l'] += $l;

            $data[] = [
                'date' => $dateObj->format('d/m/Y'),
                'tgl'  => $dateObj->format('d'),
                'bln'  => $dateObj->format('M'),
                'thn'  => $dateObj->format('Y'),
                'v'    => $v,
                'w'    => $w,
                'l'    => $l,
                'c'    => $c
            ];
        }

        $totals['c'] = $totals['v'] > 0 ? round(($totals['l'] / $totals['v']) * 100, 2) : 0;

        return view('admin.exports.analytics_pdf', compact('data', 'totals', 'from', 'to'));
    }
}
