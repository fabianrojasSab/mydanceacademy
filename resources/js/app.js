import './bootstrap';
import 'flowbite';

// Funcion para agregar opcion de busqueda en las tablas con el id search-table (flowbite)
if (document.getElementById("search-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#search-table", {
        searchable: true,
        sortable: false
    });
}