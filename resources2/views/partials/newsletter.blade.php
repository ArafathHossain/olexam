<!-- ============================== Start Newsletter ================================== -->

<section class="newsletter theme-bg inverse-theme">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-8 col-sm-12">
                <div class="text-center">
                    <h2>Join Thousand of Happy Students!</h2>
                    <p>Subscribe our newsletter & get latest news and updation!</p>
                    <form class="sup-form" method="POST" action="{{ route('news') }}">

                        @csrf
                        <input type="email" class="form-control sigmup-me @error('email') is-invalid @enderror" placeholder="Your Email Address" name="email" required="required" >
                        <input type="submit" class="btn btn-theme" value="Get Started">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @method('POST')
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================= End Newsletter =============================== -->