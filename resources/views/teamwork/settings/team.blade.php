@extends('layouts.app')

@section('content')
    @include('teamwork.settings.menu')

    <div class="o-content o-content--max-width">
        <div class="o-flexbar">
        @if(auth()->user()->isOwnerOfTeam($team))
            <div class="o-flexbar__item o-flexbar__item--right">
                <form class="form-horizontal" method="post" action="{{route('teams.members.invite', $team)}}">
                    {!! csrf_field() !!}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>


                    <div class="form-group">
                            <button type="submit" class="o-button o-button--blue">
                                Invite
                            </button>
                    </div>
                </form>
        </div>
        @endif
    </div>
    <div class="o-content o-content--max-width">
        <ul class="o-data-grid">
            @foreach($team->users as $user)
                <li class="o-data-grid__item o-flexbar">
                    <span class="o-flexbar__item">{{$user->name}}</span>
                    @if(auth()->user()->isOwnerOfTeam($team))
                        @if(auth()->user()->getKey() !== $user->getKey())
                            <form class="o-flexbar__item o-flexbar__item--right" action="{{route('teams.members.destroy', [$team, $user])}}" method="post">
                                {!! csrf_field() !!}
                                <input type="hidden" name="_method" value="DELETE" />
                                <button class="o-link o-link--red">Delete</button>
                            </form>
                        @endif
                    @endif
                </li>
            @endforeach
        </ul>
        @if(auth()->user()->isOwnerOfTeam($team))
            <h3 class="o-headline o-headline--third">Pending invitations</h3>
            <ul class="o-data-grid">
                @foreach($team->invites AS $invite)
                    <li class="o-data-grid__item o-flexbar">
                        <span class="o-flexbar__item">{{$invite->email}}</span>
                        <a href="{{route('teams.members.resend_invite', $invite)}}" class="o-flexbar__item o-flexbar__item--right o-link">
                            Resend invite
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
