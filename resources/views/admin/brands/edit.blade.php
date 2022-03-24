@extends('layouts.admin')

@section('content')

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">الرئيسية </a>
                                </li>
                                <li class="breadcrumb-item"><a href="{{route('admin.brands')}}"> العلامات التجارية </a>
                                </li>
                                <li class="breadcrumb-item active"> <a href="{{route('admin.brands.edit', $brand -> id)}}">  تعديل  {{$brand -> name}} </a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body">
                <!-- Basic form layout section start -->
                <section id="basic-form-layouts">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="form-section"><i class="ft-home"></i>   تحديث بيانات العلامة التجارية -  {{$brand -> name}}   </h4>
                                    <hr style="height:2px;border-width:0;color:gray;background-color:Dimgrey">


                                    <a class="heading-elements-toggle"><i
                                            class="la la-ellipsis-v font-medium-3"></i></a>
                                    <div class="heading-elements">
                                        <ul class="list-inline mb-0">
                                            <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                            <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                            <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                            <li><a data-action="close"><i class="ft-x"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                                @include('admin.includes.alerts.success')
                                @include('admin.includes.alerts.errors')
                                <div class="card-content collapse show">
                                    <div class="card-body">


                                        <form class="form" action="{{route('admin.brands.update',$brand -> id)}}" method="POST"  enctype="multipart/form-data">
                                            @csrf

                                            <input name="id" value="{{$brand -> id}}" type="hidden">

                                            <div class="text-content">
                                                <img style="height: 150px; width: 150px;" src="{{$brand -> logo}}">
                                            </div>

                                            <br>

                                            <div class="form-body">



                                                <div class = "row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label> شعار العلامة التجارية </label>
                                                            <label id="projectinput7" class="file center-block">
                                                                <input type="file" id="file" name="logo">
                                                                <span class="file-custom"></span>
                                                            </label>
                                                            @error('logo')
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label for="projectinput1"> اسم العلامة التجارية </label>
                                                            <input type="text" value="{{$brand -> name}}" id="name"
                                                                   class="form-control"
                                                                   placeholder="  "
                                                                   name="name">
                                                            @error("name")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>




                                                <div class = "row">
                                                    <div class="col-md-4">
                                                        <div class="form-group mt-1">

                                                            <label for="switcheryColor4"
                                                                   class="card-title ml-1">الحالة </label>

                                                            <input type="checkbox"  value="1" name="active"
                                                                   id="switcheryColor4"
                                                                   class="switchery" data-color="success"

                                                                   @if($brand -> active == 1) checked @endif

                                                                   />

                                                            @error("active")
                                                            <span class="text-danger">{{$message}}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>



                                                <div class="form-actions">
                                                    <button type="button" class="btn btn-warning mr-1"
                                                            onclick="history.back();">
                                                        <i class="ft-x"></i> تراجع
                                                    </button>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="la la-check-square-o"></i> حفظ
                                                    </button>
                                                </div>

                                            </div>


                                        </form>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- // Basic form layout section end -->
            </div>
        </div>
    </div>

@endsection