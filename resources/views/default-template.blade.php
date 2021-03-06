<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('head')

        @include('navbar')

        @section('js')
        @show

    </head>

    <body>
        <div class="clearfix">
            <!-- Column from menu-->
            <div class="col-md-3 mt-3 mb-3 float-left">
                <div class="card">
                    <div class="card-header">
                        <h4> <i class="fas fa-home"></i> @section('menu-title') @show</h4>
                    </div>

                    <div class="card-body">
                            @section('menu')
                            @show

                    </div>
                </div>
            </div>

            <!-- Column from content -->
            <div class="col-md-9 mt-3 mb-3 float-left">
                <div class="card">
                    <div class="card-header">
                        @section('header-content') @show
                        <h4> @section('content-title') @show </h4>
                    </div>

                    <div class="card-body">
                        @section('messages')
                            @include('messages')
                        @show

                        @section('content')
                        @show
                    </div>

                    @section('more-content')
                    @show
                </div>

                @section('column-extra-content')
                @show
            </div>
        </div>

        <div class="mr-3 ml-3">
        @section('extra-content')
        @show
        </div>

    </body>
</html>
