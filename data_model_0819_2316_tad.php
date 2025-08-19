<?php
// 代码生成时间: 2025-08-19 23:16:03
// Data Model
// This file defines the data models used in the application.

use Cake\Database\Type;
use Cake\ORM\Table;
use Cake\ORM\Entity;
use Cake\Validation\Validation;

class ArticlesTable extends Table
{
    public function initialize(array $config): void
    {
        $this->addBehavior('Timestamp'); // Automatically handle created and modified fields
        $this->hasMany('Comments'); // Define a hasMany relationship with the Comments model
    }
}

class CommentsTable extends Table
{
    public function initialize(array $config): void
    {
        $this->belongsTo('Articles'); // Define a belongsTo relationship with the Articles model
    }
}

class Article extends Entity
{
    protected $_accessible = [
        'title' => true,
        'body' => true,
        'created' => false, // Prevent mass assignment for the 'created' field
        'modified' => false // Prevent mass assignment for the 'modified' field
    ];
}

class Comment extends Entity
{
    protected $_accessible = [
        'content' => true,
        'article_id' => true
    ];
}

// Validation rules for Articles
$validator = new Validation();
$validator
    ->add('title', 'length', function ($context) {
        return [
            'rule' => ['minLength', 5],
            'message' => 'Title must be at least 5 characters long.'
        ];
    })
    ->add('body', 'length', function ($context) {
        return [
            'rule' => ['minLength', 20],
            'message' => 'Body must be at least 20 characters long.'
        ];
    });

// Usage example
// Assuming $articlesTable is an instance of ArticlesTable
// $articlesTable->newEntity(['title' => 'New Article', 'body' => 'Article content here.']);
// $articlesTable->save($entity);

// Error handling example
// try {
//     $articlesTable->save($entity);
// } catch (\Exception $e) {
//     // Handle exceptions
//     error_log($e->getMessage());
// }
