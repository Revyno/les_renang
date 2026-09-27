<div class="col-xl-3 col-lg-4 col-md-6 mt-4">
    <div class="card bg-transparent border-0 text-center">
        <div class="card-img">
            <img loading="lazy" decoding="async" src="{{asset('storage/'. $team->imgUrl)}}" alt="{{$team->name}}"
                class="rounded w-100" width="300" height="332">
            <ul class="card-social list-inline">
                <li class="list-inline-item"><a class="facebook" href="{{$team->fblink}}"><i
                            class="fab fa-facebook"></i></a>
                </li>
                <li class="list-inline-item"><a class="twitter" href="{{$team->twitterlink}}"><i
                            class="fab fa-twitter"></i></a>
                </li>
                <li class="list-inline-item"><a class="instagram" href="{{$team->instalink}}"><i
                            class="fab fa-instagram"></i></a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <h3>{{$team->name}}</h3>
            <p>{{$team->position}}</p>
        </div>
    </div>
</div>