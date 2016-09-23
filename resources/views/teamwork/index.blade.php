@extends('layouts.app')

@section('content')
    <div class="o-teams">
        <header class="o-teams__header" layout="row center-left">
            <h2 class="o-headline--second o-headline--light">Projects</h2>

            @if(auth()->user()->hasPermission('create teams'))
                <a class="o-button o-button--blue o-button--small" self="right" href="{{route('teams.create')}}">
                    @lang('projects.create')
                </a>
            @endif

        </header>
        @each('teamwork.teams.team', $teams, 'team', 'teamwork.teams.empty')
    </div>
@endsection
