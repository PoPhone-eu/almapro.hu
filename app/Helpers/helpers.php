<?php

use Carbon\Carbon;
use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\PaymentType;
use App\Models\SiteSetting;
use App\Models\UserCompany;
use App\Models\UserPayment;
use Illuminate\Support\Arr;
use App\Models\CustomerTask;
use App\Models\CompanySetting;
use App\Models\WebsiteSetting;
use App\Models\ProductAttribute;
use App\Mail\MessageNotification;
use App\Models\CustomerTaskSchema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Facades\Crypt;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


/**
 * @param string $model
 * @param string $column
 * @param int $length
 * @return mixed
 */
function generateUniqueString()
{
    $column = 'uuid';
    $model = new UserPayment;
    $uuid = mt_rand(100000000000, 999999999999);

    while ($model->where($column, '=', $uuid)->count() > 0) {
        $uuid = mt_rand(100000000000, 999999999999);
    }
    return $uuid;
}

function getSetiSetting()
{
    return SiteSetting::first();
}

function getUserPointModel($user_id)
{
    $user = User::find($user_id);
    $userPoint = $user->userPoints()->orderBy('created_at', 'desc')->first();
    return $userPoint;
}

function getUserPoints($user_id)
{
    $points = 0;
    $user = User::find($user_id);
    // find last userPoint model:
    $lastUserPoint = $user->userPoints()->orderBy('created_at', 'desc')->first();
    if ($lastUserPoint != null) {
        $points = $lastUserPoint->points;
    }
    return $points;
}

function getRatingPercentage($value)
{
    return round($value / 5.0 * 100, 1);
}

function getApprovedRating($user_id)
{
    // get avarage rating using laravel eloquent avg
    $rating = DB::table('reviews')->where('reviewrateable_id', $user_id)->where('approved', true)->avg('rating');
    if ($rating == null) return 0;
    return DB::table('reviews')->where('reviewrateable_id', $user_id)->where('approved', true)->avg('rating');
}

function countRating($user_id)
{
    return DB::table('reviews')->where('reviewrateable_id', $user_id)->where('approved', true)->count();
}

function pretty_print($value)
{
    if (is_float($value)) {
        $temp = number_format($value, 0);
        return str_replace(',', ' ', $temp);
    }
    return $value;
}

function getPositionForModelSingle($Model)
{
    $nameSpace = '\\App\\Models\\';
    $Model = $nameSpace . $Model;
    $model = $Model::orderBy('position', 'desc')->first();

    if ($model) {
        $position = $model->position + 1;
    } else {
        $position = 1;
    }
    return $position;
}

function generateYears($company)
{
    $years = [];
    $intervalFirst = $company->companyfolders()->orderBY('start_date', 'asc')->first();
    $intervalLast = $company->companyfolders()->orderBY('start_date', 'desc')->first();
    if ($intervalFirst == null) {
        $years[0] = Carbon::now()->format('Y');
        return $years;
    } elseif ($intervalFirst->start_date == $intervalLast->start_date) {
        $years[0] = Carbon::parse($intervalFirst->start_date)->format('Y');
        return $years;
    }
    $start = Carbon::parse($intervalFirst->start_date)->format('Y');
    $end = Carbon::parse($intervalLast->start_date)->format('Y');

    for ($i = $start; $i < $end + 1; $i++) {
        $years[$i] = $i;
    }
    return $years;
}

/**
 * getPositionForModel
 *
 * @param  mixed $Model
 * @return void
 */
function getPositionForModel($Model)
{
    $nameSpace = '\\App\\Models\\';
    $Model = $nameSpace . $Model;
    $model = $Model::orderBy('position', 'desc')->first();

    if ($model) {
        $position = $model->position + 1;
    } else {
        $position = 1;
    }
    return $position;
}

/**
 * urlValidation
 *
 * @param  mixed $file
 * @return Boolean
 */
function urlValidation($file)
{
    $file_headers = @get_headers($file);
    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
        return false;
    }
    return  true;
}

/**
 * getMonthlyLabels
 *
 * @param  mixed $from
 * @param  mixed $to
 * @return void
 */
function getMonthlyLabels(Carbon $from, Carbon $to)
{

    $dates = generateDateRange($from, $to);
    return $dates;
}

/**
 * generateDateRange
 *
 * @param  mixed $start_date
 * @param  mixed $end_date
 * @return void
 */
function generateDateRange(Carbon $start_date, Carbon $end_date)
{

    $dates = [];

    for ($date = $start_date; $date->lte($end_date); $date->addDay()) {

        $dates[] = $date->format('Y-m-d');
    }

    return $dates;
}

/**
 * @param mixed $start
 * @param mixed $end
 * @return array
 */
function generateWeekLabels($start, $end)
{

    $Labels = [];

    for ($i = $start - 1; $i < $end + 1; $i++) {

        $Labels[] = $i;
    }

    return $Labels;
}

/**
 * @param mixed $stat
 * @return array
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function generateWeekyLabels($stat)
{
    $Labels = [];

    foreach ($stat as $value => $item) {
        $Labels[]  = Carbon::parse($item->date_month)->format('Y-m-d');
    }
    return Arr::flatten($Labels);
}

/** @return array  */
function generateWeekLabelsForYear()
{

    $Labels = [];

    for ($i = 1; $i < 53; $i++) {

        $Labels[] = $i;
    }

    return $Labels;
}

/**
 * @param mixed $stat
 * @return array
 */
function generateIndividualStatData($stat)
{
    $data = [];
    foreach ($stat as $item) {
        $data[] = $item->value;
    }
    return $data;
}

/**
 * @param mixed $stat
 * @return array
 */
function generateQuarterLabels($stat)
{
    $data = [];
    foreach ($stat as $item) {
        $data[] = $item->week;
    }
    return $data;
}

/**
 * @param mixed $stat
 * @return array
 */
function generateWeeklyData($stat)
{
    $data = [];

    foreach ($stat as $item) {
        $data[]  = trimLeftRightSpace($item->value);
    }
    return $data;
}

/**
 * @param mixed $stat
 * @param mixed $period
 * @return array
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function generateLabels($stat, $period)
{
    $data = [];

    if ($period == 'daily') {
        foreach ($stat as $item) {
            $data[]  = Carbon::parse($item->date_month)->format('Y-m-d');
        }
        return $data;
    } else {
        foreach ($stat as $item) {
            $data[]        = $item->week;
        }
    }
    return $data;
}

/**
 * @param int $count
 * @return array
 */
function generateWeeklyLabels($count = 52)
{
    $data = [];
    for ($i = 0; $i < $count; $i++) {
        $data[]   = $i + 1;
    }
    return $data;
}

/**
 * @param int $count
 * @return array
 */
function generateMonthlyLabels($count = 12)
{
    $data = [];
    for ($i = 0; $i < $count; $i++) {
        $data[]        = $i + 1;
    }
    return $data;
}

/**
 * @return void
 * @throws \InvalidArgumentException
 */
function initSetings()
{
    $CompanySetting = new CompanySetting();
    $CompanySetting->company_name  = 'Company name';
    $CompanySetting->save();
}

function storageSize()
{
    $file_size = 0;
    foreach (File::allFiles(storage_path('app/public')) as $file) {
        $file_size += $file->getSize();
    }
    $file_size = $file_size / 1048576;
    return $file_size;
}

/** @return int|float  */
function freeDiskSpace()
{
    $df = disk_free_space($_SERVER['DOCUMENT_ROOT']);
    $file_size = $df / 1048576;
    return $file_size;
}

/** @return int|float  */
function totalDiskSpace()
{
    $df = disk_total_space($_SERVER['DOCUMENT_ROOT']);
    $file_size = $df / 1048576;
    return $file_size;
}

/** @return int|float  */
function usedDiskSpace()
{
    $file_size = totalDiskSpace() - freeDiskSpace();
    return $file_size;
}

/**
 * @param string $string
 * @return string
 */
function trimLeftRightSpace(string $string)
{
    $trim1 = trim($string);
    return rtrim($trim1);
}

function sendNotification($user, $sender, $from, $subject)
{
    /*  try {
        Mail::to($user)->send(new MessageNotification($from, $subject));
    } catch (\Exception $exception) {
        \Log::error($exception);
    } */
}

function deleteFileByID($file_id)
{
    $media = Media::find($file_id);
    if ($media == null) return null;
    $model = Product::find($media->model_id);
    $model->deleteMedia($media->id);
}

function changeFileNameByID($file_id, $filename)
{
    $media = Media::find($file_id);
    $filename = str_replace(['#', '/', '\\', ' '], '-', $filename);
    $media->name = $filename;
    $media->file_name = $filename;
    $media->save();
}

function createNewTask($Schedule)
{
    $saved                      = new Schedule();
    $saved->subject             = $Schedule->subject;
    $saved->body                = $Schedule->body;
    $saved->recurrent_type      = $Schedule->recurrent_type;

    if ($Schedule->recurrent_type == 'single') {
        $saved->recurrent       = false;
    } else {
        $saved->recurrent       = true;
    }

    $saved->start       = calculateStartDate($Schedule->start, $Schedule->recurrent_type);
    $saved->priority    = $Schedule->priority;

    if (isset($Schedule->reminder_sameday)) $saved->reminder_sameday     = $Schedule->reminder_sameday;
    if (isset($Schedule->reminder_days)) $saved->reminder_days           = $Schedule->reminder_days;

    if (isset($Schedule->reminder_days) && $Schedule->reminder_days != null) $saved->reminder = Carbon::parse($saved->start)->addDays(-$Schedule->reminder_days)->format('Y-m-d');
    if (isset($Schedule->customer_id) && $Schedule->customer_id != null) {
        $customer               = UserCompany::find($Schedule->customer_id);

        if ($customer != null) {
            $saved->customer_id     = $Schedule->customer_id;
            $saved->customer_name   = $customer->company_name;
        }
    }
    $saved->user_id   = Auth::user()->id;
    $saved->save();
}

function calculateStartDate($start, $recurrent_type)
{
    switch ($recurrent_type) {
        case 'weekly':
            return Carbon::parse($start)->addDays(7)->format('Y-m-d');
            break;
        case 'monthly':
            $myDateTimeISO = Carbon::parse($start)->format('Y-m-d');
            $addThese = 1;
            $myDateTime = new DateTime($myDateTimeISO);
            $myDayOfMonth = date_format($myDateTime, 'j');
            date_modify($myDateTime, "+$addThese months");

            //Find out if the day-of-month has dropped
            $myNewDayOfMonth = date_format($myDateTime, 'j');
            if ($myDayOfMonth > 28 && $myNewDayOfMonth < 4) {
                //If so, fix by going back the number of days that have spilled over
                date_modify($myDateTime, "-$myNewDayOfMonth days");
            }
            return Carbon::parse($myDateTime)->format('Y-m-d');

            break;
        case 'quarterly':
            $thisQuarter = Carbon::parse($start)->endOfQuarter();
            return Carbon::parse($thisQuarter)->addDays(15)->format('Y-m-d');
            break;
        case 'yearly':

            return Carbon::parse($start)->addYear(1)->format('Y-m-d');
            break;

        default:
            return Carbon::parse($start)->addDays(7)->format('Y-m-d');
            break;
    }
}

// year format: $year = Carbon::now()->format('Y');
// Quarter 1
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter1Start($year)
{
    return Carbon::createMidnightDate($year, 1, 1);
}
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter1End($year)
{
    return Carbon::createMidnightDate($year, 3, 31);
}
// Quarter 2
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter2Start($year)
{
    return Carbon::createMidnightDate($year, 4, 1);
}
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter2End($year)
{
    return Carbon::createMidnightDate($year, 6, 30);
}
// Quarter 3
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter3Start($year)
{
    return Carbon::createMidnightDate($year, 7, 1);
}
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter3End($year)
{
    return Carbon::createMidnightDate($year, 9, 30);
}
// Quarter 4
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter4Start($year)
{
    return Carbon::createMidnightDate($year, 10, 1);
}
/**
 * @param mixed $year
 * @return \Illuminate\Support\Carbon
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function getQuarter4End($year)
{
    return Carbon::createMidnightDate($year, 12, 31);
}

/**
 * @param string $type
 * @return string
 */
function reminder_days_text(string $type)
{
    $reminder_days_text = '';
    switch ($type) {
        case null:
            $reminder_days_text = 'Hány nappal előtte menjen a figyelmeztetés';
            break;
        case 'Egyszeri feladat':
            $reminder_days_text = 'Hány nappal előtte menjen a figyelmeztetés';
            break;

        case 'Havi':
            //$reminder_days_text = 'Ismétlődés napja* (hányadikára essen)';
            $reminder_days_text = 'Hány nappal előtte menjen a figyelmeztetés';
            break;

        case 'Negyedéves':
            $reminder_days_text = 'Hány nappal előtte menjen a figyelmeztetés';
            break;

        case 'Féléves':
            $reminder_days_text = 'Hány nappal előtte menjen a figyelmeztetés';
            break;

        case 'Éves':
            $reminder_days_text = 'Hány nappal előtte menjen a figyelmeztetés';
            break;

        default:
            $reminder_days_text = 'Ismétlődés napja* (hányadikára essen)';
            break;
    }
    return $reminder_days_text;
}

/**
 * @param mixed $start
 * @param mixed $reminder_days
 * @param mixed $recurrent_type
 * @return string
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function reminder_date_calculation($start, $reminder_days, $recurrent_type)
{
    /* $date = null;
  switch ($recurrent_type) {
    case 'Egyszeri feladat':
      $date = Carbon::parse($start)->addDays(-$reminder_days)->format('Y-m-d');
      Log::info($recurrent_type);
      break;

    case 'Havi':
      $date = Carbon::parse($start)->addDays(-$reminder_days)->format('Y-m-d');
      break;

    case 'Negyedéves':
      $date = Carbon::parse($start)->addDays(-$reminder_days)->format('Y-m-d');
      break;

    case 'Féléves':
      $date = Carbon::parse($start)->addDays(-$reminder_days)->format('Y-m-d');
      break;

    case 'Éves':
      $date = Carbon::parse($start)->addDays(-$reminder_days)->format('Y-m-d');
      break;

    default:
      $date = Carbon::parse($start)->addDays(-$reminder_days)->format('Y-m-d');
      break;
  } */

    return Carbon::parse($start)->addDays(-$reminder_days)->format('Y-m-d');
}

/**
 * @param mixed $recurrent_type
 * @return string
 * @throws \Carbon\Exceptions\InvalidFormatException
 */
function calculateStartDay($recurrent_type, $starting_date = null)
{
    $start = null;
    if ($starting_date == null) $starting_date = Carbon::now();
    switch ($recurrent_type) {
        case 'Havi':
            $start            = $starting_date->startOfMonth()->addMonth(1)->format('Y-m-d');
            break;
        case 'Negyedéves':
            $selectedYearOrig = Carbon::now()->format('Y');
            $selectedYear     = Carbon::parse($selectedYearOrig);
            $quarterNumber = $selectedYear->quarter;
            $year = $selectedYear->format('Y');
            if ($quarterNumber == 1) $start = getQuarter1Start($year);
            if ($quarterNumber == 2) $start = getQuarter2Start($year);
            if ($quarterNumber == 3) $start = getQuarter3Start($year);
            if ($quarterNumber == 4) $start = getQuarter4Start($year);
            $start = Carbon::parse($start)->format('Y-m-d');
            break;
        case 'Féléves':
            $firstHalf = Carbon::now()->startOfYear();
            $secondHalf = Carbon::now()->startOfYear()->addMonth(5);
            if (Carbon::now() < $secondHalf) {
                $start            = Carbon::now()->startOfYear()->format('Y-m-d');
            } else {
                $start            = Carbon::now()->startOfYear()->addMonth(5)->format('Y-m-d');
            }
            break;
        case 'Éves':
            $start = Carbon::now()->startOfYear()->format('Y-m-d');
            break;
        default:
            $start            = Carbon::now()->startOfMonth()->addMonth(1)->format('Y-m-d');
            break;
    }
    return $start;
}

/**
 * @param int $companytaskID
 * @param string $reminder_status
 * @return void
 */
function reminderChange(int $companytaskID, string $reminder_status)
{
    $task = CustomerTask::find($companytaskID);
    if ($reminder_status == '1') {
        $task->reminder = true;
    } else {
        $task->reminder = false;
    }
    $task->save();
}

/**
 * @param int $companytaskID
 * @return void
 */
function finishedChange(int $companytaskID)
{
    $task = CustomerTask::find($companytaskID);
    if ($task->is_finished == false) {
        $task->is_finished  = true;
        $task->reminder     = false;
        $task->is_late      = false;
        $task->save();
        if ($task->recurrent == true) createNewCustomerTask($task);
    }
}

function createNewCustomerTask(CustomerTask $task)
{
    $task_schema = null;
    if ($task->customer_task_schema_id != null) $task_schema = CustomerTaskSchema::find($task->customer_task_schema_id);

    $newTask                  = $task->replicate();
    $newTask->created_at      = Carbon::now();
    $newTask->updated_at      = null;
    if ($task_schema != null) {
        $newTask->amount            = $task_schema->amount;
        $newTask->name              = $task_schema->schema_name;
        $newTask->description       = $task_schema->description;
        $newTask->recurrent_type    = $task_schema->recurrent_type;
        $newTask->reminder_days     = $task_schema->reminder_days;
    }
    $newTask->start           = calculateNewStartDay($newTask);
    $newTask->reminder_date   = reminder_date_calculation($newTask->start, $newTask->reminder_days, $newTask->recurrent_type);
    $newTask->is_finished     = false;
    if ($task->recurrent == true) {
        $newTask->reminder        = true;
    } else {
        $newTask->reminder        = false;
    }
    $newTask->save();
    if ($newTask->amount != null) {
        saveNewPayment(
            $newTask->amount,
            $newTask->payment_type,
            $task->start,
            Carbon::now(),
            $task->user_company_id,
            $task->user_company_name,
            $newTask->name,
            $newTask->description
        );
    }
}

function saveNewPayment($amount, $payment_type, $payment_due, $payment_date, $user_company_id, $user_company_name, $name = null, $description = null)
{
    $payment                      = new Payment();
    $payment->amount              = $amount;
    $payment->description         = $name . ' ' . $description;
    $payment->payment_type        = $payment_type;
    $payment->payment_due         = $payment_due;
    $payment->payment_date        = $payment_date;
    $payment->user_company_id     = $user_company_id;
    $payment->user_company_name   = $user_company_name;
    $payment->save();
}

function calculateNewStartDay(CustomerTask $task)
{
    $start = null;
    $recurrent_type = $task->recurrent_type;
    switch ($recurrent_type) {
        case 'Havi':
            $start = Carbon::parse($task->start)->addMonth(1)->format('Y-m-d');
            break;
        case 'Negyedéves':
            $start = Carbon::parse($task->start)->addMonth(4)->format('Y-m-d');
            break;
        case 'Féléves':
            $start = Carbon::parse($task->start)->addMonth(6)->format('Y-m-d');
            break;
        case 'Éves':
            $start = Carbon::parse($task->start)->addMonth(12)->format('Y-m-d');
            break;
        default:
            $start = Carbon::parse($task->start)->addMonth(1)->format('Y-m-d');
            break;
    }
    return $start;
}

/* function getPdfVersion($srcfile)
{
  $filepdf = fopen($srcfile, "r");
  if ($filepdf) {
    $line_first = fgets($filepdf);
    fclose($filepdf);
  } else {
    dd('error opening the file.');
  }
  preg_match_all('!\d+!', $line_first, $matches);
  return implode('.', $matches[0]);
} */

function getSzamlazzDataToArray($string)
{
    if ($string == null) return null;
    // remove last comma from string
    $string = rtrim($string, ',');
    $data = array();
    $variable = createArrayFromString($string, ',');
    foreach ($variable as $key => $value) {
        $temp = createArrayFromString($value, ':');
        if (isset($temp[0]) && $temp[0] != null && isset($temp[1]) && $temp[1] != null) {
            $data[$key] = [
                'prefix'         => $temp[0],
                'invoice_number' => $temp[1],
            ];
        }
    }
    return $data;
}

function getSzamlazzDataToString($array)
{
    if ($array == null) return null;
    $data = null;
    foreach ($array as $key => $value) {
        $data .= $value['prefix'] . ':' . $value['invoice_number'] . ',';
    }
    // remove last comma from string
    $data = rtrim($data, ',');
    return $data;
}

// create array from string by delimeter
function createArrayFromString($string, $delimeter = ',')
{
    $array = explode($delimeter, $string);
    return $array;
}
