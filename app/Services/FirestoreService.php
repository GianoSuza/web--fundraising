<?php

namespace App\Services;

use Google\Cloud\Firestore\FirestoreClient;

class FirestoreService
{
    protected $firestore;

    public function __construct()
    {
        $this->firestore = new FirestoreClient([
            'keyFilePath' => base_path(env('FIREBASE_CREDENTIALS')),
            'projectId' => 'your-project-id'
        ]);
    }

    public function getCollection($name)
    {
        return $this->firestore->collection($name);
    }

    public function addDocument($collection, $data)
    {
        return $this->getCollection($collection)->add($data);
    }

    public function getAllDocuments($collection)
    {
        return $this->getCollection($collection)->documents();
    }

    public function getDocument($collection, $id)
    {
        return $this->getCollection($collection)->document($id)->snapshot();
    }

    public function updateDocument($collection, $id, $data)
    {
        return $this->getCollection($collection)->document($id)->set($data, ['merge' => true]);
    }

    public function deleteDocument($collection, $id)
    {
        return $this->getCollection($collection)->document($id)->delete();
    }
}
