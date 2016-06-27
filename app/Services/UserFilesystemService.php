<?php

namespace App\Services;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Irisit\IrispassShared\Model\User;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use League\Flysystem\Plugin\GetWithMetadata;
use League\Flysystem\Plugin\ListWith;

class UserFilesystemService
{
    const DATE_FORMAT = 'Y-m-d\TH:i:s.Z\Z';

    private $user_container;

    private $filesystem;

    private $user_dir;

    public function initialize(User $user, $user_id)
    {
        $this->user_container = str_replace(['\\', '/'], DIRECTORY_SEPARATOR, config('irispass.osjs.vfs_path')) . DIRECTORY_SEPARATOR . 'home' . DIRECTORY_SEPARATOR;

        $this->user_dir = $user_id;

        $adapter = new Local($this->user_container);

        $this->filesystem = new Filesystem($adapter);
        $this->filesystem->addPlugin(new ListWith);
        $this->filesystem->addPlugin(new GetWithMetadata);

        if ($this->checkExistence($this->user_dir) !== true && !is_dir($this->user_container . $this->user_dir)) {
            $this->filesystem->createDir($this->user_dir);
        }

    }

    public function call($method, Request $request)
    {
        switch ($method) {

            case 'scandir':
                return $this->scandir($request);
                break;

            case 'write':
                return $this->write($request);
                break;

            case 'read':
                return $this->read($request);
                break;

            case 'copy':
                return $this->copy($request);
                break;

            case 'move':
                return $this->move($request);
                break;

            case 'unlink':
                return $this->unlink($request);
                break;

            case 'mkdir':
                return $this->mkdir($request);
                break;

            case 'exists':
                return $this->exists($request);
                break;

            case 'fileinfo':
                return $this->fileinfo($request);
                break;

            case 'url':
                return $this->url($request);
                break;

            case 'upload':
                return $this->upload($request);
                break;

            case 'download':
                return $this->download($request);
                break;

            case 'freeSpace':
                return $this->freeSpace($request);
                break;

            case 'find':
                return $this->find($request);
                break;
        }

        return [];
    }

    public function scandir(Request $request)
    {

        $content = [];

        $listing = $this->filesystem->listWith([
            'mimetype',
            'size',
            'timestamp'
        ], $this->user_dir . $request->get('rel'));

        foreach ($listing as $key => $file) {


            $object = [];
            $object['filename'] = $file['basename'];
            $object['mime'] = (isset($file['mimetype'])) ? $file['mimetype'] : null;
            $object['path'] = $request->get('root') . $request->get('rel') . $file['basename'];
            $object['size'] = (isset($file['size'])) ? $file['size'] : 0;
            $object['type'] = $file['type'];
            $object['ctime'] = date(self::DATE_FORMAT, $file['timestamp']);
            $object['mtime'] = null;

            $content[] = $object;
        }

        Log::debug($content);

        return ['result' => $content];
    }

    public function write(Request $request)
    {
        return [];
    }

    public function read(Request $request)
    {
        return [];
    }

    public function copy(Request $request)
    {
        return [];
    }

    public function move(Request $request)
    {
        return [];
    }

    public function unlink(Request $request)
    {
        return [];
    }


    public function mkdir(Request $request)
    {
        return [];
    }

    public function exists(Request $request)
    {
        return [];
    }

    public function fileinfo(Request $request)
    {
        return [];
    }

    public function url(Request $request)
    {
        return [];
    }

    public function upload(Request $request)
    {
        return [];
    }

    public function download(Request $request)
    {
        return [];
    }

    public function freeSpace(Request $request)
    {
        return [];
    }

    public function find(Request $request)
    {
        return [];
    }

    public function checkExistence($identifier)
    {
        $exists = false;

        $adapter = new Local($this->user_dir);

        $filesystem = new Filesystem($adapter);

        $contents = $filesystem->listContents('/');

        foreach ($contents as $directory) {
            if ($directory['basename'] == $identifier) {
                $exists = true;
                return $exists;
            }
        }

        return $exists;
    }

}