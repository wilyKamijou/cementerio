<?php

namespace App\Http\Controllers;

use App\Models\Inhumacion;
use App\Models\Mantenimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BaseController extends Controller
{
    /**
     * Dashboard principal del cementerio - CONSULTAS SQL DIRECTAS
     */
    public function dashboard()
    {
        // 1. Total de difuntos (CONTAR registros)
        $totalDifuntos = DB::select('SELECT COUNT(*) as total FROM inhumaciones')[0]->total;
        
        // 2. Registros de este mes (created_at)
        $registrosMes = DB::select('SELECT COUNT(*) as total FROM inhumaciones WHERE MONTH(created_at) = MONTH(NOW()) AND YEAR(created_at) = YEAR(NOW())')[0]->total;
        
        // 3. Espacios distintos ocupados
        $totalSectores = DB::select('SELECT COUNT(DISTINCT idEspacio) as total FROM inhumaciones')[0]->total;
        
        // 4. Mantenimientos programados para hoy
        $mantenimientosHoy = DB::select('SELECT COUNT(*) as total FROM mantenimientos WHERE DATE(fechaMant) = CURDATE()')[0]->total;
        
        // 5. Últimos 5 registros
        $ultimosDifuntos = DB::select('SELECT * FROM inhumaciones ORDER BY created_at DESC LIMIT 5');
        
        return view('plantillaBase.base', compact(
            'totalDifuntos', 
            'registrosMes', 
            'totalSectores', 
            'mantenimientosHoy',
            'ultimosDifuntos'
        ));
    }
    
    /**
     * Lista de todos los difuntos
     */
    public function lista()
    {
        $difuntos = DB::select('SELECT * FROM inhumaciones ORDER BY created_at DESC');
        return view('cementerio.lista', compact('difuntos'));
    }
    
    /**
     * Ver detalle de un difunto
     */
    public function ver($id)
    {
        $difunto = DB::select('SELECT * FROM inhumaciones WHERE id = ?', [$id]);
        
        if (empty($difunto)) {
            return redirect()->route('cementerio.dashboard')->with('error', 'Registro no encontrado');
        }
        
        return view('cementerio.ver', compact('difunto'));
    }
    
    /**
     * Guardar nuevo registro (INSERT directo)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'paterno' => 'required|string|max:255',
            'materno' => 'required|string|max:255',
            'fechaNaci' => 'nullable|date',
            'fechaDefun' => 'required|date',
            'fechaInhuma' => 'required|date',
            'causaMuer' => 'nullable|string',
            'idEspacio' => 'required|integer',
            'idTipo' => 'required|integer'
        ]);
        
        // INSERT directo a la base de datos
        DB::insert('INSERT INTO inhumaciones (nombre, paterno, materno, fechaNaci, fechaDefun, fechaInhuma, causaMuer, idEspacio, idTipo, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $validated['nombre'],
            $validated['paterno'],
            $validated['materno'],
            $validated['fechaNaci'],
            $validated['fechaDefun'],
            $validated['fechaInhuma'],
            $validated['causaMuer'],
            $validated['idEspacio'],
            $validated['idTipo']
        ]);
        
        return redirect()->route('cementerio.registro')
                         ->with('success', 'Registro guardado exitosamente');
    }
    
    /**
     * Eliminar registro
     */
    public function eliminar($id)
    {
        DB::delete('DELETE FROM inhumaciones WHERE id = ?', [$id]);
        
        return redirect()->route('cementerio.dashboard')
                         ->with('success', 'Registro eliminado correctamente');
    }
    
    /**
     * Buscar difuntos (CONSULTA con LIKE)
     */
    public function buscar(Request $request)
    {
        $query = $request->get('q');
        
        $resultados = DB::select('SELECT * FROM inhumaciones WHERE nombre LIKE ? OR paterno LIKE ? OR materno LIKE ? LIMIT 20', [
            "%{$query}%", 
            "%{$query}%", 
            "%{$query}%"
        ]);
        
        if ($request->ajax()) {
            return response()->json($resultados);
        }
        
        return view('cementerio.resultados', compact('resultados', 'query'));
    }
    
    /**
     * Mantenimientos
     */
    public function mantenimiento()
    {
        $mantenimientos = DB::select('SELECT * FROM mantenimientos ORDER BY fechaMant DESC LIMIT 10');
        $espacios = DB::select('SELECT DISTINCT idEspacio FROM inhumaciones');
        
        return view('cementerio.mantenimiento', compact('mantenimientos', 'espacios'));
    }
    
    /**
     * Guardar mantenimiento
     */
    public function storeMantenimiento(Request $request)
    {
        $validated = $request->validate([
            'idEspacio' => 'required|integer',
            'precio' => 'nullable|numeric',
            'fechaMant' => 'required|date',
            'descripcion' => 'nullable|string',
            'tipo' => 'required|string'
        ]);
        
        DB::insert('INSERT INTO mantenimientos (idEspacio, precio, fechaMant, descripcion, estado, tipo, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())', [
            $validated['idEspacio'],
            $validated['precio'],
            $validated['fechaMant'],
            $validated['descripcion'],
            'pendiente',
            $validated['tipo']
        ]);
        
        return redirect()->route('cementerio.mantenimiento')
                         ->with('success', 'Mantenimiento programado correctamente');
    }
    
    /**
     * Reportes con SQL directo
     */
    public function reportes()
    {
        // Total por mes de defunción
        $totalPorMes = DB::select('SELECT MONTH(fechaDefun) as mes, COUNT(*) as total FROM inhumaciones GROUP BY MONTH(fechaDefun)');
        
        // Total por espacio
        $totalPorEspacio = DB::select('SELECT idEspacio, COUNT(*) as total FROM inhumaciones GROUP BY idEspacio');
        
        // Estadísticas generales
        $estadisticas = [
            'total_por_mes' => $totalPorMes,
            'total_por_espacio' => $totalPorEspacio,
            'total_general' => DB::select('SELECT COUNT(*) as total FROM inhumaciones')[0]->total
        ];
        
        return view('cementerio.reportes', compact('estadisticas'));
    }
    
    /**
     * Registro (formulario)
     */
    public function registro()
    {
        return view('cementerio.registro');
    }
    
    /**
     * Mapa
     */
    public function mapa()
    {
        $difuntos = DB::select('SELECT id, nombre, paterno, materno, idEspacio FROM inhumaciones');
        return view('cementerio.mapa', compact('difuntos'));
    }
    
    /**
     * Consultas (página)
     */
    public function consultas()
    {
        return view('cementerio.consultas');
    }
}