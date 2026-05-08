@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-24 space-y-8">

    {{-- Page title --}}
    <h1 class="text-3xl font-extrabold text-slate-900">
        {{ __('messages.Profile') }}
    </h1>

    {{-- Profile information --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 sm:p-8">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- Password --}}
    <div class="bg-white rounded-3xl shadow-xl border border-slate-100 p-6 sm:p-8">
        @include('profile.partials.update-password-form')
    </div>

    {{-- Delete account --}}
    <div class="bg-white rounded-3xl shadow-xl border border-rose-200 p-6 sm:p-8">
        @include('profile.partials.delete-user-form')
    </div>

</div>
@endsection