<?php
// 代码生成时间: 2025-08-26 01:03:11
class UserPermissionSystem {

    /**
     * @var array $permissions The permissions data structure.
     */
    private $permissions = [];

    /**
     * Constructor for UserPermissionSystem.
     *
     * @param array $permissions Permissions data structure.
     */
    public function __construct(array $permissions) {
        $this->permissions = $permissions;
    }

    /**
     * Check if a user has a specific permission.
     *
     * @param string $userId The ID of the user.
     * @param string $permission The permission to check.
     * @return bool True if the user has the permission, false otherwise.
     */
    public function hasPermission($userId, $permission) {
        if (!isset($this->permissions[$userId])) {
            // Handle error: User not found in permissions array.
            // Log error and return false.
            error_log("User {$userId} not found in permissions array.");
            return false;
        }

        return in_array($permission, $this->permissions[$userId]);
    }

    /**
     * Add a permission to a user.
     *
     * @param string $userId The ID of the user.
     * @param string $permission The permission to add.
     * @return bool True on success, false on failure.
     */
    public function addPermission($userId, $permission) {
        if (!isset($this->permissions[$userId])) {
            // Handle error: User not found in permissions array.
            // Log error and return false.
            error_log("User {$userId} not found in permissions array.");
            return false;
        }

        if (in_array($permission, $this->permissions[$userId])) {
            // Handle error: Permission already exists.
            // Log error and return false.
            error_log("Permission {$permission} already exists for user {$userId}.");
            return false;
        }

        $this->permissions[$userId][] = $permission;
        return true;
    }

    /**
     * Remove a permission from a user.
     *
     * @param string $userId The ID of the user.
     * @param string $permission The permission to remove.
     * @return bool True on success, false on failure.
     */
    public function removePermission($userId, $permission) {
        if (!isset($this->permissions[$userId])) {
            // Handle error: User not found in permissions array.
            // Log error and return false.
            error_log("User {$userId} not found in permissions array.");
            return false;
        }

        $key = array_search($permission, $this->permissions[$userId]);
        if ($key === false) {
            // Handle error: Permission not found.
            // Log error and return false.
            error_log("Permission {$permission} not found for user {$userId}.");
            return false;
        }

        unset($this->permissions[$userId][$key]);
        return true;
    }

    /**
     * Get a user's permissions.
     *
     * @param string $userId The ID of the user.
     * @return array The user's permissions.
     */
    public function getUserPermissions($userId) {
        if (!isset($this->permissions[$userId])) {
            // Handle error: User not found in permissions array.
            // Log error and return an empty array.
            error_log("User {$userId} not found in permissions array.");
            return [];
        }

        return $this->permissions[$userId];
    }
}

// Example usage:
$permissions = [
    'user1' => ['read', 'write'],
    'user2' => ['read']
];
$permissionSystem = new UserPermissionSystem($permissions);

// Check if a user has a permission.
$hasPermission = $permissionSystem->hasPermission('user1', 'write');

// Add a permission to a user.
$addPermission = $permissionSystem->addPermission('user2', 'write');

// Remove a permission from a user.
$removePermission = $permissionSystem->removePermission('user1', 'write');

// Get a user's permissions.
$userPermissions = $permissionSystem->getUserPermissions('user1');
