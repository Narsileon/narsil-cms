@extends('narsil::layouts.auth')

@section('hideBreadcrumb')
@endsection

@section('body')
	<livewire:narsil-cms-live-editor :site-page="$sitePage" />
@endsection
