
    let opciones  = document.getElementById("opciones")
    
    let generico = document.getElementById("generico")
    let estatus = document.getElementById("estatus")
    let fechas = document.getElementById("fecha")
    
    opciones.addEventListener("change", () => {
      let eleccion = opciones.options[opciones.selectedIndex].text
      
      switch (eleccion){
          case "ID de Animal":
                          generico.style.display="inline"
                          Veterinarios.style.display = "none"
                          Usuarios.style.display = "none"
          break;
          
          case "Nombre":
                          generico.style.display="inline"
                          fechas.style.display = "none"
                          estatus.style.display = "none"
          break;
          
          case "Año Nacimiento":
                          generico.style.display="none"
                          fechas.style.display = "inline"
                          estatus.style.display = "none"
          break;
          
          case "Fecha Ingreso":
                          generico.style.display="none"
                          fechas.style.display = "inline"
                          estatus.style.display = "none"
          break;
          
          case "Raza":
                          generico.style.display="inline"
                          fechas.style.display = "none"
                          estatus.style.display = "none"
          break;
          
          case "Tamaño":
                          generico.style.display="inline"
                          fechas.style.display = "none"
                          estatus.style.display = "none"
          break;

          default:
                          
          break;
      }
    })


/*

  El js si sirve puede funcionar para los filtros
       <select id="opciones" name="opcion">
          <option>Ninguno</option>
          <option>Animales</option>
          <option>Veterinarios</option>
          <option>Usuarios</option>
          <option>Movimientos</option>
       </select>
       
  <div id="Animales" style="display: none">
      <form action="<?=BASE_URL?>report/Bitacora_Animales" method="POST">
          <label>Animales</label>
          <select name="Columna">
              <option value="0">ID de Animal</option>
              <option value="1">Nombre</option>
              <option value="2">Año Nacimiento</option>
              <option value="3">Fecha Ingreso</option>
              <option value="4">Raza</option>
              <option value="5">Tamaño</option>
              <option value="6">ID de albergue</option>
              <option value="7">Nombre de Albergue</option>
              <option value="8">Tipo de animal</option>
              <option value="9">Estado</option>
          </select>
          <input name="Filtro"></input>
          <button>Generar Reporte</button>
      </form>
  </div>
  
  <div id="Veterinarios" style="display: none">
      <form action="" method="POST">
      <label>Veterinarios</label>
      <select  name="Columna">
              <option value="0">ID Veterinario</option>
              <option value="1">Nombre</option>
              <option value="2">Visibilidad</option>
              <option value="3">Quien lo Registro</option>
          </select>
          <input name="Filtro"></input>
          <button>Generar Reporte</button>
      </form>
      </div>
      
      <div id="Usuarios" style="display: none">
      <form action="" method="POST">
          <label>Usuarios</label>
          <select name="Columna">
              <option value="0">Cedula</option>
              <option value="1">Nombre</option>
              <option value="2">Rol</option>
              <option value="3">Activo</option>
          </select>
          <input name="Filtro"></input>
          <button>Generar Reporte</button>
      </form>
      </div>
      
      <div id="Movimientos" style="display: none">
      <form action="" method="POST">
      <label>Movimientos</label>
      <select name="Columna">
              <option value="0">ID Bitacora</option>
              <option value="1">Usuario Accion</option>
              <option value="2">Modulo afectado</option>
              <option value="3">Accion Realizada</option>
              <option value="4">Fecha Accion</option>
          </select>
          <input name="Filtro"></input>
          <button>Generar Reporte</button>
      </form>
      </div>
      
      <a href="" class="btn" name="Todo">Ver Bitacora Completa</a>

  
  <script>
    let opciones  = document.getElementById("opciones")
    
    let Animales = document.getElementById("Animales")
    let Veterinarios = document.getElementById("Veterinarios")
    let Usuarios = document.getElementById("Usuarios")
    let Movimientos = document.getElementById("Movimientos")
    
    opciones.addEventListener("change", () => {
      let eleccion = opciones.options[opciones.selectedIndex].text
      
      switch (eleccion){
          case "Ninguno":
                          Animales.style.display="none"
                          Veterinarios.style.display = "none"
                          Usuarios.style.display = "none"
                          Movimientos.style.display = "none"
          break;
          
          case "Animales":
                          Animales.style.display="inline"
                          Veterinarios.style.display = "none"
                          Usuarios.style.display = "none"
                          Movimientos.style.display = "none"
          break;
          
          case "Veterinarios":
                          Animales.style.display="none"
                          Veterinarios.style.display = "inline"
                          Usuarios.style.display = "none"
                          Movimientos.style.display = "none"
          break;
          
          case "Usuarios":
                          Animales.style.display="none"
                          Veterinarios.style.display = "none"
                          Usuarios.style.display = "inline"
                          Movimientos.style.display = "none"
          break;
          
          case "Movimientos":
                          Animales.style.display="none"
                          Veterinarios.style.display = "none"
                          Usuarios.style.display = "none"
                          Movimientos.style.display = "inline"
          break;
          
          default:
                          Animales.style.display="none"
                          Veterinarios.style.display = "none"
                          Usuarios.style.display = "none"
                          Movimientos.style.display = "none"
          break;
      }
    })*/