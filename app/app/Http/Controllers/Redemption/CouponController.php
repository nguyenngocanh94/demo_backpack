<?php

declare(strict_types=1);

namespace App\Http\Controllers\Redemption;

use App\Http\Controllers\Admin\CouponCrudController;
use CRUD;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends CouponCrudController
{
    private function defaultSetting()
    {
        CRUD::setOperationSetting('showEntryCount', true);
    }
    public function list()
    {
        $this->defaultSetting();
        $length = (int) request()->input('limit') ?: 10;
        $page = (int) request()->input('page') ?? 1;
        $start = ($page - 1) * $length;
        // start the results according to the datatables pagination
        if ($start) {
            $this->crud->skip($start);
        }
        // limit the number of results according to the datatables pagination
        if ($length) {
            $this->crud->take($length);
        }
        // overwrite any order set in the setup() method with the datatables order
        $this->crud->orderBy('created_at', 'DESC');
        $entries = $this->crud->getEntries();
        $totalEntryCount = $this->crud->getTotalQueryCount();

        return response()->json([
            'message' => __('success'),
            'result' => $entries,
            'total' => $totalEntryCount,
            'count' => count($entries),
        ])->setStatusCode(Response::HTTP_OK);
    }
}
