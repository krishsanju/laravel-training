@extends('app')

@section('content')
    <section>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5 mb-5">
                 <div class="card-body">
                     <form method="post" action="{{ route('file.submit') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">File</label>
                            <input type="file" class="form-control" id="" name = "file" >
                            @error('file')
                                {{ $message }}
                            @enderror
                        </div>                         
                         
                         <button type="submit" class="btn btn-primary">Submit</button>
                     </form>
                 </div>
                 <table>
                    <tbody>
                        @foreach ($files as $file)
                            <td><img style="width:150px" src="{{ $file->file_path }}" alt=""></td>
                             <!-- <td><img style="width:150px" src="{{ asset('file->file_path')  }}" alt=""></td> -->
                        @endforeach
                    </tbody>
                 </table>
                </div>
                <table>
                   <tbody>
                       <!-- @foreach ($files as $file) -->
                           <td><a href="{{ route("file.download") }}">Download file</td>
                       <!-- @endforeach -->
                   </tbody>
                </table>
             </div>
        </div>

    </section>

@endsection