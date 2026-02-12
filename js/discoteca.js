function borrarAlbum(codAlbum, tituAlbum){
    if (confirm("¿Seguro que quiere borrar el album " + tituAlbum + " ?, se borraran tambien las canciones asociadas.")) {
        window.location = "../backend/borrar_album.php?cod_album=" + codAlbum;
    } else {
        alert("Borrado del album cancelado");
    }
}

function borrarGrupo(codGrupo, tituGrupo){
    if (confirm("¿Seguro que quiere borrar el grupo " + tituGrupo + " ?, se borraran tambien los grupos y las canciones asociadas.")) {
        window.location = "../backend/borrar_grupo.php?cod_grupo=" + codGrupo;
    } else {
        alert("Borrado del grupo cancelado");
    }
}

function borrarCancion(codCancion, tituCancion, codAlbum, tituAlbum){
    if (confirm("¿Seguro que quiere borrar la cancion " + tituCancion + " ?")) {
        window.location = "../backend/borrar_cancion.php?cod_cancion=" + codCancion + "&cod_album=" + codAlbum + "&nombreAlbum=" + tituAlbum;
    } else {
        alert("Borrado de la cancion cancelado");
    }
}