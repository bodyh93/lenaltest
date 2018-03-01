<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DatesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->year && $request->month && $request->day) {
            $checkDateResult = self::checkDate((int)$request->year, (int)$request->month, (int)$request->day);
            if ($checkDateResult !== true) {
                return response()->json(['fail' => $checkDateResult]);
            }
            return $next($request);
        }
        return response()->json(['fail' => true]);
    }

    public static function checkDate($year, $month, $day)
    {
        $yearOk = $monthOk = $dayOk = false;
        $daysInMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if (0 < $year && $year < 3000) {
            $yearOk = true;
        }
        if (0 < $month && $month < 13) {
            $monthOk = true;
            if (0 < $day && $day < $daysInMonth[$month - 1]) {
                $dayOk = true;
                if ($month === 2 && $day === 29) {
                    $yearIsLeap = date('L', mktime(0, 0, 0, 1, 1, $year));
                    if (!$yearIsLeap) {
                        $dayOk = false;
                    }
                }
            }
        }
        if ($yearOk && $monthOk && $dayOk)
            return true;
        return compact('yearOk', 'monthOk', 'dayOk');
    }
}
