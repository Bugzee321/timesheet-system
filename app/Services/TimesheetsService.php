<?php

namespace App\Services;

use App\Models\Timesheet;

class TimesheetsService
{
    
    /**
     * List timesheets with pagination.
     *
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function listTimesheetsPaginated(int $perPage = 10)
    {
        return Timesheet::paginate($perPage);
    }

    /**
     * Create a new timesheet.
     *
     * @param array $data
     * @return \App\Models\Timesheet
     */
    public function createTimesheet(array $data)
    {
        return Timesheet::create($data);
    }

    /**
     * Update the specified timesheet.
     *
     * @param \App\Models\Timesheet $timesheet
     * @param array $data
     * @return \App\Models\Timesheet
     */
    public function updateTimesheet(Timesheet $timesheet, array $data)
    {
        $timesheet->update($data);
        return $timesheet;
    }

    /**
     * Delete the specified timesheet.
     *
     * @param \App\Models\Timesheet $timesheet
     * @return bool|null
     */
    public function deleteTimesheet(Timesheet $timesheet)
    {
        return $timesheet->delete();
    }
}
