<?php

if ($action == '' && empty($_POST)) 
    return;

switch ($page) 
{
    case 'settings':
        SettingsAction($settingsController, $action);
        break;
}

function SettingsAction($settingsController, $action) 
{
    switch ($action) 
    {
        case 'add-server':
            exit(json_encode($settingsController->AddServer()));
        case 'delete-server':
            exit(json_encode($settingsController->DeleteServer()));
        case 'update-access':
            exit(json_encode($settingsController->UpdateAccess()));
        case 'add-access':
            exit(json_encode($settingsController->AddAccess()));
        case 'delete-access':
            exit(json_encode($settingsController->DeleteAccess()));
        case 'update-settings':
            exit(json_encode($settingsController->UpdateSettings()));
    }
}   

