@extends('frontend.layouts.master')
@section('title', '404')


@section('css')
    <style>
      .big-title {
      font-size:150px;
          font-family: GothamThin;
      }
        ul.list {
            padding:0px;
            margin:0px;
        }
        .list li {
            padding:0px;
            margin:0px;
        }

        .link {
            font-family: Gotham-Bold;
        }
    </style>
@endsection

@section('container')

    <section class="bg-grey">
        <div class="container">
            <div class="heading text-center animate bounceIn">
                <h2 class="big-title">404</h2>
                <p>{{ trans('messages.404_mesaj') }}</p>
                <p>{!! trans('messages.404_link_mesaj') !!}</p>
            </div>
    </section>


@endsection