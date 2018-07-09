@extends('layouts.app')

@section('breadcrumbs', '')

@section('content')

    <p><a href="{{ route('cabinet.adverts.create') }}" class="btn btn-success">Add Advert</a></p>

    <div class="card card-default mb-3">
        <div class="card-header">
            All Categories
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                @foreach (array_chunk($categories, 3) as $chunk)
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            @foreach ($chunk as $current)
                                <li><a href="{{ route('adverts.index.all', $current) }}">{{ $current->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="card card-default mb-3">
        <div class="card-header">
            All Regions
        </div>
        <div class="card-body pb-0" style="color: #aaa">
            <div class="row">
                @foreach (array_chunk($regions, 3) as $chunk)
                    <div class="col-md-3">
                        <ul class="list-unstyled">
                            @foreach ($chunk as $current)
                                <li><a href="{{ route('adverts.index', [$current]) }}">{{ $current->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @foreach($adverts as $advert)
        <div class="card col-12">
            <div class="card-body">
                <h5 class="card-title">{{$advert->title}}</h5>
                <h6 class="card-subtitle">{{$advert->price}}</h6>
                <p class="card-text">{{str_limit($advert->content, 20)}}</p>
                <a href="{{ route('adverts.show', $advert) }}" class="btn btn-primary">Show</a>
            </div>
        </div>
    @endforeach

@endsection