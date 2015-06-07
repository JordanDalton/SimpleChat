@extends('app')

@section('header_embedded_css')
    <style type="text/css">
        #newMessageContainer { display:{!! Auth::check() ? 'block' : 'none' !!} }

        #loginFormContainer { display:{!! Auth::check() ? 'none' : 'block' !!} }
    </style>
@stop

@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div id="messages"></div>
            </div>
        </div>
        <hr/>
            <div id="newMessageContainer" class="row">
                <div class="col-md-8">

                    <div id="messageErrorsContainer" class="row" style="display:none">
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <ul id="messageErrors"></ul>
                            </div>
                        </div>
                    </div>

                    <form id="message" class="form-horizontal" role="form" method="POST" action="{{ route('messages.store') }}" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="message" placeholder="Type your message" value="{{ old('email') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="loginFormContainer" class="row">
                <div class="col-md-12">

                    <div id="loginErrorsContainer" class="row" style="display:none">
                        <div class="col-md-6">
                            <div class="alert alert-danger">
                                <ul id="loginErrors"></ul>
                            </div>
                        </div>
                    </div>

                    <form id="loginForm" class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="col-md-2">
                                <input type="email" class="form-control" name="email" placeholder="email" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-2">
                                <input type="password" class="form-control" name="password">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary">Login</button>
                            </div>
                    </form>
                </div>
            </div>
    </div>

@stop


@section('footer_embedded_js')
    <script type="text/javascript">

        // What the id of the last loaded chat message.
        $last_loaded_id = 0;

        function updateCsrfToken(token)
        {
            $('input[name="_token"]').val(token);
        }

        $('#message').on('submit', function(event)
        {
            event.preventDefault();

            $.ajax({
                type : 'POST',
                url  : "{{ route('messages.store') }}",
                data : $(this).serialize(),
                error: function(err)
                {
                    // Remove existing error message(s)
                    $('#messageErrors').find('li').remove();

                    var errorsExist  = false;
                    var responseJSON = err.responseJSON;

                    $.each(responseJSON, function(key,value)
                    {
                        errorsExist = true;

                        $('<li/>').html(responseJSON[key][0]).appendTo('#messageErrors');
                    });

                    if( errorsExist ){
                        $('#messageErrorsContainer').show();
                    }
                    else {
                        $('#messageErrorsContainer').hide();
                    }
                },
                success: function(response)
                {
                    $('#message')[0].reset();
                    loadMessages();
                }
            });
        });

        $('#loginForm').on('submit', function(event)
        {
            event.preventDefault();

            $.ajax({
                type : 'POST',
                url  : '/auth/login',
                data : $(this).serialize(),
                error: function(err)
                {
                    // Remove existing error message(s)
                    $('#loginErrors').find('li').remove();

                    var errorsExist  = false;
                    var responseJSON = err.responseJSON;

                    $.each(responseJSON, function(key,value)
                    {
                        errorsExist = true;

                        $('<li/>').html(responseJSON[key][0]).appendTo('#loginErrors');
                    });

                    if( errorsExist ){
                        $('#loginErrorsContainer').show();
                    }
                    else {
                        $('#loginErrorsContainer').hide();
                    }
                },
                success: function(response)
                {
                    if( response.logged_in )
                    {
                        updateCsrfToken(response.logged_in);
                        $('#newMessageContainer').show();
                        $('#loginFormContainer').hide();
                    }
                }
            });
        });

        // Function that will load the messages into the window.
        function loadMessages()
        {
            $.getJSON('{{ route('messages.index') }}', {
                'last_loaded_id' : $last_loaded_id
            }, function(messages)
            {
                // Loop through the messages and add them
                // to the chat window.
                for( var i = 0; i < messages.length; i++ )
                {
                    var record = messages[i];

                    if( i == messages.length -1 ) $last_loaded_id = record.id;

                    $('<div/>', { 'data-id' : record.id }).html('<strong>' + record.user.name + '</strong>: ' + record.message).appendTo('#messages');
                }
            });
        }

        // Load the messages into the chat window.
        loadMessages();

        setInterval(function() {
            loadMessages();
        }, 5000);

    </script>
@stop