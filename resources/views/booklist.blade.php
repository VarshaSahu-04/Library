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
                            <h4>Books List</h4>
                        </div>
                    </div>
                    
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                       <div class="basic-form">
                                <form method='post' action="{{ route('rentbook') }}">
                                @csrf
                                        <div class="form-row align-items-center">
                                            <div class="col-auto">
                                                <label class="sr-only">Name</label>
                                                <select id="inputBook" name='book' class="form-control">
                                                    <option selected>Books...</option>
                                                    @foreach($bks as $val)
                                                    <option  value=<?php echo $val->id ?>><?php echo $val->title ?></option>
                                                    
                                                    @endforeach

                                                </select>
                                            </div>
                                            <div class="col-auto">
                                                <label class="sr-only">Useremail</label>
                                                <select id="inputUser" name='user' class="form-control">
                                                    <option selected>Students...</option>
                                                    @foreach($users as $user)
                                                    <option value=<?php echo $user->id ?>><?php echo $user->name ?></option>
                                                   
                                                    @endforeach
                                                </select>
                                            </div>                                       
                                            
                                                <button type="submit" class="btn btn-primary mb-2">Rent Books</button>
                                            
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
                    <div class="col-15">
                        <div class="card">
                            
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                               <th>ISBN</th>
                                                <th>Book Title</th>
                                                <th>Author</th>
                                                <th>Genre</th>
                                                <th>Rented By</th>
                                                <th>Rented At</th>
                                                <th>Returned At</th>
                                                <th>Due At</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>
                                               
                                            @foreach($data as $book)
                                            <tr>
                                                <td><?php echo $book->isbn ?></td>
                                                <td><?php echo $book->title ?></td>
                                                <td><?php echo $book->author ?></td>
                                                <td><?php echo $book->genre_name ?></td>
                                                <td><?php echo $book->username ?></td>
                                                <td><?php echo $book->rented_at ?></td>
                                                <td><?php echo $book->returned_at ?></td>
                                                <td><?php echo $book->due_at ?></td>

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
        table.dataTable td {
        padding: 30px; /* Adjust the padding value as needed */
        }
    </style>

        @endsection