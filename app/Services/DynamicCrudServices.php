<?php 

namespace App\Services;

use Illuminate\Support\Facades\DB;

class DynamicCrudServices {

    // Create (Insert Data)
    public function create($table, $data) {
        return DB::table($table)->insert($data);
    }

    // Read (Fetch Data)
    public function read($table, $conditions = []) {
        $query = DB::table($table);
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }
        return $query->get();
    }

    // Update (Modify Data)
    public function update($table, $data, $conditions) {
        $query = DB::table($table);
        foreach ($conditions as $key => $value) {
            $query->where($key, $value);
        }
        return $query->update($data);
    }

    // Delete (Remove Data)
    public function delete($table, $conditions) {
        $query = DB::table($table);
        foreach ($conditions as $key => $value) {
            $query->where($key, $value);
        }
        return $query->delete();
    }

}