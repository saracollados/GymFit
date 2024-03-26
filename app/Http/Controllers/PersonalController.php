<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Clase;
use App\Models\Sala;
use App\Models\Personal;
use App\Models\Horario;
use App\Models\ReservaServicio;
use App\Models\HorarioServicios;
use App\Models\HorarioClases;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller; 
use App\Http\Controllers\HorariosController; 
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class PersonalController extends Controller {
    public function mostrarDashboard() {
        $usuarios = Usuario::getAll();
        $salas = Sala::getAll();
        $clases = Clase::getAll();
        return view('gymfit/dashboard', compact('usuarios', 'salas', 'clases'));
    }

    public function verPersonal(Request $request) {
        $id = $request->post('id');
        $personal = Personal::getPersonalById($id);
        
        $error = session('error');
        $success = session('success');

        return view('gymfit/personal/verPersonal', compact('personal', 'success', 'error'));
    }

    public function verPersonalGet() {
        $id = session('id');
        $personal = Personal::getPersonalById($id);

        $error = session('error');
        $success = session('success');

        return view('gymfit/personal/verPersonal', compact('personal', 'success', 'error'));
    }

    public function mostrarPersonal() {
        $personal = Personal::getAll();

        $error = session('error');
        $success = session('success');

        return view('gymfit/personal/mostrarPersonal', compact('personal', 'success', 'error'));
    }

    public function crearPersonalForm() {
        $roles = Personal::getRoles();
        return view('gymfit/personal/crearPersonalForm', compact('roles'));
    }

    public function crearPersonal(Request $request) {
        $id_personal = Personal::create($request);

        if($id_personal) {
            $success='El trabajador se ha añadido con éxito.';
            return redirect('/mostrarPersonal')->with(compact('success'));
        } else {
            $error='No se ha podido crear el trabajador.';
            return redirect('/mostrarPersonal')->with(compact('error'));
        }
    }

    public function editarPersonalForm(Request $request) {
        $id = $request->post('id');
        $page = $request->post('page');

        $personal = Personal::getPersonalById($id);
        $roles = Personal::getRoles();
        $miPerfil = false;

        // Comprobar si el perfil que se va a editar es el del usuario que esta logueado
        if (session('userInfo')['id'] == $id) {
            $miPerfil = true;
        }
        
        $error = session('error');
        return view('gymfit/personal/crearPersonalForm', compact('personal', 'miPerfil', 'roles', 'page', 'error'));
    }

    public function editarPersonal(Request $request) {
        $id = $request->post('personal_id');
        $nombre = $request->post('nombre');
        $email = $request->post('email');
        $page = $request->post('page');
        $password_actual = $request->post('password_actual');
        $password_nueva = $request->post('password_nueva');

        $personal = Personal::getPersonalById($id);
        $passwordDBEncriptada = $personal->password;
    
        if ($password_nueva) {
            if (session('userInfo')['id'] == $id) {
                if (Hash::check($password_actual, $passwordDBEncriptada)) {
                    // La contraseña ingresada coincide con la contraseña almacenada en la base de datos

                    $password_nueva_encriptada =  Hash::make($password_nueva);
                    $personal = Personal::updatePersonal($id, $nombre, $email, $password_nueva_encriptada);

                    // Cerrar sesión
                    if ($personal) {
                        Auth::guard('usuarios')->logout();
                        $request->session()->forget(['userInfo', 'userType', 'isAdmin', 'isClases', 'isServicios']);
                        $request->session()->invalidate();
                        $request->session()->regenerateToken();
                        return redirect('/login');
                    } else {
                        $error = 'No se ha podido actualizar la contraseña.';
                        return redirect()->route('miPerfilPersonal')->with(['id' => $id, 'error' => $error]);
                    }
                } else {
                    // La contraseña ingresada no coincide con la contraseña almacenada en la base de datos
                    $error = 'La contraseña actual es incorrecta.';
                    return redirect()->route('miPerfilPersonal')->with(['id' => $id, 'error' => $error]);
                }
            } else {
                $error = 'No tienes permisos para editar la contraseña de este perfil.';
                return redirect()->route('miPerfilPersonal')->with(['id' => $id, 'error' => $error]);
            }
        } else {
            $personal = Personal::updatePersonal($id, $nombre, $email, null);
            if ($page == 'perfil') {
                if($personal) {
                    session('userInfo')['nombre'] = $nombre;
                    session('userInfo')['email'] = $email;
                    $success='Tu perfil se ha actualizado con éxito.';
                    return redirect()->route('miPerfilPersonal')->with(['id' => $id, 'success' => $success]);
                } else {
                    $error='No se ha podido actualizar tu perfil.';
                    return redirect('/miPerfilPersonal')->with(['id' => $id, 'error', $error]);
                }
            } elseif ($page == 'personal') {
                if (session('userInfo')['id'] == $id) {
                    if($personal) {
                        session('userInfo')['nombre'] = $nombre;
                        session('userInfo')['email'] = $email;

                        $success='Tu perfil se ha actualizado con éxito.';
                        return redirect('/mostrarPersonal')->with('success', $success);
                    } else {
                        $error='No se ha podido actualizar tu perfil.';
                        return redirect('/mostrarPersonal')->with('success', $success);
                    }
                    
                } else {
                    if($personal) {
                        $success='El trabajador se ha actualizado con éxito.';
                        return redirect('/mostrarPersonal')->with('success', $success);
                    } else {
                        $error='No se ha podido actualizar el trabajador.';
                        return redirect('/mostrarPersonal')->with('success', $success);
                    }
                }
            }
        }
    }

    public function restablecerContraseña(Request $request) {
        $id = $request->post('personal_id');
        $personal = Personal::getPersonalById($id);
        $personal_dni = $personal->dni;

        $password_nueva_encriptada =  Hash::make($personal_dni);
        $personal = Personal::updatePersonal($id, $personal->nombre, $personal->email, $password_nueva_encriptada);

        if($personal) {
            $success='La contraseña se ha restablecido con éxito.';
            return redirect('/mostrarPersonal')->with(compact('success'));
        } else {
            $error='No se ha podido restablecer la contraseña.';
            return redirect('/mostrarPersonal')->with(compact('error'));
        }
    }

    public function eliminarPersonalForm(Request $request) {
        $personal_id = $request->post('id');
        $usuario = Personal::getPersonalById($personal_id);
        $userType = 'personal';

        return View::make('modals.modalEliminarUsuario', compact('usuario', 'userType'));
        die();
    }

    public function eliminarPersonal(Request $request) {
        $personal_id = $request->post('usuario_id');

        $personal = Personal::getPersonalById($personal_id);
        $personal_role= $personal->role_id;

        if ($personal_role == 3 || $personal_role == 4) {
            $horarioServicios = HorarioServicios::getServiciosByPersonalId($personal_id);

            foreach ($horarioServicios as $servicio) {
                $reserva = ReservaServicio::existeReservaServicio($servicio->id);

                if ($reserva) {
                    $deleteReserva = ReservaServicio::deleteReservaByServicioId($servicio->id);
                }

                if (!$deleteReserva) {
                    $error='No se ha podido eliminar el trabajador.';
                    return direct('/mostrarPersonal')->with(compact('error'));
                } 

                $deleteServicio = HorarioServicios::eliminarServicio($servicio->id);

                if (!$deleteServicio) {
                    $error='No se ha podido eliminar el usuario.';
                    return redirect('/mostrarUsuarios')->with(compact('error'));
                }
            }

            $personal = Personal::deletepersonal($personal_id);

            if($personal) {
                $success='El trabajador se ha eliminado con éxito.';
                return redirect('/mostrarPersonal')->with(compact('success'));
            } else {
                $error='No se ha podido eliminar el trabajador.';
                return redirect('/mostrarPersonal')->with(compact('error'));
            }
        } elseif ($personal_role == 2) {
            $horarios = Horario::getHorarios();

            foreach($horarios as $horario) {

                $periodo_validez = HorariosController::periodosValidezHorarios($horario->id);

                if (count($periodo_validez) > 0) {
                    $clasesHorario = HorarioClases::getClasesHorario($horario->id, $personal_id);

                    if (count($clasesHorario) > 0) {
                        $error='No se ha podido eliminar el trabajador ya que tiene clases en horarios activos. Actualice los horarios antes de eliminar al trabajador.';
                        return redirect('/mostrarPersonal')->with(compact('error'));
                    }
                        
                }
            }

            $personal = Personal::deletepersonal($personal_id);

            if($personal) {
                $success='El trabajador se ha eliminado con éxito.';
                return redirect('/mostrarPersonal')->with(compact('success'));
            } else {
                $error='No se ha podido eliminar el trabajador.';
                return redirect('/mostrarPersonal')->with(compact('error'));
            }

        } else {
            $personal = Personal::deletepersonal($personal_id);

            if($personal) {
                $success='El trabajador se ha eliminado con éxito.';
                return redirect('/mostrarPersonal')->with(compact('success'));
            } else {
                $error='No se ha podido eliminar el trabajador.';
                return redirect('/mostrarPersonal')->with(compact('error'));
            }
        }


        $personal = Personal::deletepersonal($personal_id);

        if($personal) {
            $success='El trabajador se ha eliminado con éxito.';
            return redirect('/mostrarPersonal')->with(compact('success'));
        } else {
            $error='No se ha podido eliminar el trabajador.';
            return redirect('/mostrarPersonal')->with(compact('error'));
        }
    }
}
