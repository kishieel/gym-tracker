<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-5 bg-opacity-75">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="{{ secure_asset('static/logo.png')  }}" alt="" width="30" height="30"
                 class="d-inline-block align-text-top">
            Gym Tracker
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarToggle"
                aria-controls="navbarToggle" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarToggle">
            <div class="navbar-nav me-auto mb-2 mb-sm-0" aria-label="breadcrumb">
                <ol class="breadcrumb text-light mb-md-0">
                    @foreach($breadcrumbs as $url => $breadcrumb)
                        <li class="breadcrumb-item @if($loop->last) active @endif" aria-current="page">
                            @if(is_string($url))
                                <a href="{{ $url  }}">{{ $breadcrumb }}</a>
                            @else
                                {{ $breadcrumb }}
                            @endif
                        </li>
                    @endforeach
                </ol>
            </div>
            <form class="d-flex" action="{{ route('sign-out.action') }}" method="post">
                @csrf
                <a href="#" class="btn btn-outline-light me-2">Profile</a>
                <button class="btn btn-outline-light" type="submit">Sign out</button>
            </form>
        </div>
    </div>
</nav>
