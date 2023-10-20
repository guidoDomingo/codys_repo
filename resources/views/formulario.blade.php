@extends('welcome')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <h1>Formulario</h1>
            @if (session('success'))
                <div id="success-alert" class="alert alert-success alert-dismissible show fade">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ session('success') }}
                </div>
            @endif



            <form action="{{ route('formulario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="nombre_apellido">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="nombre_apellido">Apellido</label>
                    <input type="text" name="apellido" id="apellido" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="correo">Correo Electrónico</label>
                    <input type="email" name="correo" id="correo" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="telefono">Teléfono</label>
                    <input type="text" name="telefono" id="telefono" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="foto_perfil">Foto de Perfil</label>
                    <input type="file" name="foto_perfil" id="foto_perfil" class="form-control-file" accept="image/*"
                        onchange="previewImage(this);">
                </div>
                <img id="imagePreview" src="{{ asset('user.png') }}" alt="Previsualización de imagen"
                    style="max-width: 100%; max-height: 150px;">


                <button type="submit" class="mt-5 btn btn-primary always-visible-button">Enviar</button>

            </form>
        </div>


        <div class="col-md-8">
            <h1>Lista de Usuarios Registrados</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Correo Electrónico</th>
                        <th>Acciones</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->nombre }}</td>
                            <td>{{ $usuario->apellido }}</td>
                            <td>{{ $usuario->correo }}</td>
                            <td>
                                <a href="{{ route('formulario.edit', $usuario->id) }}"
                                    class="btn btn-primary btn-sm">Editar</a>
                                <form action="{{ route('formulario.destroy', $usuario->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection

@section('js')
    <script>
        function previewImage(input) {
            var imagePreview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                imagePreview.src = '';
            }
        }

        setTimeout(function() {
            var successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 5000); // 5000 milisegundos = 5 segundos
    </script>
@endsection

@section('css')
    <style>
        .always-visible-button {
            opacity: 1;
            background-color: #0B5ED7;
            /* Establece la opacidad en 1 para que el botón siempre sea visible */
        }

        body {
            background-color: rgb(214, 209, 209);
        }

        .btn-danger {
            background-color: red;
        }
    </style>
@endsection
