<?php

use Illuminate\Support\Facades\Auth;

function isAdminOrHasPermissionOf($permission, $guard = 'admin'){
    $guard = Auth::guard($guard);
    $user = $guard->user();

    if($guard && $user && ((int)$user->is_admin === 1 || $user->can($permission))){
        return true;
    }

    return false;
}

function hasPermissionToCreate($guard = 'admin'){
    $guard = Auth::guard($guard);
    $user = $guard->user();

    if($guard && $user && ((int)$user->is_admin === 1 || $user->can('create-action'))){
        return true;
    }

    return false;
}

function hasPermissionToEdit($guard = 'admin'){
    $guard = Auth::guard($guard);
    $user = $guard->user();

    if($guard && $user && ((int)$user->is_admin === 1 || $user->can('edit-action'))){
        return true;
    }

    return false;
}

function hasPermissionToDelete($guard = 'admin'){
    $guard = Auth::guard($guard);
    $user = $guard->user();

    if($guard && $user && ((int)$user->is_admin === 1 || $user->can('delete-action'))){
        return true;
    }

    return false;
}

function hasPermissionToModule($module, $guard = 'admin'){
    $guard = Auth::guard($guard);
    $user = $guard->user();

    if($guard && $user && ((int)$user->is_admin === 1 || $user->can($module))){
        return true;
    }

    return false;
}

function hasPermissionToUserManager($guardName = 'admin'){
    $guard = Auth::guard($guardName);
    $user = $guard->user();

    if($guard && $user && ((int)$user->is_admin === 1 || $user->can('user-module'))){
        return true;
    }

    return false;
}

function hasPermissionToSecurityManager($guard = 'admin'){
    $guard = Auth::guard($guard);
    $user = $guard->user();

    if($guard && $user && ((int)$user->is_admin === 1 || $user->can('security-module'))){
        return true;
    }

    return false;
}