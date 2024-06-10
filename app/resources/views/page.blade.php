@extends('layouts.main')

@section('title', $data['title'])
@section('description', $data['description'])
@section('keywords', $data['keywords'])
@section('user-name', $data['user-name'])

@section('og-type', $data['open-graph']['type'])
@section('og-title', $data['open-graph']['title'])
@section('og-description', $data['open-graph']['description'])
@section('og-image', $data['open-graph']['image'])
@section('og-image-height', $data['open-graph']['image-height'])
@section('og-image-width', $data['open-graph']['image-width'])
@section('og-url', $data['open-graph']['url'])

@section('content')

    <main class="site-main-page">
        <div class="container">
            <div class="container-content">
                <component-breadcrumbs
                    :breadcrumbs='<?php echo json_encode($data['breadcrumbs'], JSON_UNESCAPED_UNICODE); ?>'
                ></component-breadcrumbs>

                <component-page-single
                    :page='<?php echo json_encode($data['page'], JSON_UNESCAPED_UNICODE); ?>'
                ></component-page-single>
            </div>
        </div>
    </main>

@endsection

