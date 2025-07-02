@extends('service_provider.serviceprovider_Dashboard')
@section('title' , 'Change Password')

@section('service_provider')


<div class="page-content">
    <div class="container-fluid">

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4">

                        <h4 class="card-title mb-4 text-center text-primary">change password</h4>
    @if (session('status'))
		 <div class="alert alert-success" role="alert">
		 		{{session('status')}}
		 </div>
		 @elseif(session('error'))
		 <div class="alert alert-danger" role="alert">
		 	{{session('error')}}
		 </div>
	@endif


                        <form method="post" action="{{ route('Service_Provider.update.password') }}" >
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">old password</label>
                                <input name="old_password" id="old_password" class="form-control @error('old_password') is-invalid @enderror" type="password" >
                            </div>
                            @error('old_password')
					         <span class="text-danger">{{ $message }}</span>
					        @enderror

                            <div class="mb-3">
                                <label class="form-label">new password</label>
                                <input name="new_password" id="new_password" class="form-control @error('new_password') is-invalid @enderror" type="password" >
                            </div>
                                @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                            <div class="mb-3">
                                <label class="form-label">confirm password</label>
                                <input name="new_password_confirmation" id="new_password_confirmation" class="form-control" type="password" >
                            </div>


                            <div class="text-center">
                               <button type="submit" class="btn btn-primary btn-sm w-auto px-4">change password</button>
                           </div>


                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



@endsection
