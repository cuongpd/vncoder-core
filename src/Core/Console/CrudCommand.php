<?php

namespace VnCoder\Core\Console;
use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CrudCommand extends Command
{
    protected $signature = 'crud {action?}';
    protected $description = 'Create CRUD Backend';

    protected $modelFolder = APP_PATH.'Models/';
    protected $crudBackendFolder = APP_PATH.'Backend/Controllers/';
    protected $menuBackendFile = APP_PATH.'Backend/menu.php';

    public function handle()
    {
        $this->info("Auto generate blade from table");
        $tables = array_map('reset', DB::select('SHOW TABLES'));
        $menu = "";
        foreach ($tables as $table) {
            $subTable = substr($table, 0, 2);
            if($subTable !== '__'){
                echo $table."\n";
                $this->createCrudController($table);
                $this->createModel($table);
                $menu_name = $this->safeName($table , false);
                $menu .= "'$table' => ['name' => '$menu_name', 'icon' => 'fa-user', 'link' => '', 'subMenu' => [\n\t\t";
                $menu .= "['name' => '$menu_name', 'link' => backend('$table')],\n\t";
                $menu .= "]],\n\t";
            }
        }

        if(!file_exists(!$this->menuBackendFile)) {
            $menuCode = <<<EOF
<?php

return [

    $menu    

];
    
EOF;


            file_put_contents($this->menuBackendFile, $menuCode);
        }
    }

    protected function createModel($table)
    {
        $model_name = $this->safeName($table);
        $modelPath = $this->modelFolder. $model_name . '.php';
        if(!file_exists($modelPath)){
            $columns = Schema::getColumnListing($table);

            $fillable = 'protected $fillable = [\''.implode("','" , $columns).'\'];';
            $modelKey = 'protected $modelKey = [\''.implode("','" , $columns).'\'];';

            $formOption = ""; $getRules = "";
            foreach ($columns as $column){
                $getRules .= "'$column' => [ 'required', 'string' ],";
                $formOption .= "'$column' => [ 'type' => 'text' , 'name' => '".$this->safeName($column , false)."' ],";
                if ($column !== end($columns)) {
                    $getRules .= "\n\t\t\t";
                    $formOption .= "\n\t\t\t";
                }
            }

            $modelCode = <<<EOF
<?php

namespace App\Models;

use VnCoder\Core\Models\VnModel;

class $model_name extends VnModel
{
    protected \$table = '$table';
    $fillable
    $modelKey
    protected \$relations = [];
    
    static function getRules(){
        return [
            $getRules
        ];
    }

    protected function formOption()
    {
        return [
            $formOption
        ];
    }
}
    
EOF;

            file_put_contents($modelPath , $modelCode);
        }

    }

    protected function createCrudController($table){
        $modelName = $this->safeName($table);
        $crudController = $modelName.'Controller';
        $crudControllerPath = $this->crudBackendFolder. $crudController . '.php';
        if(!file_exists($crudControllerPath)){
            $crudCode = <<<EOF
<?php

namespace App\Backend\Controllers;

use VnCoder\Admin\Controllers\CrudController;

class $crudController extends CrudController
{
    protected \$model = 'App\Models\\$modelName';

}

EOF;

            file_put_contents($crudControllerPath , $crudCode);
        }

    }

    protected function safeName($str, $trimSpace = true)
    {
        $str = str_replace("_", " ", $str);
        return $trimSpace ? str_replace(" ", "",ucwords($str)) : ucwords($str);
    }
}