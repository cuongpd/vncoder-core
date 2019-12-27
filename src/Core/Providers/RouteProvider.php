<?php

namespace VnCoder\Core\Providers;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

class RouteProvider extends ServiceProvider
{

    public function map()
    {
        if (defined('IS_BACKEND')) {
            $this->mapBackendRoutes();
        } else {
            $this->mapApiRoutes();
            $this->mapFrontendRoutes();
        }
    }

    protected function mapFrontendRoutes()
    {
        Route::group([ 'namespace' => 'App\Frontend\Controllers'] , function(){
            Route::middleware('web')->group(FRONTEND_PATH.'routes.php');
        });
    }

    protected function mapBackendRoutes()
    {
        Route::group(['as' => 'auth.', 'namespace' => 'VnCoder\Admin\Auth', 'middleware' => ['web', 'backend-auth'] ] , function(){
            Route::get('login.html', 'AuthController@Login_Form')->name('login');
            Route::get('logout.html', 'AuthController@Logout_Action')->name('logout');
            Route::get('logout-permission.html', 'AuthController@Logout_Permission_Action')->name('logout-permission');
            Route::get('register.html', 'AuthController@Register_Form')->name('register');
            Route::post('login.html', 'AuthController@Login_Submit');
            Route::post('register.html', 'AuthController@Register_Submit');
        });

        Route::group(['as' => 'backend.', 'middleware' => ['web', 'backend-admin']] , function(){
            Route::match(['get', 'post'],'{controller?}/{action?}', function ($controller, $action = null) {
                if(!$controller) $controller = 'dashboard';
                if(!$action) $action = 'index';
                $controller = str_replace(" ", "" , ucwords(str_replace("-", " " , $controller)));
                $action = str_replace(" ", "_" , ucwords(str_replace("-", " " , $action)));

                $backenAppController = "\\App\\Backend\\Controllers\\" . ucfirst($controller) . "Controller";
                $backendCoreController = "\\VnCoder\Admin\\Controllers\\" . ucfirst($controller) . "Controller";
                $functionAction = $action."_Action";
                $controllerClassName = str_replace(" ", "\\", trim(str_replace("\\", " ", $backenAppController)));
                $controllerClassCoreName = str_replace(" ", "\\", trim(str_replace("\\", " ", $backendCoreController)));
                $makeControllerClass = null;
                if (class_exists($backenAppController)) {
                    if (class_exists($backendCoreController)) {
                        return response()->json(['status' => -10, 'message' => 'Không thể khởi tạo class ' . $controllerClassName . '. Class đã được khai báo và sử dụng tại ' . $controllerClassCoreName.'. Vui lòng xóa bỏ nó!'], 500, [], JSON_PRETTY_PRINT);
                    }
                    $makeControllerClass = app()->make($backenAppController);
                } else {
                    if (class_exists($backendCoreController)) {
                        $makeControllerClass = app()->make($backendCoreController);
                    } else {
                        return response()->json(['status' => -1, 'error' => 'Class does not exist', 'message' => 'Class ' . $controllerClassName . ' not found'], 403, [], JSON_PRETTY_PRINT);
                    }
                }
                if (method_exists($makeControllerClass, $functionAction)) {
                    return $makeControllerClass->$functionAction();
                }
                return response()->json(['status' => -1, 'error' => 'Method does not exist', 'message' => 'Method ' . $functionAction . ' not active in class ' . $controllerClassCoreName], 502, [], JSON_PRETTY_PRINT);
            })->where(['controller' => '[a-z-]+' , 'action' => '[a-z-0-9-]+']);
        });
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api')->middleware('api')->namespace('VnCoder\Core')->group(function (){
            Route::get('/', 'ApiController@Home_API');
            Route::match(['get', 'post'],'{controller}/{action?}', function ($controller , $action = null){
                if(!$action) $action = 'index';
                $controller = str_replace(' ', '', ucfirst(str_replace('-', ' ', $controller)));
                $action = str_replace(' ', '', ucfirst(str_replace('-', ' ', $action)));

                $controllerClass = "\\App\\Api\\Controllers\\".ucfirst($controller)."Controller";
                $functionAction = $action."_Action";
                if (class_exists($controllerClass)) {
                    $makeControllerClass = app()->make($controllerClass);
                    if (method_exists($makeControllerClass, $functionAction)) {
                        return $makeControllerClass->$functionAction();
                    }
                }
                return response()->json(['class' => str_replace(" ", "\\", trim(str_replace("\\", " ", $controllerClass))), 'function' => $functionAction, 'status' => -1, 'error' => '404 Not Found'], 503, [], JSON_PRETTY_PRINT);
            })->where(['controller' => '[a-z-]+' , 'action' => '[a-z-]+']);
        });
    }

}
