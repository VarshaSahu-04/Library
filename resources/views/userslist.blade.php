@extends('layouts.app')

@section('title', 'Home Page')

@section('content')
 <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                    <div class="welcome-text">
                            <h4>Students List</h4>
                        </div>
                                
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                       <div class="basic-form">
                                <form method='post' action="{{ route('add') }}">
                                @csrf
                                        <div class="form-row align-items-center">
                                            <div class="col-auto">
                                                <label class="sr-only">Name</label>
                                                <input type="text" class="form-control mb-2" name='name' placeholder="Username" required autocomplete="off">
                                            </div>
                                            <div class="col-auto">
                                                <label class="sr-only">Useremail</label>
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">@</div>
                                                    </div>
                                                    <input type="email" class="form-control" name='email' placeholder="Email" required autocomplete="off">
                                                </div>
                                            </div>                                       
                                            
                                                <button type="submit" class="btn btn-primary mb-2">Add Student</button>
                                            
                                        </div>
                                    </form>
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                    <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                    </ul>
                                    </div>
                                    @endif
                        </div> 
                    </div>
                </div>
                <!-- row -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                               <th>User no</th>
                                                <th>User name</th>
                                                <th>User email</th>
                                                <th>Created At</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                               
                                            @foreach($data as $users)
                                            <tr>
                                                <td><?php echo $users->id ?></td>
                                                <td><?php echo $users->name ?></td>
                                                <td><?php echo $users->email ?></td>                                               
                                                <td><?php echo $users->created_at ?></td>

                                            </tr>  
                                            @endforeach
   
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                                       
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        <style>
        /* Hide the length dropdown */
        #example_length {
            display: none;
        }
    </style>

        @endsection