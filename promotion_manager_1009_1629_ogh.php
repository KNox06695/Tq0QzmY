<?php
// 代码生成时间: 2025-10-09 16:29:54
class PromotionManager extends AppModel {
    /**
     * Model name
     *
     * @var string
     */
    public $name = 'Promotion';

    /**
     * Error messages
     *
     * @var array
     */
    private $errors = [];

    /**
     * Initialize method
     *
     * @param array $settings Settings for the model
     * @return void
     */
    public function initialize(array $settings) {
        parent::initialize($settings);
        // Set the table for the model
        $this->table = 'promotions';
    }

    /**
     * Validate the promotion data
     *
     * @param array $data The data to validate
     * @return array Returns an array with the data if valid, or an error array
     */
    public function validatePromotion($data) {
        if (empty($data['title'])) {
            $this->errors[] = 'Promotion title is required';
        }

        if (empty($data['description'])) {
            $this->errors[] = 'Promotion description is required';
        }

        if (empty($data['startDate']) || !DateTime::createFromFormat('Y-m-d', $data['startDate'])) {
            $this->errors[] = 'Invalid start date format';
        }

        if (empty($data['endDate']) || !DateTime::createFromFormat('Y-m-d', $data['endDate'])) {
            $this->errors[] = 'Invalid end date format';
        }

        if (count($this->errors) > 0) {
            return ['errors' => $this->errors];
        }

        return $data;
    }

    /**
     * Save a promotion
     *
     * @param array $data The promotion data to save
     * @return bool True on success, false on failure
     */
    public function savePromotion($data) {
        $data = $this->validatePromotion($data);
        if (isset($data['errors'])) {
            return false;
        }

        // Save the promotion data to the database
        $this->create();
        if ($this->save($data)) {
            return true;
        } else {
            $this->errors = $this->validationErrors;
            return false;
        }
    }

    /**
     * Get all promotions
     *
     * @return array List of promotions
     */
    public function getAllPromotions() {
        return $this->find('all');
    }

    /**
     * Get a specific promotion by ID
     *
     * @param int $id The ID of the promotion to retrieve
     * @return array The promotion data
     */
    public function getPromotionById($id) {
        return $this->findById($id);
    }

    /**
     * Update a promotion
     *
     * @param array $data The promotion data to update
     * @return bool True on success, false on failure
     */
    public function updatePromotion($id, $data) {
        $data = $this->validatePromotion($data);
        if (isset($data['errors'])) {
            return false;
        }

        // Update the promotion data in the database
        if ($this->saveField('title', $data['title']) &&
            $this->saveField('description', $data['description']) &&
            $this->saveField('startDate', $data['startDate']) &&
            $this->saveField('endDate', $data['endDate'])) {
            return true;
        } else {
            $this->errors = $this->validationErrors;
            return false;
        }
    }

    /**
     * Delete a promotion
     *
     * @param int $id The ID of the promotion to delete
     * @return bool True on success, false on failure
     */
    public function deletePromotion($id) {
        if ($this->delete($id)) {
            return true;
        } else {
            $this->errors = $this->validationErrors;
            return false;
        }
    }
}
