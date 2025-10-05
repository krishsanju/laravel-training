@extends('app')

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 mb-5">
                 <div class="card-body">
                     <form method="post" action="{{ route('contact.submit') }}">
                        @csrf 

                        @if($errors->all())
                            @foreach ($errors->all() as $error)
                                {{ $error }}  <br>                          
                            @endforeach
                        @endif
                        <!-- <input type="hidden" name="__token" value="{{ csrf_token() }}"> -->
                         <div class="mb-3">
                             <label for="" class="form-label">Name</label>
                             <input type="text" class="form-control" id="" name = "name" value = {{ old('name') }}>
                         </div>
                         <div class="mb-3">
                            <label for="" class="form-label">Email</label>
                            <input type="email" class="form-control" id="" name = "email" value = {{ old('email') }}>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="" name = "subject" value = {{ old('subject') }}>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Message</label>
                            <textarea class="form-control" name = "message" >{{ old('message') }}</textarea>
                        </div>
                         
                         
                         <button type="submit" class="btn btn-primary">Submit</button>
                     </form>
                 </div>
                </div>
             </div>
        </div>

    </section>

@endsection