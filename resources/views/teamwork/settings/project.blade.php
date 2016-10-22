@extends('layouts.app')

@section('content')
    @include('teamwork.settings.menu')

    <div class="o-content o-content--max-width">
        {{ Form::open(['class' => "o-form",'url' => route('teams.settings.project.put'), 'method' => 'put']) }}
            <section class="o-section o-section--no-top-padding o-section--no-bottom-padding">
                <material-input name="project_name" value="{{old('project_name', $project->project_name)}}" label="{{trans('settings.project.label_name')}}" required message="{{ $errors->first('project_name') }}"></material-input>
                <material-input name="site_url" value="{{old('site_url', 'http://test.de')}}" label="{{trans('settings.project.label_url')}}" required message="{{ $errors->first('site_url') }}"></material-input>
                <material-input name="dir_images" value="{{old('dir_images', 'test')}}" label="{{trans('settings.project.label_images_dir')}}" required message="{{ $errors->first('dir_images') }}"></material-input>
                <div class="u-margin-top">
                    @include('forms.submit',['label' => 'Save', 'classes' => 'o-button o-button--blue o-flex-bar__item o-flex-bar__item--right'])
                </div>
            </section>
        </form>
    </div>

@endsection
