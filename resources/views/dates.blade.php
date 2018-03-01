@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        @if($user->id !== 1)
                            <b>Your dates:</b>
                            <button type="button" class="btn btn-secondary">Add Date</button>
                        @else
                            <b>Dates of all participants:</b>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($dates->count())
                            <table class="table table-hover">
                                <thead class="thead-dark">
                                <tr>
                                    <th scope="col">Day</th>
                                    <th scope="col">Month</th>
                                    <th scope="col">Year</th>
                                    @if($user->id === 1)
                                        <th scope="col">Actions</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($dates as $date)
                                    <tr data-id="{{$date->id}}">
                                        <td>{{$date->day}}</td>
                                        <td>{{$date->month}}</td>
                                        <td>{{$date->year}}</td>
                                        @if($user->id === 1)
                                            <td>
                                                <i class="fas fa-edit mr20"></i>
                                                <i class="fas fa-trash-alt exist"></i>
                                            </td>
                                        @endif
                                    </tr>
                                @empty
                                @endforelse
                                </tbody>
                            </table>
                            {{$dates->links('vendor.pagination.bootstrap-4')}}
                        @else
                            <span>No dates yet</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
