<?php
namespace App\Services;

use Illuminate\Support\Facades\Validator;

class CsvValidator
{
    public function validate($file)
    {
        $rows = array_map('str_getcsv', file($file));
        $header = array_shift($rows);

        $errors = [];
        foreach ($rows as $row) {
            $data = array_combine($header, $row);
            $validator = Validator::make($data, [
                'name' => 'required|string',
                'email' => 'required|email',
            ]);

            if ($validator->fails()) {
                $errors[] = $validator->errors();
            }
        }

        return $errors;
    }
}
?>