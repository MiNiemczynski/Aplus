<?php
use App\Helpers\ColorHelper;

if (isset($classgroup) && $classgroup != null)
    $action = "Edit";
else
    $action = "Create";
?>

<div class="container">
    <h2 class="mb-4">{{ $action }}:</h2>

    <div class="card mb-4">
        <div class="card-header {{ Colorhelper::randomColor() }} text-white">{{ $action == "Edit" ? "Class group" : "New class group" }}
        </div>
        <div class="card-body">
            <form method="post" action="/classgroup/{{ $action }}{{ $action == "Edit" ? "/" . $classgroup->Id : ""}}">
                @csrf
                @if ($action == 'Edit')
                    @method('PUT')
                @endif
                <div class="row gy-3">
                    <div class="col-md-12 col-lg-6 col-xxl-4">
                        <div class="input-group">
                            <label class="input-group-text">
                                Name
                            </label>
                            <input name="name" value="{{ $classgroup->Name ?? "" }}" class="form-control validate">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-success">{{ $action == "Edit" ? "Save Changes" : "Save" }}</button>
                    </div>
                </div>
            </form>
            @if($action == "Edit")
                <form method="post" class="pt-3"  action="/classgroup/Delete/{{ $classgroup->Id }}">
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