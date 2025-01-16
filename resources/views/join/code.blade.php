@extends('layout.master')
@section('content')
    <div class="container">

        <div class="card mt-3">
            <div class="card-header">
                <h4>Gia nhập tổ đội</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('join.join_team_detail') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="url">Mã tổ đội</label>
                        <input type="text" class="form-control" name="team_code" id="validationTooltip03"
                            placeholder="Tên tổ đội của bạn" required="" value="{{ old('team_code') }}">
                        <div class="invalid-feedback">
                            Vui lòng nhập mã đội.
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Gia nhập</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
