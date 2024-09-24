@extends('layouts.adminapp')



@section('content')
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card">Superadmin Dashboard</div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="">Felhasználók</a>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Felhasználók kezelése</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="">Stripe</a>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">Stripe kezelése</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
