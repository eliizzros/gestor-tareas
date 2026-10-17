<?php

namespace App\Controllers;

use App\Models\RecordModel;
use CodeIgniter\HTTP\RedirectResponse;

class DashboardController extends BaseController
{
    private RecordModel $dataRepo;

    public function __construct()
    {
        $this->dataRepo = new RecordModel();
    }

    public function displayPanel()
    {
        return view('activities/index');
    }

    public function registerRecord(): RedirectResponse
    {
        $taskName = $this->request->getPost('title');
        $details  = $this->request->getPost('description');
        $fileRef  = $this->request->getFile('attachment');

        if (!empty($taskName)) {
            $payload = [
                'user_id'     => 1,
                'title'       => $taskName,
                'description' => $details,
                'status'      => 'Pending'
            ];

            if ($fileRef && $fileRef->isValid() && !$fileRef->hasMoved()) {
                $uniqueName = $fileRef->getRandomName();
                $fileRef->move(FCPATH . 'uploads/records', $uniqueName);
            }

            $this->dataRepo->insert($payload);
        }

        return redirect()->to('/activities');
    }
}
