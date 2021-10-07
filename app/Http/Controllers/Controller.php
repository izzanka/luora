<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function report_answer_types(){
        return $types = [
            [
                'name' => 'Harrasment',
                'desc' => 'Disparaging or adversarial towards a person or group'
            ],
            [
                'name' => 'Spam',
                'desc' => 'Undisclosed promotion for a link or product'
            ],
            [
                'name' => 'Doesnt answer the question',
                'desc' => 'Does not address question that was asked'
            ],
            [
                'name' => 'Plagiarism',
                'desc' => 'Reusing content without attribution'
            ],
            [
                'name' => 'Joke answer',
                'desc' => 'Not a sincere answer'
            ],
            [
                'name' => 'Poorly written',
                'desc' => 'Not in English or has very bad formatting, grammar, and spelling'
            ],
            [
                'name' => 'Inappropriate credential',
                'desc' => 'Authors credential is offensive, spam, or impersonation'
            ],
            [
                'name' => 'Factually incorrect',
                'desc' => 'Substantially incorrect and/or incorrect primary conclusions'
            ],
            [
                'name' => 'Adult content',
                'desc' => 'Sexually explicit, pornographic or otherwise inappropriate'
            ]
        ];
    }
}
