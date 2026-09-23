document.addEventListener("DOMContentLoaded", function() {
    const blocks = document.querySelectorAll(".highlight");

    blocks.forEach(function(block) {
        block.style.position = "relative";

        const button = document.createElement("button");
        button.className = "copy-code-btn";
        button.setAttribute("aria-label", "Copiar código");
        
        // Icono SVG minimalista de doble página (Copiar)
        const copyIcon = `
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
                <path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"></path>
            </svg>
        `;
        
        // Icono SVG de check (Éxito)
        const checkIcon = `
            <svg viewBox="0 0 24 24" width="16" height="16" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
        `;

        // Estado inicial
        button.innerHTML = copyIcon;

        button.addEventListener("click", function() {
            const codeElement = block.querySelector("code");
            if (!codeElement) return;

            navigator.clipboard.writeText(codeElement.innerText).then(function() {
                button.innerHTML = checkIcon;
                button.classList.add("copied");
                
                setTimeout(function() {
                    button.innerHTML = copyIcon;
                    button.classList.remove("copied");
                }, 2000);
            });
        });

        block.appendChild(button);
    });
});
