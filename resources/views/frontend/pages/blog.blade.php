@extends('frontend.layouts.master')

@section('title')
    {{ $setting->site_name }} || Blog Details
@endsection

@section('content')
    <!--============================BREADCRUMB START==============================-->
    <section id="wsus__breadcrumb">
        <div class="wsus_breadcrumb_overlay">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h4>our latest blogs</h4>
                        <ul>
                            <li><a href="{{ route('home.page') }}">home</a></li>
                            <li><a href="javascript:;">blogs</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--============================BREADCRUMB END==============================-->


    <!--============================BLOGS PAGE START ==============================-->
    <section id="wsus__blogs">
        <div class="container">

            @if (request()->has('search'))
                <h5>Search: {{ request()->search }}</h5>
                <hr>
            @elseif(request()->has('category'))
                <h5>Search: {{ request()->category }}</h5>
                <hr>
            @endif

            <div class="row">
                @foreach ($blogs as $blog)
                    <div class="col-xl-4 col-sm-6 col-lg-4 col-xxl-3">
                        <div class="wsus__single_blog wsus__single_blog_2">
                            <a class="wsus__blog_img" href="{{ route('blog-details', $blog->slug) }}">
                                <img src="{{ asset($blog->image) }}" alt="blog" class="img-fluid w-100">
                            </a>
                            <div class="wsus__blog_text">
                                <a class="blog_top red"
                                    href="{{ route('blog-details', $blog->slug) }}">{{ $blog->category->name }}</a>
                                <div class="wsus__blog_text_center">
                                    <a href="blog_details.html">{{ $blog->title }} </a>
                                    <p class="date">{{ date('d M Y', strtotime($blog->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if (count($blogs) == 0)
                <div>
                    <div class="row">
                        <div class="card p-5 text-center mt-3">
                            <h3>Sorry no blog found</h3>
                        </div>
                    </div>
                </div>
            @endif

            <div class="mt-5">
                @if ($blogs->hasPages())
                    {{ $blogs->withQueryString()->links() }}
                @endif
            </div>
        </div>
    </section>
    <!--============================BLOGS PAGE END==============================-->
@endsection
