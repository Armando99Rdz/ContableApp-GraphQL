@extends('layouts.app')

@section('content')

    <div class="lg:container lg:mx-auto">
        <div class="w-full flex flex-row">
            <div class="w-1/4 p-4">
                Menú
            </div>
            <div class="w-3/4 p-5 bg-white rounded-md">
                <router-view></router-view>
            </div>
        </div>
    </div>


@endsection
