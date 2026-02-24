<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

        <title>Vonage ToDo App</title>

        @livewireStyles

        <!-- Material Icons -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
        
        <!-- Roboto Font -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Roboto', sans-serif;
                background-color: #f5f5f5;
                color: #212121;
                -webkit-font-smoothing: antialiased;
                -moz-osx-font-smoothing: grayscale;
                overflow-x: hidden;
            }

            .app-container {
                max-width: 100%;
                margin: 0 auto;
                min-height: 100vh;
                background-color: #f5f5f5;
            }

            .app-bar {
                background-color:rgb(0, 0, 0);
                color: white;
                padding: 16px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .app-bar-content {
                display: flex;
                align-items: center;
                gap: 12px;
            }

            .app-bar-title {
                font-size: 20px;
                font-weight: 500;
                line-height: 1.5;
                white-space: nowrap;
            }

            .app-bar-logo {
                max-width: 140px;
                object-fit: contain;
            }

            .content-container {
                padding: 16px;
                max-width: 600px;
                margin: 0 auto;
            }

            .card {
                background-color: white;
                border-radius: 4px;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
                margin-bottom: 16px;
                overflow: hidden;
            }

            .card-content {
                padding: 16px;
            }

            .text-field {
                width: 100%;
                padding: 12px 16px;
                border: none;
                border-bottom: 1px solid rgba(0,0,0,0.12);
                font-size: 16px;
                font-family: 'Roboto', sans-serif;
                background-color: transparent;
                outline: none;
                transition: border-color 0.2s;
            }

            .text-field:focus {
                border-bottom-color: #1976d2;
                border-bottom-width: 2px;
                padding-bottom: 11px;
            }

            .text-field::placeholder {
                color: rgba(0,0,0,0.38);
            }

            .button {
                background-color: #1976d2;
                color: white;
                border: none;
                border-radius: 4px;
                padding: 10px 16px;
                font-size: 14px;
                font-weight: 500;
                text-transform: uppercase;
                cursor: pointer;
                transition: background-color 0.2s, box-shadow 0.2s;
                box-shadow: 0 2px 4px rgba(0,0,0,0.2);
                font-family: 'Roboto', sans-serif;
                min-width: 64px;
            }

            .button:hover {
                background-color: #1565c0;
            }

            .button:active {
                box-shadow: 0 1px 2px rgba(0,0,0,0.2);
            }

            .button-icon {
                background-color: transparent;
                border: none;
                color: #1976d2;
                cursor: pointer;
                padding: 8px;
                border-radius: 50%;
                transition: background-color 0.2s;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 40px;
                height: 40px;
            }

            .button-icon:hover {
                background-color: rgba(25, 118, 210, 0.08);
            }

            .button-icon.delete {
                color: #d32f2f;
            }

            .button-icon.delete:hover {
                background-color: rgba(211, 47, 47, 0.08);
            }

            .button-icon.edit {
                color: #1976d2;
            }

            .button-icon.done {
                color: #388e3c;
            }

            .button-icon.done:hover {
                background-color: rgba(56, 142, 60, 0.08);
            }

            .button-icon.close {
                color: #757575;
            }

            .list-item {
                display: flex;
                align-items: center;
                padding: 16px;
                border-bottom: 1px solid rgba(0,0,0,0.12);
                transition: background-color 0.2s;
            }

            .list-item:last-child {
                border-bottom: none;
            }

            .list-item:hover {
                background-color: rgba(0,0,0,0.04);
            }

            .checkbox {
                width: 24px;
                height: 24px;
                margin-right: 16px;
                cursor: pointer;
                accent-color: #1976d2;
            }

            .list-item-text {
                flex: 1;
                font-size: 16px;
                color: #212121;
                line-height: 1.5;
            }

            .list-item-text.completed {
                text-decoration: line-through;
                color: rgba(0,0,0,0.38);
            }

            .empty-state {
                padding: 48px 16px;
                text-align: center;
                color: rgba(0,0,0,0.38);
            }

            .empty-state-icon {
                font-size: 48px;
                color: rgba(0,0,0,0.26);
                margin-bottom: 16px;
            }

            .form-row {
                display: flex;
                gap: 8px;
                align-items: flex-end;
            }

            .form-input-wrapper {
                flex: 1;
            }

            .divider {
                height: 1px;
                background-color: rgba(0,0,0,0.12);
                margin: 8px 0;
            }

            .action-buttons {
                display: flex;
                gap: 4px;
                margin-left: auto;
            }

            .material-icons {
                font-size: 24px;
                user-select: none;
            }

            .material-icons.small {
                font-size: 20px;
            }

            @media (max-width: 600px) {
                .content-container {
                    padding: 8px;
                }

                .card-content {
                    padding: 12px;
                }

                .list-item {
                    padding: 12px;
                }
            }
        </style>
    </head>
    <body>
        <div class="app-container">
            <div class="app-bar">
                <div class="app-bar-content">
                    <img
                    src="{{ asset('images/vonage-logo.png') }}"
                    alt="Vonage logo"
                    class="app-bar-logo"
                >
                    <div class="app-bar-title">ToDo App With Messages</div>
                </div>
            </div>
            
            <div class="content-container">
                <livewire:todos />
            </div>
        </div>

        @livewireScripts
    </body>
</html>
