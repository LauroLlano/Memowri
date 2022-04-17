@extends('layouts.app')

@section('title', 'Edit your background')

@push('scripts')
    <script src="{{ url('/js/utilities.js')}}"></script>
    <script src="{{ url('/js/colorpicker.js')}}"></script>
    <script src="{{ url('/js/background.js')}}"></script>
@endpush

@section('content')
    <div class="container">
        <div class="row gy-5">
            <div class="col align-items-center">
                <form action="{{ route('background.update')}}" id="background-form" class="special-container" enctype="multipart/form-data" method="POST">
                    <legend>Edit your background</legend>
                    @csrf
                    @method('PATCH')
                    <div class="row gx-5">

                        <div class="ps-5 pe-5 col-12 col-lg-6">
                            <div class="row">
                                <label for="">Background preview:</label>
                            </div>
                            <div class="row d-flex justify-content-center" >
                                @if($background->image!=NULL)
                                    <img src="{{ asset( $background->image->route) }}" alt="{{ $background->image->route}}" id="image-front" class="img-fluid">
                                @else
                                    <img src="" alt="No image selected" id="image-front" class="img-fluid">
                                @endif
                                <canvas id="image-background" ></canvas>
                            </div>

                            <div class="mt-3 d-grid">
                                <input type="file" id="file-container" name="file-container" accept=".png,.jpg,.bmp,.jpeg" hidden />

                                <label for="file-container" id="labelButton" class="d-flex justify-content-center">Upload image</label>
                                <span id="file-chosen" class="ms-2">{{ $background->image!=NULL ? $background->image->name : "No image selected"}}</span>
                            </div>
                        </div>

                        <div class="ps-5 col-12 col-lg-6 mt-5 mt-lg-0">
                            <div class="row">
                                <label for="">Color picker</label>
                            </div>

                            <div class="row">
                                <div id="colorPickerContainer" class="d-flex justify-content-center">

                                    <div id="squarePicker" style="display: inline-block;" load="#{{ $background->color->hex_code }}">
                                        <div id="squareParent" style="width: 300px;height: 300px;position: relative;">
                                            <div id="colorGradientMarker" style="top: {{$background->cursor->gradient_y}}px; left: {{$background->cursor->gradient_x}}px">
                                                <div style="width: 12px;height: 12px;border: 3px solid white;border-radius: 50%;box-sizing: border-box;"></div>
                                            </div>
                                            <canvas width="300px" height="300px" id="colorGradient"></canvas>
                                        </div>

                                    </div>


                                    <div style="display: inline-block; margin-left: 20px;" id="verticalPicker">
                                        <div style="width: 40px;height: 300px;position: relative;" id="colorParent">
                                            <div id="colorPickerMarker" style="top: {{$background->cursor->color_y}}px; left: {{$background->cursor->color_x}}px"></div>
                                            <canvas width="40px" height="300px" id="colorPicker" style="border-radius: 0px;"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="d-flex justify-content-center" id="alphaFilter" style="visibility: {{$background->image!=NULL? 'visible' : 'hidden'}};">
                                <label for="">Alpha channel</label>
                                <input type="range" id="colorAlpha" min="0" max="1" step="0.1" value="{{ $background->image==NULL ? 1 : $background->image->opacity }}">
                            </div>

                        </div>
                    </div>
                    <div class="row mt-3 ps-5 pe-5 pb-3">
                        <div class="d-grid">
                            <button type="button" id="background-submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
