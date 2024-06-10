@extends('admin.layouts.main')

@section('title', $data['title'])
@section('description', $data['description'])
@section('keywords', $data['keywords'])
@section('user-name', $data['user-name'])

@section('content')

    <main class="admin-panel-main">
        <div class="container">
            <div class="container-content">
                <component-admin-news></component-admin-news>
                <component-admin-user-reviews></component-admin-user-reviews>
            </div>
        </div>
    </main>

@endsection

