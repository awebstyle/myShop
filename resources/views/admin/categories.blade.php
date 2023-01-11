@extends('template.indexAdmin')

@section('title')
    Shopping - categories
@endsection

@section('css')
    <!-- DataTables -->
  <link rel="stylesheet" href="{{asset('backend/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('backend/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endsection

@section('content')
 <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Categories</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Categories</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Categories</h3>
              </div>
              @if (Session::has("status"))
                <br/>
                <div class="alert alert-success">
                  {{Session::get('status')}}
                </div>
              @endif
              <input type="hidden" {{$increment = 1}}>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Num.</th>
                    <th>Category Name</th>
                    <th>Actions</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach ($categories as $category)
                    <tr>
                      <td>{{$increment}}</td>
                      <td>{{$category->category_name}}
                      </td>
                      <td>
                        <div style="display: flex; justify-content: space-around;">
                          {{-- <form style="max-width: 25%;" action="{{route('editcategory', [$category->id])}}" method="POST">
                            @csrf
                            @method("PUT")
                            <button type="submit" id="edit" class="btn btn-primary" value=""><i class="nav-icon fas fa-edit"></i></button>
                          </form> --}}
                          <a href="{{route('editcategory', [$category->id])}}" class="btn btn-primary"><i class="nav-icon fas fa-edit"></i></a>
                          {{-- <a href="#" id="delete" class="btn btn-danger" ><i class="nav-icon fas fa-trash"></i></a> --}}
                          <form style="max-width: 25%;" action="{{route('deletecategory', [$category->id])}}" method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" id="delete" class="btn btn-danger" value=""><i class="nav-icon fas fa-trash"></i></button>
                          </form>
                        </div>
                      </td>
                    </tr>
                    <input type="hidden" {{$increment++}}>
                  @endforeach
                  </tbody>
                  <tfoot>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  
@endsection

@section('scripts')
  <!-- DataTables -->
<script src="{{asset('backend/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true,
      "autoWidth": false,
    });
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
@endsection

