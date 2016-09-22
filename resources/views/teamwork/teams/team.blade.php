<div class="o-team {{auth()->user()->currentTeam->id == $team->id ? 'is-active' : ''}}">
    <div class="o-team__image"></div>
    <h4 class="o-team__name">{{$team->name}}</h4>
    <div class="o-team__url">{{preg_replace("(^(http://|https://)?(www.)?)", "", $team->url )}}</div>
    <div class="o-team__switch-bar">
        @if(is_null(auth()->user()->currentTeam) || auth()->user()->currentTeam->getKey() !== $team->getKey())
            <a href="{{route('teams.switch', $team)}}" class="o-button o-button--tiny">
                @lang('projects.switchToButton')
            </a>
        @else
            <div class="o-button o-button--blue o-button--filled o-button--tiny" disabled>@lang('projects.switchIsActiveButton')</div>
        @endif
    </div>
</div>
{{--
            @if(auth()->user()->isOwnerOfTeam($team))
                <span class="label label-success">Owner</span>
            @else
                <span class="label label-primary">Member</span>
            @endif
        </td>
        <td>

            <a href="{{route('teams.members.show', $team)}}" class="btn btn-sm btn-default">
                <i class="fa fa-users"></i> Members
            </a>

            @if(auth()->user()->isOwnerOfTeam($team))

                <a href="{{route('teams.edit', $team)}}" class="btn btn-sm btn-default">
                    <i class="fa fa-pencil"></i> Edit
                </a>

                <form style="display: inline-block;" action="{{route('teams.destroy', $team)}}" method="post">
                    {!! csrf_field() !!}
                    <input type="hidden" name="_method" value="DELETE" />
                    <button class="btn btn-danger btn-sm"><i class="fa fa-trash-o"></i> Delete</button>
                </form>
            @endif
        </td>
    </tr> --}}
