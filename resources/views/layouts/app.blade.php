<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100" id="app">
        @include('layouts.navigation')

        <!-- Page Heading -->
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header ?? '' }}
            </div>
        </header>


        <main>
            <div class="container chats">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="card card-default">
                            <div class="card-header">Chats</div>

                            <div class="card-body">
                                <chat-messages :messages="messages"></chat-messages>
                            </div>
                            <div class="card-footer">
                                <chat-form @messagesent="addMessage" :user="{{ auth()->user() }}"></chat-form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="user in users">
                                @{{ user.name }} <span v-if="user.typing" class="badge badge-primary">typing...</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </main>
</body>

</html>