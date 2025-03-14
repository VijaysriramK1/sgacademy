<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Integration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert2/11.1.10/sweetalert2.min.css">

    <style>
        .primary_input_label {
            font-weight: 500;
        }

        /* .primary_input_field {
            margin-bottom: 35px;
        } */
        .mt-25 {
            margin-top: 50px;
        }

        .fix-gr-bg {
            background-color: #28a745;
            color: #fff;
        }

        .tr-bg {
            background-color: #6c757d;
            color: #fff;
        }

        body {
            background-color: #f8f9fa;
        }

        .card {
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 5%;
        }

        .card-title {
            color: #343a40;
        }

        .form-control,
        .form-select {
            border-radius: 5px;
            box-shadow: none;
            border-color: #ced4da;
        }

        .form-control:focus,
        .form-select:focus {
            box-shadow: 0 0 0 0.1rem #7C32FF;
            border-color: #7C32FF;
        }

        #save_button_query {
            /* position:sticky;
            width: 15%; */
            border-radius: 5px;
            background-color: #7C32FF;
            border-color: #7C32FF;
            font-weight: bold;
        }

        #cancel_button {
            /* position:sticky;
            width: 15%; */
            border-radius: 5px;
            font-weight: bold;
        }

        .logo {
            top: 15px;
            left: 25px;
            margin-left: 42%;
            width: 14%;
        }

        select.form-control {
            appearance: auto;
            -webkit-appearance: auto;

        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <img src="{{ asset('/logo/SG logo.png') }}" alt="Logo" class="logo">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card ">
                    <div class="card-body">
                        <h3 class="card-title text-center">Student Admission Form</h3><br>
                        <form id="lead-integration-form" method="POST" action="{{ route('lead_form.store') }}">
                            @csrf
                            <input type="hidden" name="source_id" id="source_id" value="{{ $id ?? '' }}">


                            <div class="row">
                                <div class="col-lg-6 mt-25">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="first_name">First Name<span class="text-danger"> *</span></label>
                                        <input class="primary_input_field form-control" type="text" name="first_name" id="first_name" required>
                                        @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-25">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="last_name">Last Name<span class="text-danger"> *</span></label>
                                        <input class="primary_input_field form-control" type="text" name="last_name" id="last_name" required>
                                        @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-25">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="email">Email<span class="text-danger"> *</span></label>
                                        <input class="primary_input_field form-control" type="email" name="email" id="email" required>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 mt-25">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="mobile">Mobile Number<span class="text-danger"> *</span></label>
                                        <input class="primary_input_field form-control" type="text" name="mobile" id="mobile" required>
                                        @error('mobile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-6 mt-25">
                                    <div class="primary_input">
                                        <label class="primary_input_label" for="program_id">Program<span class="text-danger"> *</span></label>
                                        <select name="program_id" id="program_id" class="primary_select form-control" required>
                                            <option value="" disabled selected>Select the Program <span class="text-danger">*</span></option>
                                            @foreach($programs as $program)
                                            <option value="{{ $program->id }}">
                                                {{ $program->name ?? 'N/A' }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('program_id')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12 text-center mt-25">
                                    <div class="d-flex justify-content-center gap-3 mt-3">
                                        <button type="button" class="btn btn-danger" id="cancel_button" onclick="window.location='{{ url()->previous() }}'">Cancel</button>
                                        <button class="btn btn-primary" id="save_button_query" type="submit">Save</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Success Message Handling -->
                        @if(session('success'))
                        <div class="alert alert-success mt-3">{{ session('success') }}</div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
            @endif

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
            @endif
        });
    </script>

</body>

</html>