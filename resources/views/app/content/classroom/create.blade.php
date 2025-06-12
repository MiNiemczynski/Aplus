<?php
use App\Helpers\ColorHelper;

if (isset($classroom) && $classroom != null)
    $action = "Edit";
else
    $action = "Create";
?>

<div class="container">
    <h2 class="mb-4">{{ $action }}:</h2>

    <div class="card mb-4">
        <div class="card-header {{ Colorhelper::randomColor() }} text-white">{{ $action == "Edit" ? "Classroom" : "New classroom" }}
        </div>
        <div class="card-body">
            <form method="post" action="/classroom/{{ $action }}{{ $action == "Edit" ? "/" . $classroom->Id : ""}}">
                @csrf
                @if ($action == 'Edit')
                    @method('PUT')
                @endif
                <div class="row gy-3">
                    <div class="col-md-12 col-lg-6 col-xxl-4">
                        <div class="input-group">
                            <label class="input-group-text">
                                Number
                            </label>
                            <input name="room" type="number" value="{{ $classroom->RoomNumber ?? "" }}" class="form-control validate">
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xxl-4">
                        <div class="input-group">
                            <label class="input-group-text">
                                Floor
                            </label>
                            <input name="floor" type="number" value="{{ $classroom->FloorNumber ?? "" }}" class="form-control validate">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-success">{{ $action == "Edit" ? "Save Changes" : "Save" }}</button>
                    </div>
                </div>
            </form>
            @if($action == "Edit")
                <form method="post" class="pt-3"  action="/classroom/Delete/{{ $classroom->Id }}">
                    @csrf
                    @method('DELETE')
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>