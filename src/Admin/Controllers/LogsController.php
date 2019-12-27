<?php

namespace VnCoder\Admin\Controllers;
use VnCoder\Admin\Libraries\Logs\LogsViewer;

class LogsController extends AdminController
{
    private $log_viewer;
    protected $request;

    function __construct()
    {
        parent::__construct();
        $this->log_viewer = new LogsViewer();
        $this->request = app('request');
    }

    public function Index_Action()
    {
        $this->metaData->title = "Xem log hệ thống";
        $folderFiles = [];
        if ($this->request->input('f')) {
            $this->log_viewer->setFolder(decrypt($this->request->input('f')));
            $folderFiles = $this->log_viewer->getFolderFiles(true);
        }
        if ($this->request->input('l')) {
            $this->log_viewer->setFile(decrypt($this->request->input('l')));
        }
        if ($early_return = $this->earlyReturn()) {
            return $early_return;
        }

        $this->setData['logs'] = $this->log_viewer->all();
        $this->setData['folders'] = $this->log_viewer->getFolders();
        $this->setData['current_folder'] = $this->log_viewer->getFolderName();
        $this->setData['folder_files'] = $folderFiles;
        $this->setData['files'] = $this->log_viewer->getFiles(true);

        $current_file = $this->log_viewer->getFileName();
        $this->setData['current_file'] = $current_file;
        $this->setData['standardFormat'] = true;

        if ($this->request->wantsJson()) {
            return $this->setData;
        }
        if (is_array($this->setData['logs'])) {
            $firstLog = reset($this->setData['logs']);
            if (!$firstLog['context'] && !$firstLog['level']) {
                $data['standardFormat'] = false;
            }
        }

        $this->setData['logs_url'] = backend('logs');
        $this->setData['logs_data'] = encrypt($current_file);

        $this->loadDataTables();
        return $this->views('admin.logs');
    }

    private function earlyReturn()
    {
        if ($this->request->input('f')) {
            $this->log_viewer->setFolder(decrypt($this->request->input('f')));
        }
        if ($this->request->input('dl')) {
            return $this->download($this->pathFromInput('dl'));
        } elseif ($this->request->has('clean')) {
            app('files')->put($this->pathFromInput('clean'), '');
            return $this->redirect($this->request->url());
        } elseif ($this->request->has('del')) {
            app('files')->delete($this->pathFromInput('del'));
            return $this->redirect($this->request->url());
        } elseif ($this->request->has('delall')) {
            $files = ($this->log_viewer->getFolderName())
                ? $this->log_viewer->getFolderFiles(true)
                : $this->log_viewer->getFiles(true);
            foreach ($files as $file) {
                app('files')->delete($this->log_viewer->pathToLogFile($file));
            }
            return $this->redirect($this->request->url());
        }
        return false;
    }

    private function pathFromInput($input_string)
    {
        return $this->log_viewer->pathToLogFile(decrypt($this->request->input($input_string)));
    }

    private function redirect($to)
    {
        if (function_exists('redirect')) {
            return redirect($to);
        }
        return app('redirect')->to($to);
    }

    private function download($data)
    {
        return response()->download($data);
    }

}
