@extends('admin.layouts.master')

@section('content')
    

    <section class="section">
      <div class="section-header">
        <h1>Ecommerce Service</h1>

      </div>

      <div class="section-body">
       
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Create Ecommerce Service</h4>
              </div>
              <div class="card-body">

                <form action="{{route('admin.ecommerce-service.store')}}" method="POST">
                    @csrf
                   
                        <div class="form-group">
                            <label>Icon</label>
                            <div>
                                <button class="btn btn-primary" data-selected-class="btn-danger"
                                data-unselected-class="btn-info" role="iconpicker"  name="icon"></button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Service Heading</label>
                            <input type="text" class="form-control" name="heading">
                        </div>

                        <div class="form-group">
                          <label>Service</label>
                          <input type="text" class="form-control" name="service">
                      </div>
                        
                        <div class="form-group">
                            <label for="inputState">Status</label>
                            <select id="inputState" class="form-control" name="status">
                              <option value="1">Active</option>
                              <option value="0">Inactive</option>
                            </select>
                          </div>
        
                          <button type="submit" class="btn btn-primary">Create</button>
                    </form>
    

                </div>
              </div>
        
            </div>
          </div>
        </div>
      </div>
    </section>

 

@endsection