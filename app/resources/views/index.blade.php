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

    <main class="site-main">
        <div class="container">
            <div class="container-content">
                <component-index-slider
                    app_env={{ $data['app-env'] }}
                ></component-index-slider>

                <component-index-our-advantages
                    app_env={{ $data['app-env'] }}
                ></component-index-our-advantages>

                <component-index-banner
                    app_env={{ $data['app-env'] }}
                ></component-index-banner>

                <component-index-reviews
                    app_env={{ $data['app-env'] }}
                    :reviews-list='<?php echo json_encode($data['reviews-list'], JSON_UNESCAPED_UNICODE); ?>'
                ></component-index-reviews>
            </div>
        </div>
    </main>

@endsection

