@extends('layouts.app')
@section('maincontent')
    <style>
        .doc-body {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
            border: solid 1px rgb(225, 224, 225)9;
            background: rgba(255, 255, 255, 0.603);
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(61, 61, 61, 0.1);
        }

        .doc-data-row {
            display: flex;
            flex-direction: column;
            width: 80%;
            height: auto;
            margin: 5px auto;
            padding-top: 20px;
            border: solid 1px rgb(225, 224, 225)9;
            background: rgba(255, 255, 255, 0.603);
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px rgba(61, 61, 61, 0.1);
        }

        .doc-data-title {
            font-size: 24px;
            font-style: normal;
            font-weight: 600;
            line-height: normal;
            margin: 0;
            padding: 5px;
            background: transparent;
            text-align: left;
            padding: 5px;
            color: black;
        }
    </style>
    <div class="category-page-content">
        <div class="doc-data-row">
            <div class="doc-body">
                <div class="doc-data-title">
                    <p>{{ $document->title }}</p>
                </div>
                <div>
                    {!! $document->body !!}
                </div>
            </div>
        </div>
    </div>
@endsection
