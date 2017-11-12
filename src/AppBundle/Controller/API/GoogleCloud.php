<?php

namespace AppBundle\Controller\API;


class GoogleCloud
{
    public function __construct($googleCloudStorage)
    {
        $this->googleCloudStorage = $googleCloudStorage;
        $this->googleCloudStorageLogin = $this->googleCloudStorage['login'];
        $this->googleCloudStorageKey = $this->googleCloudStorage['key'];
        $this->googleCloudStorageBucket = $this->googleCloudStorage['bucket'];
        $this->googleCloudStoragePath = $this->googleCloudStorage['path'];

        $this->configuration = [
            'login' => $this->googleCloudStorageLogin,
            'key' => $this->googleCloudStorageKey,
            'scope' => $this->googleCloudStorage['scope'],
            'storage' => [
                'url' => $this->googleCloudStorage['url'],
                'prefix' => ''
                ]
        ];

        $credentials = new \Google_AuthHandler_Guzzle5AuthHandler($this->configuration['login'], $this->configuration['scope'], $this->configuration['key']);
        $client = new \Google_Client();
        $client->setAssertionCredentials($credentials);
        $this->storage = new \Google_Service_Storage($client);

        $this->arrContextOptions = [
            "ssl" => [
                "verify_peer" => false,
                "verify_peer_name" => false,
            ],
        ];
    }

    public function storageInsert(\Google_Service_Storage_StorageObject $object, $pathSource)
    {
        $file = new File($pathSource);

        $this->storage->objects->insert($this->configuration['storage'],['prefix'] . $this->googleCloudStorageBucket, $object, [
            'uploadType' => 'media',
            'mimeType' => $file->getMimeType(),
            'data' => file_get_contents($pathSource, false, stream_context_create($this->arrContextOptions)),
        ]);
    }

    public function storageAccess($file)
    {
        $object = $this->storage->objects->get($this->googleCloudStorageBucket, $file);
        $object = $object->getName();

        $pathObject = $this->configuration['storage']['url'] . $this->googleCloudStorageBucket . '/' . $object;

        return $pathObject;
    }
}