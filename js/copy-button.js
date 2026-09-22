document.addEventListener("DOMContentLoaded", function() {
    // Selecciona todos los contenedores .highlight de pymdownx
    const blocks = document.querySelectorAll(".highlight");

    blocks.forEach(function(block) {
        // Asegurar posicionamiento relativo para alinear el botón correctamente
        block.style.position = "relative";

        // Crear el botón de copiar
        const button = document.createElement("button");
        button.className = "copy-code-btn";
        button.innerText = "Copiar";

        // Lógica de copiado adaptada para resaltar con HLJS
        button.addEventListener("click", function() {
            // Buscamos la etiqueta code que tiene la clase de highlight.js
            const codeElement = block.querySelector("code");
            if (!codeElement) return;

            // Extraemos el texto plano (sin las etiquetas HTML de los colores)
            const codeText = codeElement.innerText;

            navigator.clipboard.writeText(codeText).then(function() {
                button.innerText = "¡Copiado!";
                button.classList.add("copied");
                
                setTimeout(function() {
                    button.innerText = "Copiar";
                    button.classList.remove("copied");
                }, 2000);
            });
        });

        // Insertar el botón en el contenedor
        block.appendChild(button);
    });
});
