@extends('master')
@section('title', '- Artikel')

@section('content-page')
<!-- Content Row -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <!-- Approach -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 text-center">
                <h4 class="m-0 font-weight-bold text-primary">{{ $article->title }}</h4>
                <p>Pengarang: {{ $article->users->name }}</p>
            </div>
            <div class="card-body">
                <h5>{{ $article->content }}</h5>
            </div>
        </div>
    </div>
</div>
@endsection
