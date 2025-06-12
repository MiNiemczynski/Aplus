<?php
use App\Helpers\ColorHelper;

if (isset($teacher) && $teacher != null)
    $action = "Edit";
else
    $action = "Create";
?>

<div class="container">
    <h2 class="mb-4">{{ $action }}:</h2>

    <div class="card mb-4">
        <div class="card-header {{ Colorhelper::randomColor() }} text-white">{{ $action == "Edit" ? "Teacher" : "New teacher" }}
        </div>
        <div class="card-body">
            <form method="post" action="/teacher/{{ $action }}{{ $action == "Edit" ? "/" . $teacher->Id : ""}}">
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
                            <input name="name" value="{{ $teacher->user->Name ?? "" }}" class="form-control validate" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xxl-4">
                        <div class="input-group">
                            <label class="input-group-text">
                                E-mail
                            </label>
                            <input name="email" type="email" value="{{ $teacher->user->Email ?? "" }}" class="form-control validate" required>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6 col-xxl-4">
                        <div class="input-group">
                            <label class="input-group-text">
                                Salary
                            </label>
                            <input name="salary" type="number" step=".01" value="{{ $teacher->Salary ?? "" }}" class="form-control validate">
                        </div>
                    </div>
                    @if($action == "Create")
                        <div class="col-md-12 col-lg-6 col-xxl-4">
                            <div class="input-group">
                                <label class="input-group-text">
                                    Password
                                </label>
                                <input name="password" type="password" class="form-control validate">
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-6 col-xxl-4">
                            <div class="input-group">
                                <label class="input-group-text">
                                    Repeat password
                                </label>
                                <input name="password_repeat" type="password" class="form-control validate">
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12">
                        <button type="submit"
                            class="btn btn-success">{{ $action == "Edit" ? "Save Changes" : "Save" }}</button>
                    </div>
                </div>
            </form>
            @if($action == "Edit")
                <form method="post" class="pt-3"  action="/teacher/Delete/{{ $teacher->Id }}">
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