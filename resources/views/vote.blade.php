@extends('layout.master')
@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Dự đoán tỉ số</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('vote.vote') }}" method="POST">
                @csrf
               <div class="row">
                     <div class="col-md-5">
                          <div class="form-group">
                              <label for="team1">Vườn hoa đà lạt</label>
                              <input type="text" name="team1" class="form-control" id="team1" value="{{ old('team1') }}">
                              @error('team1')
                                  <p class="text-danger">{{ $message }}</p>
                              @enderror
                          </div>
                     </div>

                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="team2">Pepapig</label>
                                <input type="text" name="team2" class="form-control" id="team2" value="{{ old('team2') }}">
                                @error('team2')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
               </div>

        </div>
        <div class="card-footer">
           <button type="submit" class="btn btn-primary">Bình chọn</button>
        </div>
@endsection
