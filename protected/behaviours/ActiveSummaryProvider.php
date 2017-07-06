<?php
class ActiveSummaryProvider extends CActiveDataProvider
{
    /**
     * Fetches the data from the persistent data storage.
     * @return array list of data items
     */
    protected function fetchData()
    {
        $mat_cost = $work_count =$work_cost = 0;
        /* @var $data GnattData[] */
        $data = parent::fetchData();
        foreach($data as $r)
        {
            $mat_cost += $r->material_cost;
            $work_cost += $r->workers_cost;
            $work_count += $r->workers_used;
        }
        $summ = new GnattDay();
        $summ->material_cost = $mat_cost;
        $summ->workers_cost = $work_cost;
        $summ->workers_used = $work_count;
        $data[] = $summ;
        return $data;
    }
}