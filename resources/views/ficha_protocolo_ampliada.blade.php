@extends('adminlte::layouts.app')

@section('htmlheader_title')
    Protocolo
@endsection

@section('contentheader_title')
    <strong>{{ $protocolo_ap->nombreCortoProt }}</strong>
@endsection
@section('contentheader_description')
    F1 v1.0
@endsection

@section('main-content')
                        <div class="container-fluid spark-screen">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title"><i class="fa fa-bell-o"></i> Alertas de acción en protocolo:</h3>
                                        </div>
                                        @if($protocolo->estadoProt == 0)
                                            <div class="alert alert-warning alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <h4><i class="icon fa fa-bell-o"></i> ¡NOTIFICACIÓN!</h4>
                                                <strong>PROTOCOLO EN FASE PRELIMINAR, ESTADO ACTUAL: NO ACTIVADO.</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title"><i class="fa fa-info"></i> Estado del Protocolo:</h3>
                                        </div>
                                        <div class="box-body">
                                            <div class="col-md-12">
                                                <div class="box box-widget widget-user-2">
                                                    <ul class="nav nav-stacked">
                                                        <li><b>Estado Actual del Protocolo:</b></li>
                                                        <li>

                                                            @if($protocolo->estadoProt == 0)
                                                                <button class="btn btn-block bg-black"><i class="fa fa-spinner"></i>
                                                                    INICIADO, NO
                                                                    ACTIVADO
                                                                </button>
                                                            @elseif($protocolo->estadoProt == 1)
                                                                <button class="btn btn-block bg-black"><i class="fa fa-check-circle"></i>
                                                                    ACTIVADO
                                                                </button>
                                                            @elseif($protocolo->estadoProt == 4)
                                                                <button class="btn btn-block bg-black"><i class="fa fa-archive"></i>
                                                                    ARCHIVADO
                                                                </button>
                                                            @elseif($protocolo->estadoProt == 8)
                                                                <button class="btn btn-block bg-black"><i class="fa fa-close"></i>
                                                                    CANCELADO
                                                                </button>
                                                            @endif
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>


                                            <div class="col-md-12">
                                                <div class="box box-widget widget-user-2">
                                                    <ul class="nav nav-stacked">
                                                        <li><b>Checksum Acceso Público:</b></li>
                                                        <li>{{ $protocolo->checksum }}</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="box box-widget widget-user-2">
                                                    <ul class="nav nav-stacked">
                                                        <li><b>Código Acceso Público:</b></li>
                                                        <li>{{ $protocolo->codExped }}</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="box box-widget widget-user-2">
                                                    <ul class="nav nav-stacked">
                                                        <li><b>Exportación de Información (PDF):</b></li>
                                                        <li>
                                                            <center>
                                                                @if($involucrados->count() > 0)
                                                                    <form action="/Protocolo/GenerarPDF" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="idProt"
                                                                               value="{{ $protocolo->idPProt }}">
                                                                        <button class="btn btn-block bg-red" type="submit"><b><i
                                                                                        class="fa fa-file-pdf-o"></i> Generar Documento
                                                                                eBook</b>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <button class="btn btn-block bg-red" type="submit" disabled><b><i
                                                                                    class="fa fa-file-pdf-o"></i> Generar
                                                                            Documento
                                                                            eBook</b>
                                                                    </button>
                                                                @endif
                                                            </center>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box box-widget widget-user-2">
                                                    <ul class="nav nav-stacked">
                                                        <li><b>Cancelar Protocolo</b></li>
                                                        <li>
                                                            <center>
                                                                @if($protocolo->estadoProt <> 4 && $protocolo->estadoProt <> 8)
                                                                    <form action="/Protocolo/CancelarProtocolo" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="idProt"
                                                                               value="{{ $protocolo->idPProt }}">
                                                                        <button class="btn btn-block bg-red" type="submit"><b><i
                                                                                        class="fa fa-close"></i> Cancelar Protocolo</b>
                                                                        </button>
                                                                    </form>
                                                                @else
                                                                    <button class="btn btn-block bg-red" type="submit" disabled><b><i
                                                                                    class="fa fa-close"></i> Cancelar Protocolo</b>
                                                                    </button>
                                                                @endif
                                                            </center>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="box">
                                        <div class="box-header">
                                            <h3 class="box-title"><i class="fa fa-file-pdf-o"></i> Carátula del Protocolo:</h3>
                                        </div>

                                        <div class="box-footer no-padding">
                                            <div class="box box-widget widget-user-2">
                                                <div class="widget-user-header bg-black">
                                                    <h3 class="widget-user-username">{{ $abogado->nombreAbog }}</h3>
                                                    <h5 class="widget-user-desc">Asesor Educacional</h5>
                                                    <h5 class="widget-user-desc">FC Abogados</h5>
                                                </div>
                                                <div class="box-footer no-padding">
                                                    <ul class="nav nav-stacked">
                                                        <li><a href="#">WhatsApp <span
                                                                        class="pull-right badge bg-primary">+56 {{ $abogado->fonoAbog }}</span></a>
                                                        </li>
                                                        <li><a href="#">E-Mail <span
                                                                        class="pull-right badge bg-primary">{{ $abogado->correo1Abog }}</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="box box-widget widget-user-2">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="#"><b>Contacto Establecimiento:</b></a></li>
                                                    <li><a href="#">ID Único Procedimiento <span
                                                                    class="pull-right badge bg-primary">{{ $protocolo->idPProt }}</span></a>
                                                    </li>
                                                    <li><a href="#">Establecimiento <span
                                                                    class="pull-right badge bg-primary">{{ $protocolo->nombreEst }}</span></a>
                                                    <li><a href="#">Folio Procedimiento <span
                                                                    class="pull-right badge bg-primary">{{ $protocolo->idPProt }}</span></a>
                                                    </li>
                                                    <li><a href="#">Encargado E.C.E. <span
                                                                    class="pull-right badge bg-primary">{{ $protocolo->nombreEceEst }}</span></a>
                                                    </li>
                                                    <li><a href="#">Teléfono <span
                                                                    class="pull-right badge bg-primary">+56 {{ $protocolo->fonoEst }}</span></a>
                                                    </li>
                                                    <li><a href="#">E-Mail <span
                                                                    class="pull-right badge bg-primary">{{ $protocolo->mailEst }}</span></a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="box box-widget widget-user-2">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="#"><b>CheckList Avance:</b></a></li>
                                                    <li><a href="#">Fase Inicial - Intervinientes y Hechos
                                                            @if($involucrados->count() == 0)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-inicial">NO INICIADO</span>
                                                            @else
                                                                @if($hechos->count() == 0)
                                                                    <span class="pull-right badge bg-gray" data-toggle="modal"
                                                                          data-target="#modal-fase-inicial">INCOMPLETO</span>
                                                                @else
                                                                    <span class="pull-right badge bg-green" data-toggle="modal"
                                                                          data-target="#modal-fase-inicial">COMPLETO</span>
                                                                @endif
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Fase N° 1 - Notificación
                                                            @if($notif_act->count() == 0)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-uno">NO INICIADO</span>
                                                            @else
                                                                <span class="pull-right badge bg-green" data-toggle="modal"
                                                                      data-target="#modal-fase-uno">COMPLETO</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Fase N° 2 - Inicio Investigación
                                                            @if($incautaciones->count() == 0)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-dos">NO INICIADO</span>
                                                            @else
                                                                <span class="pull-right badge bg-green" data-toggle="modal"
                                                                      data-target="#modal-fase-dos">COMPLETO</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Fase N° 3 - Cierre Investigación
                                                            @if($incautaciones->where('esCierre', 1)->count() == 0)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-tres">NO INICIADO</span>
                                                            @else
                                                                <span class="pull-right badge bg-green" data-toggle="modal"
                                                                      data-target="#modal-fase-tres">COMPLETO</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Fase N° 4 - Investigación
                                                            @if($protocolo->fecInfFinal == 0)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-cuatro">NO INICIADO</span>
                                                            @else
                                                                <span class="pull-right badge bg-green" data-toggle="modal"
                                                                      data-target="#modal-fase-cuatro">COMPLETO</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Fase N° 5 - Informe Final Investigación
                                                            @if($protocolo->fecInfFinal == 0)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-cinco">NO INICIADO</span>
                                                            @else
                                                                <span class="pull-right badge bg-green" data-toggle="modal"
                                                                      data-target="#modal-fase-cinco">COMPLETO</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Fase N° 6 - Acciones de Seguimiento
                                                            @if($seguimientos->count() == 0)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-seis">NO INICIADO</span>
                                                            @else
                                                                <span class="pull-right badge bg-green" data-toggle="modal"
                                                                      data-target="#modal-fase-seis">COMPLETO</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Fase N° 7 - Cierre del Protocolo
                                                            @if($protocolo->fecCierreProt == null)
                                                                <span class="pull-right badge bg-yellow" data-toggle="modal"
                                                                      data-target="#modal-fase-siete">NO INICIADO</span>
                                                            @else
                                                                <span class="pull-right badge bg-green" data-toggle="modal"
                                                                      data-target="#modal-fase-siete">COMPLETO</span>
                                                            @endif
                                                        </a>
                                                    </li>


                                                </ul>
                                            </div>

                                            <div class="box box-widget widget-user-2">
                                                <ul class="nav nav-stacked">
                                                    <li><a href="#"><b>Fechas Importantes:</b></a></li>
                                                    <li><a href="#">Creación Procedimiento <span
                                                                    class="pull-right badge bg-primary">{{ date("d/m/Y H:i:s", strtotime($protocolo->fecCreaProt))  }}</span></a>
                                                    </li>
                                                    <li><a href="#">Activación Procedimiento @if($protocolo->fecActProt == null)
                                                                <span class="pull-right badge bg-red">NO NOTIFICADO</span>
                                                            @else
                                                                <span
                                                                        class="pull-right badge bg-primary">{{ date("d/m/Y H:i:s", strtotime($protocolo->fecActProt)) }}</span>
                                                            @endif
                                                        </a></li>
                                                    <li><a href="#">Notificación Apoderados
                                                            @if($protocolo->fecActProt == null)
                                                                <span class="pull-right badge bg-red">NO NOTIFICADO</span>
                                                            @else
                                                                <span
                                                                        class="pull-right badge bg-primary">{{ date("d/m/Y H:i:s", strtotime($protocolo->fecActProt)) }}</span>
                                                            @endif
                                                        </a></li>
                                                    <li><a href="#">Notificación Inf. Final
                                                            @if($protocolo->fecInfFinal == null)
                                                                <span class="pull-right badge bg-red">N/A</span>
                                                            @else
                                                                <span
                                                                        class="pull-right badge bg-primary">{{ date("d/m/Y H:i:s", strtotime($protocolo->fecInfFinal)) }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                    <li><a href="#">Cierre Procedimiento
                                                            @if($protocolo->fecCierreProt == null)
                                                                <span class="pull-right badge bg-red">N/A</span>
                                                            @else
                                                                <span
                                                                        class="pull-right badge bg-primary">{{ date("d/m/Y H:i:s", strtotime($protocolo->fecCierreProt)) }}</span>
                                                            @endif
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Información del Portal Alumno / Apoderado -->
                                <div class="col-md-9">
                                    <div class="box box-danger box-solid">
                                        <div class="box-header">
                                            <h3 class="box-title"><i class="fa fa-edit"></i> .:: Información Portal Alumno /
                                                Apoderado ::.
                                            </h3>
                                            <div class="box-tools pull-right">
                                                <span data-toggle="tooltip" title="" class="badge bg-red"
                                                      data-original-title="3 New Messages">{{ $solicitudes->count() }}</span>
                                            </div>
                                        </div>

                                        <div class="box-body no-padding">
                                            <table class="table table-condensed">
                                                <tbody>
                                                <tr>
                                                    <th>Fecha / Hora Solicitud</th>
                                                    <th>Folio del Portal</th>
                                                    <th>Tipo de Requerimiento</th>
                                                    <th>Requiriente / Observaciones</th>
                                                    <th>Sesión</th>
                                                    <th>IP de Requerimiento</th>
                                                    <th>Documento(s)</th>
                                                </tr>

                                                @foreach($solicitudes as $listado)
                                                    <tr>
                                                        <td>{{ date("d/m/Y H:i:s", strtotime($listado->fecHorSol)) }}</td>
                                                        <td><b>SOL</b> - {{ $listado->idSolPub }}</td>
                                                        <td>SOLICITUD DE REUNIÓN</td>
                                                        <td>{{ $listado->solicitante }}</td>
                                                        <td>{{ mb_strtoupper($listado->solicitante_sesion) }}</td>
                                                        <td>{{ $listado->ipSol }}</td>
                                                        <td>-</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <!-- Individualización del Involucrado REV OK -->
                                <div class="col-md-9">
                                    <div class="box box-default box-solid">
                                        <div class="box-header">
                                            <h3 class="box-title"><i class="fa fa-users"></i> Individualización de los Intervinientes:
                                            </h3>
                                            <div class="box-tools pull-right">
                                                @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                    <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                            data-target="#modal-involucrados"><i class="fa fa-plus-circle"></i>
                                                        INTERVINIENTE
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                class="fa fa-plus-circle"></i>
                                                        INTERVINIENTE
                                                    </button>
                                                @endif

                                            </div>
                                        </div>

                                        <div class="box-body no-padding">
                                            <table class="table table-condensed">
                                                <tbody>
                                                <tr>
                                                    <th><i class="fa fa-edit"></i></th>
                                                    <th>RUN Involucrado</th>
                                                    <th>Nombre Involucrado</th>
                                                    <th>Calidad</th>
                                                    <th>Curso</th>
                                                    <th>
                                                        <center>¿Miembro E.C.E.?</center>
                                                    </th>
                                                    <th>Nombre Apoderado</th>
                                                    <th>Contacto del Apoderado</th>
                                                </tr>
                                                @foreach($involucrados as $listado)
                                                    <tr>
                                                        <td>
                                                            @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                                <button class="btn btn-xs"
                                                                        onclick="editar_inverviniente({{$listado->idInv}},'{{ $id_protocolo }}')">
                                                                  <i class="fa fa-pencil"></i>
                                                                </button>
                                                            @else
                                                                <button class="btn btn-xs"
                                                                        disabled>
                                                                    <i
                                                                            class="fa fa-pencil"></i>
                                                                </button>
                                                            @endif
                                                        </td>
                                                        <td>{{ $listado->runInv }}</td>
                                                        <td>{{ mb_strtoupper($listado->nombresInv) }} {{ mb_strtoupper($listado->paternoInv) }} {{ mb_strtoupper($listado->maternoInv) }}</td>
                                                        <td><b>{{ $listado->tipoInv }}</b></td>
                                                        <td>{{ $listado->cursoInv }} - {{ $listado->letraCurInv }}</td>
                                                        <td>
                                                            <center>@if($listado->miembroece == 0)
                                                                    NO
                                                                @else
                                                                    SI
                                                                @endif</center>
                                                        </td>
                                                        <td>{{ mb_strtoupper($listado->apoderadoInv) }}</td>
                                                        <td>{{ mb_strtoupper($listado->mailApoInv) }} -
                                                            +56 {{ $listado->fonoApoInv }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                <!-- Modal Cambio de ECE REV OK-->
                                @if($protocolo->eceComprometido == 1)
                                    @if($protocolo->nombreECESub == null)
                                        <div class="col-md-9">
                                            <div class="box">
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                                        ×
                                                    </button>
                                                    <h4><i class="icon fa fa-bell-o"></i> ¡Atención!</h4>
                                                    <strong>Uno de los Intervinientes está involucrado en este procedimiento o
                                                        protocolo, se
                                                        deberá designar un ECE en suplencia.</strong>
                                                </div>
                                                <div class="box-header">
                                                    <h3 class="box-title"><i class="fa fa-warning"></i> Designación de ECE Suplente o
                                                        Subrogrante
                                                    </h3>
                                                    <div class="box-tools pull-right">
                                                        <a class="btn btn-sm bg-black-active" href="/plantillas/01_designacion_ece.docx"
                                                           target="_blank"><i
                                                                    class="fa fa-file-word-o"></i>
                                                            FORMATO REEMPLAZO ECE</a>
                                                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                data-target="#modal-suplencia-ece"><i
                                                                    class="fa fa-upload"></i>
                                                            DESIGNAR Y CARGAR DOCUMENTO
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <table class="table table-condensed">
                                                        <tbody>
                                                        <tr>
                                                            <th>Nombre del Funcionario Subrogante o Suplente</th>
                                                            <th>Correo Electrónico del Subrogante o Suplente</th>
                                                            <th>Documento Formalizado</th>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-9">
                                            <div class="box">
                                                <div class="box-header">
                                                    <h3 class="box-title"><i class="fa fa-warning"></i> Designación de ECE Suplente o
                                                        Subrogrante
                                                    </h3>
                                                    <div class="box-tools pull-right">
                                                        <a class="btn btn-sm bg-black-active" href="/plantillas/01_designacion_ece.docx"
                                                           target="_blank"><i
                                                                    class="fa fa-file-word-o"></i>
                                                            FORMATO REEMPLAZO ECE</a>
                                                        @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                            <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                    data-target="#modal-suplencia-ece"><i
                                                                        class="fa fa-upload"></i>
                                                                DESIGNAR Y CARGAR DOCUMENTO
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                        class="fa fa-upload"></i>
                                                                DESIGNAR Y CARGAR DOCUMENTO
                                                            </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="box-body no-padding">
                                                    <table class="table table-condensed">
                                                        <tbody>
                                                        <tr>
                                                            <th>Nombre del Funcionario Subrogante o Suplente</th>
                                                            <th>Correo Electrónico del Subrogante o Suplente</th>
                                                            <th>Documento de Formalización Reemplazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td>{{ mb_strtoupper($protocolo->nombreECESub) }}</td>
                                                            <td>{{ mb_strtoupper($protocolo->mailECESub) }}</td>
                                                            <td>
                                                                <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->docECESub }}"
                                                                   target="_blank" class="btn btn-xs btn-success"><i
                                                                            class="fa fa-eye"></i> Ver Documento</a></td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                <!-- Etapa Preliminar: Detalle de los Hechos REV OK -->
                                @if($involucrados->count() <> 0)
                                    <div class="col-md-9">
                                        <div class="box box-default box-solid">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-inbox"></i><b> ETAPA PRELIMINAR</b> :: Detalle de
                                                    los
                                                    Hechos ::
                                                </h3>
                                                <div class="box-tools pull-right">
                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                data-target="#modal-hechos"><i class="fa fa-plus-circle"></i>
                                                            HECHOS
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                    class="fa fa-plus-circle"></i>
                                                            HECHOS
                                                        </button>
                                                    @endif

                                                </div>
                                            </div>

                                            <div class="box-body no-padding">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                    <tr>
                                                        <th></th>
                                                        <th>Fecha/Hora Inicio Hecho</th>
                                                        <th>Fecha/Hora Fin Hecho</th>
                                                        <th>¿Delito?</th>
                                                        <th>Documento</th>
                                                        <th>Descripción de Hechos</th>
                                                        <th>
                                                            <center>Descripción Completa Hechos</center>
                                                        </th>
                                                        <th>Comunicado por</th>
                                                    </tr>
                                                    @foreach($hechos as $listado)
                                                        <tr>
                                                            <td>
                                                                @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                                    <button class="btn btn-xs"
                                                                            onclick="editar_hechos({{$listado->idHechos}}, '{{ $id_protocolo }}')">
                                                                        <i
                                                                                class="fa fa-pencil"></i>
                                                                    </button>
                                                                @else
                                                                    <button class="btn btn-xs"
                                                                            disabled>
                                                                        <i
                                                                                class="fa fa-pencil"></i>
                                                                    </button>
                                                                @endif
                                                            </td>
                                                            <td>{{ $listado->fecHechosIni }} - {{ $listado->horaHechosIni }}</td>
                                                            <td>{{ $listado->fecHechosFin }} - {{ $listado->horaHechosFin }}</td>
                                                            <td>
                                                                @if($listado->esDelito == 1)
                                                                    <center><b>SI</b></center>
                                                                @else
                                                                    <center><b>NO</b></center>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($listado->urlDocHechos == null)
                                                                    NO CARGADO
                                                                @else
                                                                    <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->urlDocHechos }}"
                                                                       target="_blank" class="btn btn-xs btn-success"><i
                                                                                class="fa fa-download"></i> Documento</a>
                                                                @endif
                                                            </td>
                                                            <td>{{ mb_strtoupper(substr($listado->hechos, 0, 100)) }}...</td>
                                                            <td>
                                                                <center>
                                                                    <button class="btn btn-xs btn-success"
                                                                            onclick="busca_hechos({{$listado->idHechos}})"><i
                                                                                class="fa fa-search"></i></button>
                                                                </center>
                                                            </td>
                                                            <td>{{ mb_strtoupper($listado->notificaHecho) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Modal Fiscalía -> Envio de Denuncia al MP REV OK-->
                                @if($protocolo->esDelito == 1)
                                    <div class="col-md-9">
                                        <div class="box box-default box-solid">
                                            @if($notif_fiscalia->count() == 0)
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                                        ×
                                                    </button>
                                                    <h4><i class="icon fa fa-bell-o"></i> ¡Atención!</h4>
                                                    <strong>Recuerde que tiene 24 Horas para realizar la denuncia.</strong>
                                                </div>
                                            @endif
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-warning"></i> Presentación de
                                                    Denuncia a la Fiscalía
                                                </h3>
                                                <div class="box-tools pull-right">
                                                    @if($hechos->count() == 0)

                                                    @else
                                                        <a class="btn btn-sm bg-black-active"
                                                           href="/{{ $hechos[0]->urlDocHechosDelito }}"><i
                                                                    class="fa fa-file-word-o"></i>
                                                            DESCARGAR DENUNCIA EN BORRADOR</a>
                                                    @endif
                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                data-target="#modal-noti-fiscalia"><i class="fa fa-send"></i>
                                                            ENVIAR DENUNCIA A FISCALÍA
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                    class="fa fa-send"></i>
                                                            ENVIAR DENUNCIA A FISCALÍA
                                                        </button>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="box-body no-padding">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Fecha - Hora Envío</th>
                                                        <th>Tipo de Notificación</th>
                                                        <th>Fiscalía</th>
                                                        <th>Documento Adjunto</th>
                                                        <th>Notificado por</th>
                                                    </tr>
                                                    @foreach($notif_fiscalia as $listado)
                                                        <tr>
                                                            <td>{{ $listado->idNotif }}</td>
                                                            <td>{{ $listado->fecCreaNotif }}</td>
                                                            <td>{{ $listado->notif }}</td>
                                                            <td>{{ mb_strtoupper($listado->nombreFisc) }}</td>
                                                            <td>
                                                                <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->urlDocumento }}"
                                                                   target="_blank" class="btn btn-xs btn-success"><i
                                                                            class="fa fa-download"></i> Documento</a>
                                                            </td>
                                                            <td>{{ mb_strtoupper($listado->name) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Modal Activación del Protocolo REV OK-->
                                @if($hechos->count() <> 0)
                                    <div class="col-md-9">
                                        <div class="box box-default box-solid">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-flag"></i> <b>ETAPA 1 </b> :: Notificación de
                                                    Activación
                                                    del
                                                    Protocolo ::
                                                </h3>
                                                <div class="box-tools pull-right">
                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                data-target="#modal-activacion"><i class="fa fa-plus-circle"></i>
                                                            NOTIFICAR ACTIVACIÓN PROTOCOLO
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                    class="fa fa-plus-circle"></i>
                                                            NOTIFICAR ACTIVACIÓN PROTOCOLO
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="box-body no-padding">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Fecha - Hora Activación</th>
                                                        <th>¿Hay Vulneración?</th>
                                                        <th>Tipo de Notificación</th>
                                                        <th>Notificado a</th>
                                                        <th>Sistematizado por</th>
                                                    </tr>
                                                    @foreach($notif_act as $listado)
                                                        <tr>
                                                            <td>{{ $listado->idNotif }}</td>
                                                            <td>{{ $listado->fecCreaNotif }}</td>
                                                            <td>
                                                                @if($protocolo->esVulneracion == 1)
                                                                    <center><b>SI</b></center>
                                                                @else
                                                                    <center><b>NO</b></center>
                                                                @endif
                                                            </td>
                                                            <td>{{ $listado->notif }}</td>
                                                            <td>DIRECTOR, EQUIPO E.C.E., ABOGADOS</td>
                                                            <td>{{ mb_strtoupper($listado->name) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Modal Denuncia a Tribunal de Familia REV OK-->
                                @if($protocolo->esVulneracion == 1)
                                    <div class="col-md-9">
                                        <div class="box box-default box-solid">
                                            @if($notif_juzgado->count() == 0)
                                                <div class="alert alert-danger alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                                        ×
                                                    </button>
                                                    <h4><i class="icon fa fa-bell-o"></i> ¡Atención!</h4>
                                                    Le recuerdamos que es de vuestra responsabilidad comunicar al
                                                    tribunal de familia, los hechos, en virtud de lo cual se activa el presente
                                                    protocolo, (si fueran vulneratorios de derechos), dentro de los 3 días
                                                    hábiles siguientes a la activación del presente protocolo.
                                                    Para lo anterior, usted, deberá descargar, desde la presente
                                                    plataforma, el formulario denuncia, completarlo e ingresarlo a través del
                                                    sitio web, <a href="https://oficinajudicialvirtual.pjud.cl/home/index.php"><strong>https://oficinajudicialvirtual.pjud.cl/home/index.php</strong></a>.
                                                </div>
                                            @endif
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-warning"></i> Presentación de Denuncia al Tribunal
                                                    de Familia
                                                </h3>
                                                <div class="box-tools pull-right">
                                                    <a class="btn btn-sm bg-black-active"
                                                       href="https://www.youtube.com/watch?v=gIEMtfXIurM" target="_blank"><i
                                                                class="fa fa-youtube"></i>
                                                        ¿CÓMO SUBIR DENUNCIA?</a>
                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                data-target="#modal-noti-tribunal"><i class="fa fa-plus-circle"></i>
                                                            CERTIFICADO TRIBUNAL DE FAMILIA
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                    class="fa fa-plus-circle"></i>
                                                            CERTIFICADO TRIBUNAL DE FAMILIA
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="box-body no-padding">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Fecha - Hora Envío</th>
                                                        <th>Tipo de Notificación</th>
                                                        <th>Juzgado</th>
                                                        <th>Documento</th>
                                                        <th>Notificado por</th>
                                                    </tr>
                                                    @foreach($notif_juzgado as $listado)
                                                        <tr>
                                                            <td>{{ $listado->idNotif }}</td>
                                                            <td>{{ $listado->fecCreaNotif }}</td>
                                                            <td>{{ $listado->notif }}</td>
                                                            <td>{{ mb_strtoupper($listado->nombreJuz)}}</td>
                                                            <td>
                                                                <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->urlDocumento }}"
                                                                   target="_blank" class="btn btn-xs btn-success"><i
                                                                            class="fa fa-download"></i> Documento</a>
                                                            </td>
                                                            <td>{{ mb_strtoupper($listado->name) }}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Modal Etapa 2 -> Inicio Investigación REV OK-->
                                @if($notif_act->count() <> 0)
                                    <div class="col-md-9">
                                        <div class="box box-default box-solid">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-shield"></i> <b>ETAPA 2</b> :: Inicio de la
                                                    Investigación ::
                                                </h3>
                                                <div class="box-tools pull-right">
                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                data-target="#modal-multimedia"><i class="fa fa-plus-circle"></i>
                                                            ANTECEDENTES
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                    class="fa fa-plus-circle"></i>
                                                            ANTECEDENTES
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="box-body no-padding">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Fecha - Hora Carga</th>
                                                        <th>Tipo</th>
                                                        <th>Diligencia</th>
                                                        <th>Documento</th>
                                                    </tr>
                                                    @foreach($incautaciones as $listado)
                                                        @if($listado->esCierre <> 1)
                                                            <tr>
                                                                <td>
                                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                                        <button class="btn btn-xs"
                                                                                onclick="elimina_etapa_dos({{ $listado->idInc }})">
                                                                            <i
                                                                                    class="fa fa-eraser"></i>
                                                                        </button>
                                                                    @else
                                                                        <button class="btn btn-xs"
                                                                                disabled>
                                                                            <i
                                                                                    class="fa fa-eraser"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $listado->fecCreaInc }}</td>
                                                                <td>@if($listado->tipoMulti == '')
                                                                        INCAUTACIÓN
                                                                    @else
                                                                        {{ mb_strtoupper($listado->tipoMulti) }}
                                                                    @endif
                                                                </td>
                                                                <td>{{ mb_strtoupper($listado->descInc) }}</td>
                                                                <td>
                                                                    @if($listado->urlMulti <> null)
                                                                        <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->urlMulti }}"
                                                                           target="_blank" class="btn btn-xs btn-success"><i
                                                                                    class="fa fa-download"></i> Documento</a>
                                                                    @else
                                                                        SIN DOCUMENTO
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    @foreach($antecedentes as $listado)
                                                        <tr>
                                                            <td>-</td>
                                                            <td>{{ date("d/m/Y H:i:s", strtotime($listado->fecHoraAnt)) }}
                                                                <button class="btn btn-xs bg-red"><i class="fa fa-info-circle"></i>
                                                                </button>
                                                            </td>
                                                            <td>{{ mb_strtoupper($listado->solicitante_sesion) }} APORTA ANTECEDENTE
                                                            </td>
                                                            <td>{{ mb_strtoupper($listado->obsAnt) }}</td>
                                                            <td>
                                                                <a class="btn btn-xs btn-success" target="_blank"
                                                                   href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->urlDocAnt }}"><i
                                                                            class="fa fa-download"></i> Documento</a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    @foreach($descargos as $listado)
                                                        <tr>
                                                            <td>-</td>
                                                            <td>{{ date("d/m/Y H:i:s", strtotime($listado->fecHoraDescargo)) }}
                                                                <button class="btn btn-xs bg-red"><i class="fa fa-info-circle"></i>
                                                                </button>
                                                            </td>
                                                            <td>@if($listado->descargoDe == 1)
                                                                    {{ mb_strtoupper($listado->solicitante_sesion) }} DESCARGOSAPODERADO
                                                                @else
                                                                    {{ mb_strtoupper($listado->solicitante_sesion) }} DESCARGOS ALUMNO
                                                                @endif</td>
                                                            <td>{{ $listado->formaDescargo }}</td>
                                                            <td>
                                                                <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->docDescargo }}"
                                                                   target="_blank" class="btn btn-xs btn-success"><i
                                                                            class="fa fa-download"></i> Documento</a></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                    <div class="callout callout-info" style="margin: 15px 15px 0 15px;">
                                                        <h4><i class="fa fa-info-circle"></i> Registrar Antecedentes</h4>
                                                        <p>Utiliza el botón “ANTECEDENTES” para documentar las gestiones realizadas y adjuntar los archivos correspondientes a la investigación.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                <!-- Modal Etapa 3 -> Informe Cierre de la Investigación REV OK-->
                                @if($incautaciones->count() <> 0)
                                    <div class="col-md-9">
                                        <div class="box box-default box-solid">
                                            <div class="box-header">
                                                <h3 class="box-title"><i class="fa fa-shield"></i> <b>ETAPA 3</b> :: Informe de Cierre
                                                    de la
                                                    Investigación ::
                                                </h3>
                                                <div class="box-tools pull-right">
                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                                                data-target="#modal-cierre"><i class="fa fa-plus-circle"></i>
                                                            INFORME DE CIERRE
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                                                    class="fa fa-plus-circle"></i>
                                                            INFORME DE CIERRE
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="box-body no-padding">
                                                <table class="table table-condensed">
                                                    <tbody>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Fecha - Hora Carga</th>
                                                        <th>Observaciones de Cierre</th>
                                                        <th>Documento</th>
                                                    </tr>
                                                    @foreach($incautaciones as $listado)
                                                        @if($listado->esCierre == 1)
                                                            <tr>
                                                                <td>
                                                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                                                        <button class="btn btn-xs"
                                                                                onclick="elimina_etapa_tres({{ $listado->idInc }})">
                                                                            <i
                                                                                    class="fa fa-eraser"></i>
                                                                        </button>
                                                                    @else
                                                                        <button class="btn btn-xs"
                                                                                disabled>
                                                                            <i
                                                                                    class="fa fa-eraser"></i>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $listado->fecCreaInc }}</td>
                                                                <td>{{ mb_strtoupper($listado->descInc) }}</td>
                                                                <td>
                                                                    @if($listado->urlMulti <> '')
                                                                        <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->urlMulti }}"
                                                                           target="_blank" class="btn btn-xs btn-success"><i
                                                                                    class="fa fa-download"></i> Documento</a>
                                                                    @else
                                                                        SIN DOCUMENTO
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Modal Etapa 4 y 5 -> Informe Final de la Investigación REV OK-->
                               @if($protocolo->informeCierre == 1)
    <div class="col-md-9">
        
        <div class="box box-default box-solid">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-shield"></i> <b>ETAPA 4 y 5</b> :: Informe Final
                    de la
                    Investigación ::
                </h3>
                <div class="box-tools pull-right">
                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                data-target="#modal-informe-final"><i class="fa fa-plus-circle"></i>
                            CARGAR INFORME
                        </button>
                    @else
                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                class="fa fa-plus-circle"></i>
                            CARGAR INFORME
                        </button>
                    @endif
                </div>
            </div>

            
            <div class="box-body no-padding">

    @if($protocolo->informeFinal <> '')

       
        <div class="callout callout-success" style="margin: 15px;">
            <h4><i class="fa fa-check-circle"></i> Informe Final cargado</h4>
            <p style="margin-bottom: 0px;"> 
                Fecha: {{ $protocolo->fecInfFinal ?? 'Sin registro' }}
                <br>
                <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $protocolo->informeFinal }}"
                    target="_blank"
                    class="btn btn-xs btn-success"                    style="margin-top: 5px;">
                    <i class="fa fa-download"></i> Descargar Informe Final
                </a>
            </p>
        </div>

       
        @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
        <div style="padding: 0 15px 15px 15px;"> 
            <button class="btn btn-xs btn-danger"
                    onclick="elimina_etapa_cuatro({{ $protocolo->idPProt }})">
                <i class="fa fa-eraser"></i> Eliminar Informe
            </button>
        </div>
        @endif

    @else

        <div class="callout callout-warning" style="margin: 15px;">
            <h4><i class="fa fa-exclamation-triangle"></i> Informe Final pendiente</h4>
            <p>Aún no se ha cargado el informe final para esta etapa. Utilice el botón "CARGAR INFORME".</p>
        </div>

    @endif

</div>
            

        </div>
    </div>
@endif

                                <!-- Etapa 6-> Aviso de Seguimiento REV OK-->
                                @if($protocolo->informeFinal <> '')
                                    @if($seguimientos->count() < 1)
                                        <div class="col-lg-9">
                                            <div class="box">
                                                <div class="alert alert-warning alert-dismissible">
                                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">
                                                        ×
                                                    </button>
                                                    <h4><i class="icon fa fa-info-circle"></i> ¡Atención!</h4>
                                                    <strong>Como el plazo de intervención, señalada en su Plan, ha concluido,
                                                        le informo que se dará inicio a la etapa de SEGUIMIENTO, la que se
                                                        extenderá por los 03 meses siguientes.
                                                        En dicha etapa, usted podrá realizar todas las entrevistas que
                                                        estime necesarias para prevenir que nuevos hechos, similares a los
                                                        acaecidos se reiteren, y registrar su contenido en la presente
                                                        plataforma.</strong>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if($protocolo->informeFinal <> '')
    <div class="col-md-9">
        <div class="box box-default box-solid">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-shield"></i> <b>ETAPA 6</b> :: Acciones de
                    Seguimiento
                    ::
                </h3>
                <div class="box-tools pull-right">
                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                data-target="#modal-acciones"><i class="fa fa-plus-circle"></i>
                            REPORTAR ACCIONES
                        </button>
                    @else
                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                class="fa fa-plus-circle"></i>
                            REPORTAR ACCIONES
                        </button>
                    @endif
                </div>
            </div>

            <div class="box-body no-padding">
                <table class="table table-condensed">
                   
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de la(s) Acción(es)</th>
                            <th>Documento</th>
                            <th>Detalle de las Acciones de Seguimiento</th>
                        </tr>

                       
                        @forelse($seguimientos as $listado)
                            <tr>
                                <td>
                                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                                        <button class="btn btn-xs"
                                                onclick="elimina_etapa_seis({{ $listado->idSeg }})">
                                            <i
                                                class="fa fa-eraser"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-xs"
                                                disabled>
                                            <i
                                                class="fa fa-eraser"></i>
                                        </button>
                                    @endif
                                </td>
                                <td>{{ $listado->fecSeg }}</td>
                                <td>
                                    @if($listado->docSeg <> null)
                                        <a href="https://{{ $config->urlBaseS3 }}.s3.us-east-2.amazonaws.com/{{ $listado->docSeg }}"
                                           target="_blank" class="btn btn-xs btn-success"><i
                                                class="fa fa-download"></i> Documento</a>
                                    @else
                                      
                                        SIN DOCUMENTO
                                    @endif
                                </td>
                                <td>{{ mb_strtoupper($listado->obsSeg) }}</td>
                            </tr>
                        @empty
                           
                            <tr>
                                <td colspan="4" class="text-center text-muted" style="padding: 10px;">
                                    No hay acciones de seguimiento registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

                                <!-- Modal Etapa 7-> Cierre del Protocolo y Archivo REV OK-->
                                @if(($seguimientos->count() >= 1))
    <div class="col-md-9">
        <div class="box box-default box-solid">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-shield"></i> <b>ETAPA 7</b> :: Cierre del
                    Protocolo ::
                </h3>
                <div class="box-tools pull-right">
                    @if($protocolo->fecCierreProt == null && $protocolo->estadoProt != 8)
                        <button type="button" class="btn btn-sm bg-black-active" data-toggle="modal"
                                data-target="#modal-medidas-resguardo"><i class="fa fa-plus-circle"></i>
                            CIERRE DEL PROTOCOLO
                        </button>
                    @else
                        <button type="button" class="btn btn-sm bg-black-active" disabled><i
                                class="fa fa-plus-circle"></i>
                            CIERRE DEL PROTOCOLO
                        </button>
                    @endif
                </div>
            </div>
            <div class="box-body no-padding">

               
                @if(empty($protocolo->fecCierreProt))

                    
                    <div class="callout callout-warning" style="margin: 15px;">
                        <h4><i class="fa fa-exclamation-triangle"></i> Cierre del Protocolo Pendiente</h4>
                        <p>El protocolo está listo para ser cerrado. Utilice el botón "CIERRE DEL PROTOCOLO" en la esquina superior para finalizar.</p>
                    </div>

                @else

                  
                    <div class="callout callout-success" style="margin: 15px;">
                        <h4><i class="fa fa-flag-checkered"></i> Protocolo Cerrado y Archivado</h4>
                        <p style="margin-bottom: 0px;">
                           
                            <strong>Fecha de Cierre:</strong> {{ $protocolo->fecCierreProt }}
                            <br>
                            <strong>Medida/Observación:</strong> {{ strtoupper($protocolo->obsCierre) }}
                        </p>
                    </div>

                @endif

            </div>     
        </div>
    </div>
@endif

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="box box-default box-solid">
                                        <div class="box-header">
                                            <h3 class="box-title"><i class="fa fa-edit"></i> Bitácora de acciones en Protocolo
                                            </h3>
                                            <div class="box-tools pull-right">
                                                <span data-toggle="tooltip" title="" class="badge bg-gray-active"
                                                      data-original-title="3 New Messages">Movimientos de Bitácora: {{ $bitacoras->count() }}</span>
                                            </div>
                                        </div>

                                        <div class="box-body no-padding">
                                            <table class="table table-condensed">
                                                <tbody>
                                                <tr>
                                                    <th>Fecha - Hora</th>
                                                    <th>Acción</th>
                                                    <th>Módulo</th>
                                                    <th>Ejecutada por</th>
                                                </tr>
                                                @foreach($bitacoras as $listado)
                                                    <tr>
                                                        <td>{{ date("d/m/Y H:i:s", strtotime($listado->fecHorBitacora)) }}</td>
                                                        <td>{{ $listado->accionBitacora }}</td>
                                                        <td>{{ $listado->moduloBitacora }}</td>
                                                        <td>{{ $listado->name }}</td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- MODAL CHECKLIST AVANCE -->
                        <div class="modal fade" id="modal-fase-inicial">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase Inicial</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: No Aplica.</p>
                                                    <br>
                                                    <p><b>Etapa Preliminar:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2">Preliminar</td>
                                                            <td>COMUNICAR
                                                                HECHOS
                                                                CONSTITUTIVOS
                                                                DE MALTRATO,
                                                                ACOSO ESCOLAR
                                                                Y/O VIOLENCIA
                                                            </td>
                                                            <td><b>CUALQUIER MIEMBRO DE LA
                                                                    COMUNIDAD EDUCATIVA</b> que tome
                                                                conocimiento de hechos,
                                                                constitutivos de maltrato, violencia
                                                                y/o acoso escolar, deberá
                                                                comunicarlo, por cuaquier medio y a
                                                                la brevedad posible al Encargado de
                                                                Convivencia Escolar y/o en subsidio
                                                                al director del Establecimiento.
                                                            </td>
                                                            <td>Tan pronto
                                                                como tome
                                                                conocimiento
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>DENUNCIA DE
                                                                HECHOS
                                                                CONSTITUTIVOS
                                                                DE DELITO
                                                            </td>
                                                            <td><b>TODOS LOS FUNCIONARIOS DEL
                                                                    ESTABLECIMIENTO</b> podrán
                                                                denunciar los hechos, si fuesen
                                                                constitutivos de delito, ante el
                                                                Ministerio Público, Carabineros de
                                                                Chile, o Policia de Investigaciones,
                                                                pero será obligatoria la denuncia del
                                                                Encargado de Convivencia Escolar
                                                                y/o el director del Establecimiento, la que se realizará a través del
                                                                envio
                                                                de los antecedentes via correo
                                                                electrónico, a la fiscalia que
                                                                corresponda.
                                                            </td>
                                                            <td>Dentro de las
                                                                24 hrs
                                                                siguientes a la
                                                                toma de
                                                                conocimiento
                                                                de los hechos,
                                                                conforme lo
                                                                establecido en

                                                                la que se realizará a través del envio
                                                                de los antecedentes via correo
                                                                electrónico, a la fiscalia que
                                                                corresponda.

                                                                el articulo 175
                                                                CPP.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Etapa 1</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-fase-uno">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase N° 1</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: Etapa Preliminar.</p>
                                                    <br>
                                                    <p><b>Etapa N° 1:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td rowspan="2">Etapa 1</td>
                                                            <td>ACTIVACIÓN DEL
                                                                PROTOCOLO
                                                            </td>
                                                            <td>Corresponderá al <b>ENCARGADO DE
                                                                    CONVIVENCIA ESCOLAR</b> la
                                                                activación del protocolo respectivo,
                                                                y la adopción de medidas de
                                                                resguardo urgentes para el
                                                                resguardo de la integridad fisica y
                                                                síquica de los involucrados, si así se
                                                                requiriéran.
                                                            </td>
                                                            <td>Dentro de los
                                                                02 días hábiles
                                                                siguientes a
                                                                que se le
                                                                comuniquen
                                                                los hechos de
                                                                que se trata al
                                                                Encargado de
                                                                Convivencia
                                                                Escolar y/o
                                                                director.
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>DENUNCIAR A
                                                                TRIBUNALES
                                                                COMPETENTES.
                                                            </td>
                                                            <td><b>TODOS LOS FUNCIONARIOS DEL
                                                                    ESTABLECIMIENTO</b> tendrán el deber
                                                                de poner en conocimiento o
                                                                denunciar de manera formal, ante
                                                                los tribunales competentes, (en este
                                                                caso, a través de un escrito
                                                                ingresado a la Oficina Judicial Virtual
                                                                del PJUD), cualquier hecho que
                                                                constituya vulneración de derechos
                                                                de un estudiante, tan pronto se
                                                                advierta.
                                                                En todo caso, será siempre
                                                                obligatoria la realización de la
                                                                denuncia de los hechos señalados y
                                                                en los casos señalados en el párrafo
                                                                anterior, la del Encargado de
                                                                Convivencia Escolar y/o en subsidio,
                                                                la del director del Establecimiento.
                                                            </td>
                                                            <td>Dentro de los
                                                                02 días hábiles
                                                                siguientes a
                                                                que se le
                                                                comuniquen
                                                                los hechos de
                                                                que se trata al
                                                                Encargado de
                                                                Convivencia
                                                                Escolar y/o
                                                                director.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Etapa 2</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-fase-dos">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase N° 2</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: Etapa 1.</p>
                                                    <br>
                                                    <p><b>Etapa N° 2:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Etapa 2</td>
                                                            <td>INICIO DE LA
                                                                INVESTIGACIÓN
                                                            </td>
                                                            <td>Será el <b>ENCARGADO DE
                                                                    CONVIVENCIA ESCOLAR</b>, quién
                                                                realice todas las diligencias que
                                                                estime pertinentes, (las que
                                                                involucrarán a padres, madres y/o
                                                                apoderados de los estudiantes del
                                                                Establecimiento Educacional), con la
                                                                finalidad de recopilar antecedentes
                                                                que permitan al Establecimiento,
                                                                adoptar las medidas que se estimen
                                                                pertinentes, según la gravedad de
                                                                los hechos.
                                                            </td>
                                                            <td>Una vez
                                                                activado el
                                                                Protocolo de
                                                                Convivencia
                                                                Escolar y
                                                                durante los 05
                                                                dias hábiles
                                                                siguientes.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Etapa 3</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-fase-tres">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase N° 3</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: Etapa 2.</p>
                                                    <br>
                                                    <p><b>Etapa N° 3:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Etapa 3</td>
                                                            <td>NOTIFICACION DE
                                                                INFORME DE
                                                                CIERRE
                                                            </td>
                                                            <td>Será el <b>ENCARGADO DE
                                                                    CONVIVENCIA ESCOLAR</b>, quién una
                                                                vez recopilada la información, y en
                                                                base a los antecedentes allegados
                                                                emitirá un informe de cierre,
                                                                dirigido via correo electrónico, al
                                                                director del Estabecimiento, y al
                                                                Equipo de Convivencia Escolar para
                                                                su ejecución, dónde sugerirá las
                                                                medidas que debe adoptar el
                                                                Establecimiento Educacional.
                                                            </td>
                                                            <td>Dentro de los
                                                                02 dias hábiles
                                                                siguientes,
                                                                contados desde
                                                                la conclusión
                                                                del plazo
                                                                establecido en
                                                                la etapa N°2.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Etapa 4</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-fase-cuatro">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase N° 4</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: Etapa 3.</p>
                                                    <br>
                                                    <p><b>Etapa N° 4:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Etapa 4</td>
                                                            <td>INFORME FINAL
                                                            </td>
                                                            <td>Será el <b>EQUIPO DE CONVIVENCIA
                                                                    ESCOLAR</b>, los encargados de
                                                                elaborar en extenso y redactar las
                                                                medidas sugeridas en el informe de
                                                                cierre, las que deberán contenerse
                                                                en un informe final, con el formato
                                                                que estimen.
                                                            </td>
                                                            <td>05 dias hábiles
                                                                contados desde
                                                                el vencimiento
                                                                del plazo
                                                                establecido
                                                                para la notificación del
                                                                informe de
                                                                cierre, señalado
                                                                en la etapa
                                                                N°03
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Etapa 5</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-fase-cinco">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase N° 5</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: Etapa 4.</p>
                                                    <br>
                                                    <p><b>Etapa N° 5:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Etapa 5</td>
                                                            <td>NOTIFICACIÓN A
                                                                LOS
                                                                INVOLUCRADOS
                                                                DE LAS MEDIDAS
                                                                ADOPTADAS E
                                                                INICIO DE ELLAS.
                                                            </td>
                                                            <td>Será el <b>EQUIPO DE CONVIVENCIA
                                                                    ESCOLAR</b> quien notificará por correo
                                                                electrónico a los involucrados
                                                                respecto de las acciones que, en su
                                                                favor, realizará en Establecimiento y
                                                                de la duración de éstas, que no
                                                                podrán ser superior a 60 dias
                                                                hábiles.

                                                                Inmediatamente notificados, se
                                                                dará inicio a la ejecución de éstas,
                                                                por el plazo establecido por el
                                                                Equipo de Convivencia Escolar.
                                                            </td>
                                                            <td>02 dias hábiles
                                                                desde que se
                                                                venció el plazo
                                                                señalado en la
                                                                etapa 04.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Etapa 6</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-fase-seis">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase N° 6</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: Etapa 5.</p>
                                                    <br>
                                                    <p><b>Etapa N° 6:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Etapa 6</td>
                                                            <td>SEGUIMIENTO
                                                            </td>
                                                            <td>Será el <b>EQUIPO DE CONVIVENCIA
                                                                    ESCOLAR</b>, quienes registrarán toda
                                                                la información de los involucrados
                                                                que consideren relevante mientras
                                                                se ejecutan las acciones
                                                                establecidas, por el plazo de 60 dias
                                                                hábiles.
                                                            </td>
                                                            <td>60 dias hábiles
                                                                contados desde
                                                                el inicio en la
                                                                ejecución de las
                                                                acciones
                                                                decretadas.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Etapa 7</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-fase-siete">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-cogs"></i> PlacEduc en Fase N° 7</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <p><b>Previo</b>: Etapa 6.</p>
                                                    <br>
                                                    <p><b>Etapa N° 7:</b></p>
                                                    <table class="table table-condensed">
                                                        <tr>
                                                            <th>Etapa</th>
                                                            <th>Acción</th>
                                                            <th>Responsable</th>
                                                            <th>Plazo</th>
                                                        </tr>
                                                        <tr>
                                                            <td>Etapa 7</td>
                                                            <td>CIERRE DEL
                                                                PROTOCOLO
                                                            </td>
                                                            <td>Será el <b>EQUIPO DE CONVIVENCIA
                                                                    ESCOLAR</b>, el encargado de dar cierre
                                                                al protocolo, transcurrido el plazo
                                                                señalado en la etapa N°6
                                                            </td>
                                                            <td>01 dia hábil,
                                                                transcurrido el
                                                                plazo señalado
                                                                en le etapa N°6.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                    <br>
                                                    <p><b>Próxima Fase</b>: Archivo del Protocolo</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- MODAL REVISADOS -->
                        <div class="modal fade" id="modal-involucrados">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header" style="background-color: #685e5eff; color: white;">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span> </button>
                                        <h4 class="modal-title"><b><i class="fa fa-users"></i> Individualización de los
                                                Intervinientes</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div id="mensaje">
                                                @if(session()->has('status'))
                                                    <p class="alert alert-success">{{session('status')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form id="form1" name="form1" action="/Protocolo/NuevoInvolucrado" method="POST"
                                                        class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <h3>Información del Involucrado: </h3>

                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">RUN
                                                                        Involucrado</label>
                                                                    <button class="btn btn-xs" type="button" data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title="Ingresar RUN sin puntos ni guión, en caso de no contar con RUN ingresar 19">
                                                                        <i class="fa fa-info"></i></button>
                                                                    <input type="text" class="form-control solo-rut" id="rut_val" name="rut"
                                                                        maxlength="12" pattern="^(?:\d{1,3}(?:\.\d{3})*-?[0-9Kk]|\d+[0-9Kk]?)$"
                                                                        title="Ingresa solo números y, si corresponde, la letra K. Se aceptan puntos y guion."
                                                                        onfocusout="validaRut(document.form1.rut.value)" autocomplete="off"
                                                                        required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Nombres</label>
                                                                    <input type="text" class="form-control solo-letras" id="nombres_inv"
                                                                        name="nombres_inv" pattern="^[A-Za-zÀ-ÿ\s]+$"
                                                                        title="Sólo letras y espacios" style="text-transform:uppercase;"
                                                                        autocomplete="off" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Ap.
                                                                        Paterno</label>
                                                                    <input type="text" class="form-control solo-letras" id="paterno_inv"
                                                                        name="paterno_inv" pattern="^[A-Za-zÀ-ÿ\s]+$"
                                                                        title="Sólo letras y espacios" style="text-transform:uppercase;"
                                                                        autocomplete="off" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Ap.
                                                                        Materno</label>
                                                                    <input type="text" class="form-control solo-letras" id="materno_inv"
                                                                        name="materno_inv" pattern="^[A-Za-zÀ-ÿ\s]+$"
                                                                        title="Sólo letras y espacios" style="text-transform:uppercase;"
                                                                        autocomplete="off" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Fecha
                                                                        Nacim.</label>
                                                                    <input type="date" class="form-control fecha-validable" id="fecnac_inv"
                                                                        name="fecnac_inv" max="{{ now()->format('Y-m-d') }}" min="1900-01-01"
                                                                        required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Genero</label>
                                                                    <select name="genero_inv" id="genero_inv" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        <option value="Masculino">Masculino</option>
                                                                        <option value="Femenino">Femenino</option>
                                                                        <option value="Otro">Otro</option>
                                                                        <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Nacionalidad</label>
                                                                    <select name="nacionalidad_inv" id="nacionalidad_inv" class="form-control"
                                                                        required>
                                                                        <option value="">...</option>
                                                                        <option value="CHILENO">CHILENO</option>
                                                                        <option value="EXTRANJERO">EXTRANJERO</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Curso</label>
                                                                    <select name="curso_inv" id="" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        <option value="N/A">NO APLICA</option>
                                                                        <option value="1B">1 BÁSICO</option>
                                                                        <option value="2B">2 BÁSICO</option>
                                                                        <option value="3B">3 BÁSICO</option>
                                                                        <option value="4B">4 BÁSICO</option>
                                                                        <option value="5B">5 BÁSICO</option>
                                                                        <option value="6B">6 BÁSICO</option>
                                                                        <option value="7B">7 BÁSICO</option>
                                                                        <option value="8B">8 BÁSICO</option>
                                                                        <option value="1M">1 MEDIO</option>
                                                                        <option value="2M">2 MEDIO</option>
                                                                        <option value="3M">3 MEDIO</option>
                                                                        <option value="4M">4 MEDIO</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Letra</label>
                                                                    <button class="btn btn-xs" type="button" data-toggle="tooltip"
                                                                        data-placement="top"
                                                                        title="En el caso de que el establecimiento cuente con solo un curso, deberá seleccionar A">
                                                                        <i class="fa fa-info"></i></button>
                                                                    <select name="letra_inv" id="" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        <option value="-">CURSO ÚNICO</option>
                                                                        <option value="N/A">NO APLICA</option>
                                                                        <option value="A">A</option>
                                                                        <option value="B">B</option>
                                                                        <option value="C">C</option>
                                                                        <option value="D">D</option>
                                                                        <option value="E">E</option>
                                                                        <option value="F">F</option>
                                                                        <option value="G">G</option>
                                                                        <option value="H">H</option>
                                                                        <option value="I">I</option>
                                                                        <option value="J">J</option>
                                                                        <option value="K">K</option>
                                                                        <option value="L">L</option>
                                                                        <option value="M">M</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label class="required-label">Rol de Participación</label>
                                                                    <select name="rol_participacion" class="form-control" required>
                                                                        <option value="">Seleccione.</option>
                                                                        <option value="AFECTADO">Afectado</option>
                                                                        <option value="AGRESOR">Agresor</option>
                                                                        <option value="TESTIGO">Testigo</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="required-label">Calidad Involucrado</label>
                                                                    <select name="inv_alumno" id="inv_alumno" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        @foreach($ti as $listado)
                                                                            <option value="{{ $listado->idTipoInv }}">{{ $listado->tipoInv }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label class="required-label">¿Miembro E.C.E.?</label>
                                                                    <select name="miembro_ece" id="miembro_ece" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        <option value="0">No</option>
                                                                        <option value="1">Sí</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1">Correo Electrónico</label>
                                                                    <input type="email" class="form-control" id="mail_inv" name="mail_inv"
                                                                        autocomplete="off" style="text-transform:uppercase;" value="">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1">Fono / Celular</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            +56 9
                                                                        </div>
                                                                        <input type="tel" name="fono_ev" class="form-control" maxlength="8"
                                                                pattern="\d{8}"
                                                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-8">
                                                                    <label for="exampleInputEmail1">Dirección (Calle, Número,
                                                                        Depto)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-location-arrow"></i>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="direccion_inv"
                                                                            style="text-transform:uppercase;" name="direccion_inv"
                                                                            autocomplete="off" value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Comuna o Ciudad</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-map-marker"></i>
                                                                        </div>
                                                                        <input type="text" class="form-control solo-letras" id="comuna_inv"
                                                                            pattern="^[A-Za-zÀ-ÿ\s]+$" title="Sólo letras y espacios"
                                                                            autocomplete="off" style="text-transform:uppercase;"
                                                                            name="comuna_inv" value="">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <hr>
                                                            <h3>Información de los Apoderados: </h3>

                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label for="movil" class="required-label">Nombre Apoderado</label>
                                                                    <input type="text" class="form-control solo-letras" id="nombre_apo_inv"
                                                                        name="nombre_apo_inv" pattern="^[A-Za-zÀ-ÿ\s]+$"
                                                                        title="Sólo letras y espacios" style="text-transform:uppercase;"
                                                                        autocomplete="off" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="movil" class="required-label">Fono Apoderado</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            +56 9
                                                                        </div>
                                                                        <input type="tel" name="fono_ev" class="form-control" maxlength="8"
                                                                pattern="\d{8}"
                                                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="movil" class="required-label">Domicilio</label>
                                                                    <input type="text" class="form-control" id="domicilio_apo_inv"
                                                                        name="domicilio_apo_inv" style="text-transform:uppercase;"
                                                                        autocomplete="off" required>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="movil">Correo Electrónico</label>
                                                                    <input type="text" class="form-control" id="mail_apo_inv" autocomplete="off"
                                                                        name="mail_apo_inv" style="text-transform:uppercase;">
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Tipo de
                                                                        Vínculo</label>
                                                                    <select name="vinculo_apo_inv" id="vinculo_apo_inv" class="form-control"
                                                                        required>
                                                                        <option value="">...</option>
                                                                        <option value="PADRE">PADRE</option>
                                                                        <option value="MADRE">MADRE</option>
                                                                        <option value="TUTOR LEGAL">TUTOR LEGAL</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label for="movil">Nombre 2do Apoderado</label>
                                                                    <input type="text" class="form-control solo-letras" id="nombre_apo_inv2"
                                                                        autocomplete="off" name="nombre_apo_inv2" pattern="^[A-Za-zÀ-ÿ\s]+$"
                                                                        title="Sólo letras y espacios" style="text-transform:uppercase;">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="movil">Fono 2do Apoderado</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            +56 9
                                                                        </div>
                                                                        <input type="tel" name="fono_ev" class="form-control" maxlength="8"
                                                                pattern="\d{8}"
                                                                oninput="this.value=this.value.replace(/[^0-9]/g,'');" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="movil">Domicilio</slabel>
                                                                        <input type="text" class="form-control" id="domicilio_apo_inv2"
                                                                            autocomplete="off" name="domicilio_apo_inv2"
                                                                            style="text-transform:uppercase;">
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <div class="col-md-5">
                                                                    <label for="movil">Correo Electrónico</label>
                                                                    <input type="text" class="form-control" id="mail_apo_inv2"
                                                                        autocomplete="off" name="mail_apo_inv2"
                                                                        style="text-transform:uppercase;">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Tipo de Vínculo</label>
                                                                    <select name="vinculo_apo_inv2" id="vinculo_apo_inv2" class="form-control">
                                                                        <option value="">...</option>
                                                                        <option value="PADRE">PADRE</option>
                                                                        <option value="MADRE">MADRE</option>
                                                                        <option value="TUTOR LEGAL">TUTOR LEGAL</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i class="fa fa-save"></i>
                                                                        Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="modal-edit-involucrados">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-users"></i> <b>Edición</b>: Individualización de los
                                                Intervinientes</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div id="mensaje">
                                                @if(session()->has('status'))
                                                    <p class="alert alert-success">{{session('status')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form id="form6" name="form6" action="/Protocolo/EditarInvolucrado" method="POST"
                                                          class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" id="id_involucrado" name="id_involucrado" value="">
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <h3>Información del Involucrado: </h3>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1">RUN Involucrado</label>
                                                                    <button class="btn btn-xs" type="button" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="Ingresar RUN sin puntos ni guión, en caso de no contar con RUN ingresar 19">
                                                                        <i class="fa fa-info"></i></button>
                                                                    <input type="text" class="form-control" id="rut_val_e" name="rut_e"
                                                                           autocomplete="off"
                                                                           readonly>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1"
                                                                           class="required-label">Nombres</label>
                                                                    <input type="text" class="form-control" id="nombres_inv_e"
                                                                           name="nombres_inv_e"
                                                                           style="text-transform:uppercase;" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Ap.
                                                                        Paterno</label>
                                                                    <input type="text" class="form-control" id="paterno_inv_e"
                                                                           name="paterno_inv_e"
                                                                           style="text-transform:uppercase;" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Ap.
                                                                        Materno</label>
                                                                    <input type="text" class="form-control" id="materno_inv_e"
                                                                           name="materno_inv_e"
                                                                           style="text-transform:uppercase;" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Fecha
                                                                        Nacim.</label>
                                                                    <input type="date" class="form-control" id="fecnac_inv_e"
                                                                           name="fecnac_inv_e" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Genero</label>
                                                                    <select name="genero_inv_e" id="genero_inv_e" class="form-control" required>
                                                                        <option value="">...</option>
                                                                        <option value="Masculino">Masculino</option>
                                                                        <option value="Femenino">Femenino</option>
                                                                        <option value="Otro">Otro</option>
                                                                        <option value="Prefiero no decirlo">Prefiero no decirlo</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="exampleInputEmail1"
                                                                           class="required-label">Nacionalidad</label>
                                                                    <select name="nacionalidad_inv_e" id="nacionalidad_inv_e"
                                                                            class="form-control"
                                                                            required>
                                                                        <option value="">...</option>
                                                                        <option value="CHILENO">CHILENO</option>
                                                                        <option value="EXTRANJERO">EXTRANJERO</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="exampleInputEmail1" class="required-label">Curso</label>
                                                                    <select name="curso_inv_e" id="curso_inv_e" class="form-control"
                                                                            required>
                                                                        <option value="">...</option>
                                                                        <option value="N/A">NO APLICA</option>
                                                                        <option value="1B">1 BÁSICO</option>
                                                                        <option value="2B">2 BÁSICO</option>
                                                                        <option value="3B">3 BÁSICO</option>
                                                                        <option value="4B">4 BÁSICO</option>
                                                                        <option value="5B">5 BÁSICO</option>
                                                                        <option value="6B">6 BÁSICO</option>
                                                                        <option value="7B">7 BÁSICO</option>
                                                                        <option value="8B">8 BÁSICO</option>
                                                                        <option value="1M">1 MEDIO</option>
                                                                        <option value="2M">2 MEDIO</option>
                                                                        <option value="3M">3 MEDIO</option>
                                                                        <option value="4M">4 MEDIO</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="exampleInputEmail1" class="required-label">Letra</label>
                                                                    <button class="btn btn-xs" type="button" data-toggle="tooltip"
                                                                            data-placement="top"
                                                                            title="En el caso de que el establecimiento cuente con solo un curso, deberá seleccionar A">
                                                                        <i class="fa fa-info"></i></button>
                                                                    <select name="letra_inv_e" id="letra_inv_e" class="form-control"
                                                                            required>
                                                                        <option value="">...</option>
                                                                        <option value="-">CURSO ÚNICO</option>
                                                                        <option value="N/A">NO APLICA</option>
                                                                        <option value="A">A</option>
                                                                        <option value="B">B</option>
                                                                        <option value="C">C</option>
                                                                        <option value="D">D</option>
                                                                        <option value="E">E</option>
                                                                        <option value="F">F</option>
                                                                        <option value="G">G</option>
                                                                        <option value="H">H</option>
                                                                        <option value="I">I</option>
                                                                        <option value="J">J</option>
                                                                        <option value="K">K</option>
                                                                        <option value="L">L</option>
                                                                        <option value="M">M</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Correo Electrónico</label>
                                                                    <input type="email" class="form-control" id="mail_inv_e"
                                                                           name="mail_inv_e" style="text-transform:uppercase;"
                                                                           value="">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1">Fono / Celular</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            +56 9
                                                                        </div>
                                                                        <input type="number" class="form-control" id="fono_inv_e"
                                                                               name="fono_inv_e"
                                                                               value="">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="exampleInputEmail1" class="required-label">¿Miembro
                                                                        E.C.E.?</label>
                                                                    <select name="miembro_ece_e" id="miembro_ece_e" class="form-control"
                                                                            required>
                                                                        <option value="">...</option>
                                                                        <option value="0">No</option>
                                                                        <option value="1">Si</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1" class="required-label">Calidad
                                                                        Involucrado</label>
                                                                    <select name="inv_alumno_e" id="inv_alumno_e" class="form-control"
                                                                            required>
                                                                        <option value="">...</option>
                                                                        @foreach($ti as $listado)
                                                                            <option
                                                                                    value="{{ $listado->idTipoInv }}">{{ $listado->tipoInv }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-8">
                                                                    <label for="exampleInputEmail1">Dirección (Calle, Número,
                                                                        Depto)</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-location-arrow"></i>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="direccion_inv_e"
                                                                               style="text-transform:uppercase;" name="direccion_inv_e"
                                                                               value=""></div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Comuna o Ciudad</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-map-marker"></i>
                                                                        </div>
                                                                        <input type="text" class="form-control" id="comuna_inv_e"
                                                                               style="text-transform:uppercase;" name="comuna_inv_e"
                                                                               value=""></div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <h3>Información de los Apoderados: </h3>
                                                            <div class="form-group">

                                                                <div class="col-md-4">
                                                                    <label for="movil" class="required-label">Nombre Apoderado</label>
                                                                    <input type="text" class="form-control"
                                                                           id="nombre_apo_inv_e" name="nombre_apo_inv_e"
                                                                           style="text-transform:uppercase;" required>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="movil" class="required-label">Fono Apoderado</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            +56 9
                                                                        </div>
                                                                        <input type="number" class="form-control"
                                                                               id="fono_apo_inv_e" name="fono_apo_inv_e" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="movil" class="required-label">Domicilio</label>
                                                                    <input type="text" class="form-control"
                                                                           id="domicilio_apo_inv_e" name="domicilio_apo_inv_e"
                                                                           style="text-transform:uppercase;" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-5">
                                                                    <label for="movil">Correo Electrónico</label>
                                                                    <input type="text" class="form-control"
                                                                           id="mail_apo_inv_e" name="mail_apo_inv_e"
                                                                           style="text-transform:uppercase;">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Tipo de
                                                                        Vínculo</label>
                                                                    <select name="vinculo_apo_inv_e" id="vinculo_apo_inv_e"
                                                                            class="form-control"
                                                                            required>
                                                                        <option value="">...</option>
                                                                        <option value="PADRE">PADRE</option>
                                                                        <option value="MADRE">MADRE</option>
                                                                        <option value="TUTOR LEGAL">TUTOR LEGAL</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label for="movil">Nombre 2do Apoderado</label>
                                                                    <input type="text" class="form-control"
                                                                           id="nombre_apo_inv2_e" name="nombre_apo_inv2_e"
                                                                           style="text-transform:uppercase;">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="movil">Fono 2do Apoderado</label>
                                                                    <div class="input-group">
                                                                        <div class="input-group-addon">
                                                                            +56 9
                                                                        </div>
                                                                        <input type="number" class="form-control"
                                                                               id="fono_apo_inv2_e" name="fono_apo_inv2_e">
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="movil">Domicilio</label>
                                                                    <input type="text" class="form-control"
                                                                           id="domicilio_apo_inv2_e" name="domicilio_apo_inv2_e"
                                                                           style="text-transform:uppercase;">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-5">
                                                                    <label for="movil">Correo Electrónico</label>
                                                                    <input type="text" class="form-control"
                                                                           id="mail_apo_inv2_e" name="mail_apo_inv2_e"
                                                                           style="text-transform:uppercase;">
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Tipo de Vínculo</label>
                                                                    <select name="vinculo_apo_inv2_e" id="vinculo_apo_inv2_e"
                                                                            class="form-control">
                                                                        <option value="">...</option>
                                                                        <option value="PADRE">PADRE</option>
                                                                        <option value="MADRE">MADRE</option>
                                                                        <option value="TUTOR LEGAL">TUTOR LEGAL</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button type="submit" class="btn btn-block bg-black-active"><i class="fa fa-save"></i>
                                                                        Actualizar Información
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-suplencia-ece">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-shield"></i> Designación y Carga de Documento ECE
                                                Suplente o Subrogante</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/SuplenciaECE" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Nombre
                                                                        Completo
                                                                        Suplente</label>
                                                                    <input type="text" class="form-control"
                                                                           name="nombreECESup" style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Correo
                                                                        Suplente</label>
                                                                    <input type="email" class="form-control"
                                                                           name="mailECESup" style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Archivo
                                                                        Adjunto
                                                                        (Máximo 10
                                                                        mb):</label>
                                                                    <input type="file" name="docs_adj_multi" class="form-control"
                                                                           value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-2">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-edit-hechos">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-archive"></i> Detalle de los Hechos</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/EditarHecho" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" id="id_hecho" name="id_hecho" value="">
                                                        <input type="hidden" id="id_protocolo_e" name="id_protocolo_e"
                                                               value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1">Fecha Inicio
                                                                        Hecho</label>
                                                                    <input type="date" class="form-control"
                                                                           id="fec_ev_ini_e" name="fec_ev_ini_e">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1">Hora Inicio
                                                                        Hecho</label>
                                                                    <input type="time" class="form-control"
                                                                           id="hora_ev_ini_e" name="hora_ev_ini_e">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1">Fecha Fin Hecho</label>
                                                                    <input type="date" class="form-control"
                                                                           id="fec_ev_fin_e" name="fec_ev_fin_e">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1">Hora Fin Hecho</label>
                                                                    <input type="time" class="form-control"
                                                                           id="hora_ev_fin_e" name="hora_ev_fin_e">
                                                                </div>
                                                            </div>
                                                            <h4><b>Persona que informa la ocurrencia de los Hechos:</b></h4>
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Comunicado
                                                                        por
                                                                        (Nombre
                                                                        Completo):</label>
                                                                    <input type="text" class="form-control"
                                                                           id="notif_ev_e" name="notif_ev_e"
                                                                           style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1"
                                                                           class="required-label">Domicilio:</label>
                                                                    <input type="text" class="form-control"
                                                                           id="dom_ev_e" name="dom_ev_e"
                                                                           style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="exampleInputEmail1"
                                                                           class="required-label">Teléfono:</label>
                                                                    <div class="input-group">
                                                            <div class="input-group-addon">+56 9</div>
                                                            <input type="tel"
                                                                name="fono_ev"
                                                                class="form-control"
                                                                maxlength="8"
                                                                pattern="\d{8}"
                                                                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                                                required>
                                                        </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1" class="required-label">Correo
                                                                        Electrónico:</label>
                                                                    <input type="email" class="form-control"
                                                                           id="mail_ev_e" name="mail_ev_e"
                                                                           style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <label for="exampleInputEmail1" class="required-label">Función o
                                                                        Cargo:</label>
                                                                    <input type="text" class="form-control" id="func_ev_e"
                                                                           name="func_ev_e" style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <h4><b>Encargado de Convivencia Escolar:</b></h4>
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <p><b>NOTA: </b>En el caso de que los hechos sean constitutivos de
                                                                        delito se
                                                                        habilitará
                                                                        una caja para realizar denuncia respectiva ante el ministerio
                                                                        público.</p>
                                                                    <label for="exampleInputEmail1" class="required-label">¿Los hechos
                                                                        son
                                                                        constitutivos de
                                                                        delito?</label>
                                                                    <select id="es_delito_e" name="es_delito_e" class="form-control"
                                                                            required>
                                                                        <option value="">--</option>
                                                                        <option value="0">NO</option>
                                                                        <option value="1">SI</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p>Documento:
                                                                        <a href="#"
                                                                           target="_blank" id="link_e"
                                                                           class="btn btn-xs btn-success"><i
                                                                                    class="fa fa-download"></i> Ver Documento Actual</a>
                                                                    </p>
                                                                    <label for="exampleInputEmail1">Adjuntar documento (Memorandum,
                                                                        Correo
                                                                        Electrónico, Otro):</label>
                                                                    <input type="file" name="docs_adj_hechos_e" class="form-control"
                                                                           value="">
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="form-group">
                                                                <div class="col-md-9">
                                                                    <label for="movil" class="required-label">Descripción de los
                                                                        hechos</label>
                                                                    <textarea class="form-control" id="hechos_e" name="hechos_e"
                                                                              rows="5"
                                                                              placeholder="" style="text-transform:uppercase;"
                                                                              required></textarea>
                                                                </div>

                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Actualizar Información
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-noti-fiscalia">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-warning"></i> Registro de Denuncia a Fiscalia:</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/NuevaNotifFiscalia" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="alert alert-warning alert-dismissible">
                                                                <button type="button" class="close" data-dismiss="alert"
                                                                        aria-hidden="true">
                                                                    ×
                                                                </button>
                                                                <h4><i class="icon fa fa-bell-o"></i> ¡Atención!</h4>
                                                                <strong>Recuerde que tiene 24 Horas para realizar la denuncia.</strong>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-8">
                                                                    <label for="exampleInputEmail1" class="required-label">Selección de
                                                                        Fiscalía:</label>
                                                                    <select name="fiscalia" id="fiscalia" class="form-control" required>
                                                                        @foreach($fiscalias as $listado)
                                                                            <option
                                                                                    value="{{ $listado->idFisc }}">{{ $listado->nombreFisc }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Sistematizado por:</label>
                                                                    <input type="text" class="form-control"
                                                                           value="{{ Auth::user()->name }}" readonly>
                                                                </div>
                                                            </div>
                                                            <p>Otros Antecedentes:</p>
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Archivos
                                                                        Adjuntos
                                                                        (Denuncia
                                                                        Oficial Sólo Formato PDF):</label>
                                                                    <input type="file" name="docs_adj_multi_fisc" class="form-control"
                                                                           required accept="application/pdf"
                                                                           value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-send"></i>
                                                                        Guardar y Notificar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-activacion">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b>Registro de Notificaciones:</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/ActivacionProtocolo" method="POST"
                                                          class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="alert alert-warning alert-dismissible">
                                                                <button type="button" class="close" data-dismiss="alert"
                                                                        aria-hidden="true">
                                                                    ×
                                                                </button>
                                                                <h4><i class="icon fa fa-bell-o"></i> ¡Atención!</h4>
                                                                <strong>Recuerde que tiene 7 días desde la presente notificación para
                                                                    citar
                                                                    a los involucrados.</strong>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-8">
                                                                    <label for="exampleInputEmail1">Notificar a:</label>
                                                                    <select name="notif_a" id="" class="form-control">
                                                                        <option value="TODOS">TODOS [DIRECTOR - ENCARGADO CONVIVENCIA
                                                                            ESCOLAR - ABOGADOS]
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Tipo de notificación:</label>
                                                                    <select name="tipo_notif" id="" class="form-control">
                                                                        @foreach($tn as $listado)
                                                                            <option
                                                                                    value="{{ $listado->idTiposNotif }}">{{ $listado->notif}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-5">
                                                                    <label for="exampleInputEmail1" class="required-label">¿Hechos serán
                                                                        denunciados al
                                                                        Tribunal de Familia?</label>
                                                                    <select name="es_vulneracion" id="" class="form-control" required>
                                                                        <option value="">--</option>
                                                                        <option value="0">NO</option>
                                                                        <option value="1">SI</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Notificado por:</label>
                                                                    <input type="text" class="form-control"
                                                                           name="notif_por" value="Daniel Gutierrez Fariña"
                                                                           readonly>
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-send"></i>
                                                                        Guardar y Notificar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-noti-tribunal">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-warning"></i> Registro de Denuncia a Tribunal de
                                                Familia:</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/NuevaNotifTribunales" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="alert alert-warning alert-dismissible">
                                                                <button type="button" class="close" data-dismiss="alert"
                                                                        aria-hidden="true">
                                                                    ×
                                                                </button>
                                                                <h4><i class="icon fa fa-bell-o"></i> ¡Atención!</h4>
                                                                <strong>Recuerde que tiene 3 días para realizar la denuncia en la
                                                                    Oficina
                                                                    Judicial Virtual, acá debe adjuntar el Certificado Otorgado por la
                                                                    OJV.</strong>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-8">
                                                                    <label for="exampleInputEmail1" class="required-label">Selección de
                                                                        Tribunal de
                                                                        Familia:</label>
                                                                    <select name="tribunal" id="tribunal" class="form-control" required>
                                                                        @foreach($tribunales as $listado)
                                                                            <option
                                                                                    value="{{ $listado->idJuz }}">{{ $listado->nombreJuz }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <label for="exampleInputEmail1">Sistematizado por:</label>
                                                                    <input type="text" class="form-control"
                                                                           value="{{ Auth::user()->name }}" readonly>
                                                                </div>
                                                            </div>
                                                            <p>Otros Antecedentes:</p>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label for="exampleInputEmail1" class="required-label">Adjuntar
                                                                        Certificado Oficina Virtual
                                                                        Judicial OVJ:</label>
                                                                    <input type="file" name="docs_adj_multi_tribunal"
                                                                           class="form-control"
                                                                           value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-send"></i>
                                                                        Guardar y Notificar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-multimedia">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-shield"></i> Inicio de la Investigación y Registro de
                                                Diligencias</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/NuevaIncautacion" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1">Selector de Tipo Antecedente</label>
                                                                    <select name="elemento" id="" class="form-control">
                                                                        <option value="Medios de Prueba">Medios de Prueba</option>
                                                                        <option value="Declaraciones">Declaraciones</option>
                                                                        <option value="Revisión CCTV">Revisión de CCTV</option>
                                                                        <option value="Entrevista Testigo">Entrevista Testigo
                                                                        </option>
                                                                        <option value="Revisión Documentos">Revisión Documentos
                                                                        </option>
                                                                        <option value="Otros">Otros</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1">Archivo Adjunto (Máximo 10
                                                                        mb):</label>
                                                                    <input type="file" name="docs_adj_multi" class="form-control"
                                                                           value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-10">
                                                                    <label for="exampleInputEmail1"
                                                                           class="required-label">Diligencia</label>
                                                                    <input type="text" class="form-control"
                                                                           name="desc_inc" style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-cierre">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-shield"></i> Informe de Cierre</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/CierreInvestigacion" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <input type="hidden" name="esCierre" value="1">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Archivo
                                                                        Adjunto
                                                                        (Máximo 10
                                                                        mb):</label>
                                                                    <input type="file" name="docs_adj_multi" class="form-control"
                                                                           value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-10">
                                                                    <label for="exampleInputEmail1" class="required-label">Observaciones
                                                                        de
                                                                        Cierre</label>
                                                                    <input type="text" class="form-control"
                                                                           name="desc_cierre" style="text-transform:uppercase;"
                                                                           required>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="mail_eq_ece" id="mail_eq_ece" value="1"
                                                                                   type="checkbox"> ¿Enviar por email a equipo ECE?
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-informe-final">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-shield"></i> Carga de Informe Final</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/InformeFinal" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Archivo
                                                                        Adjunto
                                                                        (Máximo 10
                                                                        mb):</label>
                                                                    <input type="file" name="docs_adj_multi" class="form-control"
                                                                           value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <div class="checkbox">
                                                                        <label>
                                                                            <input name="mail_eq_ece" id="mail_eq_ece" value="1"
                                                                                   type="checkbox"> ¿Enviar por email a los
                                                                            involucrados?
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-acciones">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-shield"></i> Reporte de Acciones Realizadas</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/Acciones" method="POST"
                                                          class="form-horizontal" enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1" class="required-label">Fecha
                                                                        Acción(es):</label>
                                                                    <input type="date" name="fecAcciones" class="form-control fecha-validable" min="1900-01-01"
                                                                        max="{{ now()->format('Y-m-d') }}" required>

                                                                </div>
                                                                <div class="col-md-6">
                                                                    <label for="exampleInputEmail1">Archivo Adjunto (Máximo 10
                                                                        mb):</label>
                                                                    <input type="file" name="docs_adj_multi" class="form-control"
                                                                           value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label for="exampleInputEmail1"
                                                                           class="required-label">Acción(es):</label>
                                                                    <input type="text" name="detAcciones" class="form-control"
                                                                           value="" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-2">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-medidas-resguardo">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b>Registro de Medidas de Resguardo</b></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/ArchivarProtocolo" method="POST"
                                                          class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="{{ $protocolo->places_protocolos_idProt }}">
                                                        <div class="box-body">
                                                            <div class="form-group">
                                                                <div class="col-md-12">
                                                                    <label for="exampleInputEmail1" class="required-label">Medidas de
                                                                        resguardo
                                                                        sugeridas</label>
                                                                    <ul>
                                                                        <li>Separación de los involucrados de espacios
                                                                            comunes.
                                                                        </li>
                                                                        <li>Separación del eventual responsable de su función
                                                                            directa con los estudiantes, puedo ser trasladado a
                                                                            otras
                                                                            funciones o labores fuera del aula.
                                                                        </li>
                                                                    </ul>
                                                                    <select name="medidas" id="" class="form-control">
                                                                        <option value="Participación de un programa de
                                                                            reforzamiento
                                                                            académico.">Participación de un programa de
                                                                            reforzamiento
                                                                            académico.
                                                                        </option>
                                                                        <option value="Apoyo y acompañamiento pedagógico de tutor
                                                                            sombra,
                                                                            por el tiempo que determine en el plan de intervención.">Apoyo y
                                                                            acompañamiento pedagógico de tutor
                                                                            sombra,
                                                                            por el tiempo que determine en el plan de intervención.
                                                                        </option>
                                                                        <option value="Derivación a sicólogo del establecimiento
                                                                            educacional.">Derivación a sicólogo del establecimiento
                                                                            educacional.
                                                                        </option>
                                                                        <option value="Solicitud a tribunales de familia de
                                                                            asignación de
                                                                            un curador, al estudiante afectado, si fuere necesario.">
                                                                            Solicitud a tribunales de familia de
                                                                            asignación de
                                                                            un curador, al estudiante afectado, si fuere necesario.
                                                                        </option>
                                                                        <option value="propiciar la participación del estudiante
                                                                            en
                                                                            actividades extracurriculares que le permita
                                                                            relacionarse con
                                                                            otros estudiantes, entre otras.">propiciar la participación del
                                                                            estudiante
                                                                            en
                                                                            actividades extracurriculares que le permita
                                                                            relacionarse con
                                                                            otros estudiantes, entre otras.
                                                                        </option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-md-2">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black"><i
                                                                                class="fa fa-save"></i>
                                                                        Guardar
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modal-edit-elimina_etapa2">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-users"></i> <b>Eliminación</b>: Inicio de la
                                                Investigación</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div id="mensaje">
                                                @if(session()->has('status'))
                                                    <p class="alert alert-success">{{session('status')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form id="formeli" name="formeli" action="/Protocolo/EliminarEtapa2" method="POST"
                                                          class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" id="indice_eliminar" name="id_etapa_dos" value="">
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <h3>Con esta confirmación usted eliminará la línea de Etapa 2, <br> Etapa de
                                                                Investigación: </h3>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Confirmar Eliminación
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-edit-elimina_etapa3">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        <h4 class="modal-title">
                                            <b><i class="fa fa-users"></i> Eliminación: Informe de Cierre de la Investigación</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div id="mensaje">
                                                @if(session()->has('status'))
                                                    <p class="alert alert-success">{{ session('status') }}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form action="/Protocolo/EliminarEtapa3" method="POST" class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" id="indice_eliminar_tres" name="id_etapa_tres">
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">

                                                        <div class="box-body">
                                                            <h3>
                                                                Con esta confirmación usted eliminará la línea de Etapa 3,<br>
                                                                Etapa de Cierre de la Investigación:
                                                            </h3>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label>Guardar en BD</label>
                                                                    <button type="submit" class="btn btn-block bg-black-active">
                                                                        <i class="fa fa-save"></i> Confirmar Eliminación
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar Ventana</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modal-edit-elimina_etapa4">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-users"></i> <b>Eliminación</b>: Informe Final de la
                                                Investigación</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div id="mensaje">
                                                @if(session()->has('status'))
                                                    <p class="alert alert-success">{{session('status')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form id="formeli" name="formeli" action="/Protocolo/EliminarEtapa4" method="POST"
                                                          class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" id="indice_eliminar_cuatro" name="id_etapa_cuatro" value="">
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <h3>Con esta confirmación usted eliminará la línea de Etapa 4 y 5, <br> Etapa
                                                                Final de la Investigación: </h3>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                                class="fa fa-save"></i>
                                                                        Confirmar Eliminación
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-edit-elimina_etapa6">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><b><i class="fa fa-users"></i> <b>Eliminación</b>: Acciones de
                                                Seguimiento</b>
                                        </h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div id="mensaje">
                                                @if(session()->has('status'))
                                                    <p class="alert alert-success">{{session('status')}}</p>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <div class="box box-bg-purple">
                                                    <form id="formeli" name="formeli" action="/Protocolo/EliminarEtapa6" method="POST"
                                                          class="form-horizontal">
                                                        @csrf
                                                        <input type="hidden" id="indice_eliminar_seis" name="id_etapa_seis" value="">
                                                        <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                                        <input type="hidden" name="num_prot" value="1">
                                                        <div class="box-body">
                                                            <h3>Con esta confirmación usted eliminará la línea de Etapa 6, <br> Etapa
                                                                Acciones de Seguimiento: </h3>
                                                            <div class="form-group">
                                                                <div class="col-md-3">
                                                                    <label for="movil">Guardar en BD </label>
                                                                    <button class="btn btn-block bg-black-active"><i
                                                                            class="fa fa-save"></i>
                                                                        Confirmar Eliminación
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn pull-left" data-dismiss="modal">Cerrar
                                            Ventana
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="modal-hechos">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><b><i class="fa fa-archive"></i> Detalle de los Hechos</b></h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-bg-purple">
                            <form action="/Protocolo/NuevoHecho" method="POST"
                                  class="form-horizontal" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id_protocolo" value="{{ $id_protocolo }}">
                                <input type="hidden" id="id_establecimiento" name="id_establecimiento"
                                       value="{{ $protocolo->idEst }}">
                                <input type="hidden" name="num_prot" value="1">

                               
                                @if ($errors->has('fec_ev_ini') || $errors->has('fono_ev') || $errors->has('hechos') || $errors->has('es_delito'))
                                <div class="alert alert-danger" style="margin: 10px 15px 0 15px;">
                                    <strong>Por favor corrige los siguientes errores:</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                              

                                <div class="box-body">
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1" class="required-label">Fecha Inicio
                                                Hecho</label>
                                            <input type="date" class="form-control fecha-validable" name="fec_ev_ini" min="1900-01-01"
                                                   max="{{ now()->format('Y-m-d') }}" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1" class="required-label">Hora Inicio
                                                Hecho</label>
                                            <input type="time" class="form-control"
                                                   name="hora_ev_ini" required>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1" class="required-label">Fecha Fin Hecho</label>
                                           
                                            <input type="date" class="form-control fecha-validable" name="fec_ev_fin" min="1900-01-01"
                                                   max="{{ now()->format('Y-m-d') }}" required>
                                           

                                        </div>
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1" class="required-label">Hora Fin Hecho</label>
                                            <input type="time" class="form-control"
                                                   name="hora_ev_fin" required>
                                        </div>
                                    </div>
                                    <h4><b>Persona que informa la ocurrencia de los Hechos:</b></h4>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1" class="required-label">Comunicado
                                                por
                                                (Nombre
                                                Completo):</label>
                                            <input type="text" class="form-control solo-letras" name="notif_ev" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                                   title="Solo letras y espacios" autocomplete="off" style="text-transform:uppercase;" required>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1"
                                                   class="required-label">Domicilio:</label>
                                            <input type="text" class="form-control"
                                                   name="dom_ev" autocomplete="off"
                                                   style="text-transform:uppercase;"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-3">
                                            <label for="exampleInputEmail1"
                                                   class="required-label">Teléfono:</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">+56 9</div>
                                             
                                                <input type="tel"
                                                       name="fono_ev"
                                                       class="form-control"
                                                       maxlength="8"
                                                       pattern="\d{8}"
                                                       oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);"
                                                       required>
                                               
                                                       
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="exampleInputEmail1" class="required-label">Correo
                                                Electrónico:</label>
                                            <input type="email" class="form-control"
                                                   name="mail_ev" autocomplete="off"
                                                   style="text-transform:uppercase;"
                                                   required>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="exampleInputEmail1" class="required-label">Función o
                                                Cargo:</label>
                                            <input type="text" class="form-control solo-letras" name="func_ev" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                                   title="Solo letras y espacios" autocomplete="off" style="text-transform:uppercase;" required>

                                        </div>
                                    </div>
                                    <hr>
                                    <h4><b>Encargado de Convivencia Escolar:</b></h4>
                                    <div class="form-group">
                                        <div class="col-md-6">
                                            <p><b>NOTA: </b>En el caso de que los hechos sean constitutivos de
                                                delito se
                                                habilitará
                                                una caja para realizar denuncia respectiva ante el ministerio
                                                público.</p>
                                            <label for="exampleInputEmail1" class="required-label">¿Los hechos
                                                son
                                                constitutivos de
                                                delito?</label>
                                            <select name="es_delito" id="" class="form-control" required>
                                                <option value="">--</option>
                                                <option value="0">NO</option>
                                                <option value="1">SI</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="exampleInputEmail1">Adjuntar documento (Memorandum,
                                                Correo
                                                Electrónico, Otro):</label>
                                            <input type="file"
                                                   name="docs_adj_hechos"
                                                   class="form-control"
                                                   accept="application/pdf,image/jpeg,image/png">
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <div class="col-md-10">
                                            <label for="movil" class="required-label">Descripción de los
                                                hechos</label>
                                            <textarea class="form-control" name="hechos" rows="5"
                                                      placeholder="" style="text-transform:uppercase;"
                                                      required></textarea>
                                        </div>

                                        <div class="col-md-2">
                                            <label for="movil">Guardar en BD </label>
                                            <button class="btn btn-block bg-black-active"><i
                                                    class="fa fa-save"></i>
                                                Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                        <!-- FIN MODAL REVISADOS -->


                        <script>
    document.addEventListener('DOMContentLoaded', function () {
        var config = [
            {
                select: document.getElementById('inv_alumno'),
                fields: [
                    { name: 'nombre_apo_inv' },
                    { name: 'fono_apo_inv' },
                    { name: 'mail_apo_inv' },
                    { name: 'vinculo_apo_inv' },
                    { name: 'domicilio_apo_inv' },
                    { name: 'comuna_apo_inv' }
                ]
            },
            {
                select: document.getElementById('inv_alumno_e'),
                fields: [
                    { name: 'nombre_apo_inv_e' },
                    { name: 'fono_apo_inv_e' },
                    { name: 'mail_apo_inv_e' },
                    { name: 'vinculo_apo_inv_e' },
                    { name: 'domicilio_apo_inv_e' },
                    { name: 'comuna_apo_inv_e' }
                ]
            }
        ];

        function toggler(select, fields) {
            if (!select) return;

            function update() {
                var option = select.selectedOptions[0];
                var requiere = false;

                if (option) {
                    var texto = option.text.trim().toUpperCase();
                    requiere = (texto === 'ESTUDIANTE AFECTADO' || texto === 'ESTUDIANTE AGRESOR');
                }

                fields.forEach(function (item) {
                    var field = document.getElementsByName(item.name)[0];
                    if (!field) return;

                    var column = field.closest('[class*="col-"]');
                    var label = column ? column.querySelector('label') : null;

                    if (requiere) {
                        field.removeAttribute('disabled');
                        field.setAttribute('required', 'required');
                        if (label) label.classList.add('required-label');
                    } else {
                        field.value = '';
                        field.removeAttribute('required');
                        field.setAttribute('disabled', 'disabled');
                        if (label) label.classList.remove('required-label');
                    }
                });
            }

            select.addEventListener('change', update);
            update();
        }

        config.forEach(function (item) {
            toggler(item.select, item.fields);
        });
    });
    </script>

    @include('protocolos.partials.input_guards')


    <script>


        function validaRut(rut) {
            if (!rut) return;


            var cleanedRut = rut.replace(/[^0-9kK]/g, '').toUpperCase();


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
                },
                type: 'POST',
                url: '/VerificarRUNExistente', 
                data: { id: cleanedRut },
                success: function(data) {

                    if (data) {
                        $('#nombres_inv').val(data.nombresInv);
                        $('#paterno_inv').val(data.paternoInv);
                        $('#materno_inv').val(data.maternoInv);
                        $('#fecnac_inv').val(data.fecNacInv);
                        $('#genero_inv').val(data.generoInv);
                        $('#nacionalidad_inv').val(data.nacionalidadInv);
                        $('#miembro_ece').val(data.miembroece);
                        $('#mail_inv').val(data.mailInv);
                        $('#fono_inv').val(data.fonoInv);
                        $('#direccion_inv').val(data.domicilioInv);
                        $('#comuna_inv').val(data.comunaInv);
                        $('#nombre_apo_inv').val(data.apoderadoInv);
                        $('#fono_apo_inv').val(data.fonoApoInv);
                        $('#domicilio_apo_inv').val(data.domicilioApoInv);
                        $('#mail_apo_inv').val(data.mailApoInv);
                        $('#vinculo_apo_inv').val(data.vinculoApo);
                        $('#nombre_apo_inv2').val(data.apoderado2Inv);
                        $('#fono_apo_inv2').val(data.fono2ApoInv);
                        $('#domicilio_apo_inv2').val(data.domicilio2ApoInv);
                        $('#mail_apo_inv2').val(data.mail2ApoInv);
                        $('#vinculo_apo_inv2').val(data.vinculo2Apo);

                        console.log('Datos de involucrado precargados.');
                    } else {
                        console.log('RUN no encontrado. Continuando con un nuevo registro.');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error al buscar RUN:", textStatus, errorThrown);
                }
            });
        }

    </script>







                @include('protocolos.partials.input_guards')
               <script> 
    document.addEventListener('DOMContentLoaded', function() {

        $('#form6').on('submit', function(e) {


            var freshToken = $('meta[name="csrf-token"]').attr('content');


            $(this).find('input[name="_token"]').val(freshToken);


        });
    });
    </script>
    <script>

    (function () {


        function abrirModalEdicionInterviniente(idInv, idProt) {
        if (!idInv || !idProt) { return; }

        const $modal = $('#modal-edit-involucrados');
        const $form = $modal.find('form'); 

        $modal.data('bs.modal', null); 


        $form.find('input:not([type=hidden]), select, textarea').val(''); 

        $('.modal-backdrop').remove(); 
        $modal.appendTo("body"); 

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            type: 'POST',
            url: '/TraerInterviniente',
            data: { idInt: idInv, idPro: idProt },
            success: function (data) {

                if (!data) { alert('No se encontraron datos.'); $modal.modal('show'); return; }

                    $('#id_involucrado').val(data.idInv);
                    $('#rut_val_e').val(data.runInv);
                    $('#nombres_inv_e').val(data.nombresInv);
                    $('#paterno_inv_e').val(data.paternoInv);
                    $('#materno_inv_e').val(data.maternoInv);
                    $('#fecnac_inv_e').val(data.fecNacInv);
                    $('#genero_inv_e').val(data.generoInv);
                    $('#mail_inv_e').val(data.mailInv);
                    $('#fono_inv_e').val(data.fonoInv);
                    $('#nacionalidad_inv_e').val(data.nacionalidadInv);
                    $('#miembro_ece_e').val(data.miembroece);
                    $('#direccion_inv_e').val(data.domicilioInv);
                    $('#comuna_inv_e').val(data.comunaInv);
                    $('#curso_inv_e').val(data.cursoInv);
                    $('#letra_inv_e').val(data.letraCurInv);
                    $('#inv_alumno_e').val(data.places_tipo_inv_idTipoInv).trigger('change'); 
                    $('#nombre_apo_inv_e').val(data.apoderadoInv);
                    $('#fono_apo_inv_e').val(data.fonoApoInv);
                    $('#domicilio_apo_inv_e').val(data.domicilioApoInv);
                    $('#mail_apo_inv_e').val(data.mailApoInv);
                    $('#vinculo_apo_inv_e').val(data.vinculoApo);
                    $('#nombre_apo_inv2_e').val(data.apoderado2Inv);
                    $('#fono_apo_inv2_e').val(data.fono2ApoInv);
                    $('#domicilio_apo_inv2_e').val(data.domicilio2ApoInv);
                    $('#mail_apo_inv2_e').val(data.mail2ApoInv);
                    $('#vinculo_apo_inv2_e').val(data.vinculo2Apo);

                setTimeout(function() {
                    $modal.modal('show');
                }, 50); 

            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("Falló la llamada AJAX a /TraerInterviniente:", textStatus, errorThrown);
                alert("Error de comunicación. Intente de nuevo.");
                $('.modal-backdrop').remove(); 
            }
        });
    }

    window.abrirModalEdicionInterviniente = abrirModalEdicionInterviniente; 

        function abrirModalEdicionHechos(idHecho, idProt) {
            if (!idHecho || !idProt) { console.error("IDs de Hecho o Protocolo no proporcionados."); return; }

            const $modalHechos = $("#modal-edit-hechos");
            $modalHechos.data('bs.modal', null); 
            $modalHechos.appendTo("body"); 
            $('.modal-backdrop').remove(); 

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                type: 'POST',
                url: '/TraerHechos',
                data: { idHecho: idHecho, idPro: idProt },
                success: function (data) {

                    if (!data || typeof data !== 'object' || Object.keys(data).length === 0) {
                        console.warn("No se encontraron datos válidos.");
                        $modalHechos.modal('show'); 
                        return;
                    }
                    $('#id_hecho').val(data.idHechos);
                    $('#id_protocolo_e').val(data.places_principal_protocolos_idPProt);
                    $('#fec_ev_ini_e').val(data.fecHechosIni);
                    $('#hora_ev_ini_e').val(data.horaHechosIni);
                    $('#fec_ev_fin_e').val(data.fecHechosFin);
                    $('#hora_ev_fin_e').val(data.horaHechosFin);
                    $('#notif_ev_e').val(data.notificaHecho);
                    $('#dom_ev_e').val(data.direccionNotifica);
                    $('#fono_ev_e').val(data.fonoNotifica);
                    $('#mail_ev_e').val(data.mailNotifica);
                    $('#func_ev_e').val(data.funcionNotifica);
                    $('#hechos_e').val(data.hechos);
                    $('#es_delito_e').val(data.esDelito);

                    $modalHechos.modal('show');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.error("Falló la llamada AJAX a /TraerHechos:", textStatus, errorThrown);
                    alert("Ocurrió un error al cargar los datos.");
                    $('.modal-backdrop').remove();
                }
            });
        }


        window.editar_inverviniente = abrirModalEdicionInterviniente;
        window.editar_hechos = abrirModalEdicionHechos;

    })();
    </script>


    <script>
        (function () {
            function mostrarModal(selectorModal, selectorInput, id) {
                var $input = $(selectorInput);
                var $modal = $(selectorModal);

                if (!$input.length || !$modal.length) {
                    console.warn('No se encontró el selector', selectorModal, selectorInput);
                    return;
                }

                $input.val(id);
                $modal.modal();
            }

            window.elimina_etapa_dos = function (id) {
                mostrarModal('#modal-edit-elimina_etapa2', '#indice_eliminar', id);
            };

            window.elimina_etapa_tres = function (id) {
                mostrarModal('#modal-edit-elimina_etapa3', '#indice_eliminar_tres', id);
            };

            window.elimina_etapa_cuatro = function (id) {
                mostrarModal('#modal-edit-elimina_etapa4', '#indice_eliminar_cuatro', id);
            };

            window.elimina_etapa_seis = function (id) {
                mostrarModal('#modal-edit-elimina_etapa6', '#indice_eliminar_seis', id);
            };
        })();
    </script>

                <!-- Solo k RUT -->

                         <script>
        document.addEventListener('DOMContentLoaded', function () {
            var rutInputs = document.querySelectorAll('.solo-rut');

            function isValidRut(clean) {
                if (clean.length < 8) {
                    return false;
                }

                var cuerpo = clean.slice(0, -1);
                var dv = clean.slice(-1).toUpperCase();
                var factor = 2;
                var suma = 0;

                for (var i = cuerpo.length - 1; i >= 0; i--) {
                    suma += parseInt(cuerpo[i], 10) * factor;
                    factor = (factor === 7) ? 2 : factor + 1;
                }

                var esperado = 11 - (suma % 11);
                if (esperado === 11) {
                    esperado = '0';
                } else if (esperado === 10) {
                    esperado = 'K';
                } else {
                    esperado = String(esperado);
                }

                return dv === esperado;
            }

            rutInputs.forEach(function (input) {
                input.addEventListener('keydown', function (event) {
                    if (event.key.length > 1) {
                        return;
                    }
                    if (event.ctrlKey || event.metaKey || event.altKey) {
                        return;
                    }
                    if (/^[0-9kK\.\-]$/.test(event.key)) {
                        var clean = input.value.replace(/[^0-9kK]/gi, '');
                        if (clean.length >= 9 && window.getSelection().toString() === '') {
                            event.preventDefault();
                        }
                        return;
                    }
                    event.preventDefault();
                    showRutAlert();
                });

                input.addEventListener('input', function () {
                    var clean = input.value.replace(/[^0-9kK]/gi, '').toUpperCase();

                    if (!clean.length) {
                        input.value = '';
                        input.classList.remove('rut-valid');
                        return;
                    }

                    if (clean.length > 9) {
                        clean = clean.slice(0, 9);
                    }

                    var cuerpo = clean.slice(0, -1);
                    var dv = clean.slice(-1);
                    var formateado = cuerpo.length
                        ? cuerpo.replace(/\B(?=(\d{3})+(?!\d))/g, '.')
                        : '';

                    input.value = formateado ? formateado + '-' + dv : dv;

                    if (clean.length >= 8) {
                        input.classList.toggle('rut-valid', isValidRut(clean));
                    } else {
                        input.classList.remove('rut-valid');
                    }
                });
            });
        });
        </script>


                         @if(session('success'))
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: '{{ session('success') }}',
                        showConfirmButton: false,
                        timer: 2000
                    });
                    </script>
                    @endif

                    @if($errors->any())
                    <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Validación',
                        html: `{!! implode('<br>', $errors->all()) !!}`,
                        confirmButtonText: 'Entendido'
                    });
                    </script>
                    @endif

@endsection
