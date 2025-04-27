document.addEventListener("DOMContentLoaded", () => {
    const formFieldsContainer = document.getElementById("formFieldsContainer");

    // Delegación de eventos para eliminar preguntas
    if (formFieldsContainer) {
        formFieldsContainer.addEventListener("click", (e) => {
            const deleteButton = e.target.closest(".delete-question-btn");
            if (deleteButton) {
                const questionBlock = deleteButton.closest(".question-block");
                if (questionBlock) {
                    const dividerLine = questionBlock.nextElementSibling;
                    if (dividerLine && dividerLine.classList.contains("divider-line")) {
                        dividerLine.remove();
                    }
                    questionBlock.remove();
                }
            }
        });

        // Delegación de eventos para eliminar opciones
        formFieldsContainer.addEventListener("click", (e) => {
            const deleteOptionButton = e.target.closest(".delete-option-btn");
            if (deleteOptionButton) {
                const optionItem = deleteOptionButton.closest(".option-item");
                if (optionItem) {
                    optionItem.remove();
                }
            }
        });

        // Delegación de eventos para agregar nuevas opciones
        formFieldsContainer.addEventListener("click", (e) => {
            const addOptionButton = e.target.closest(".add-option-btn");
            if (addOptionButton) {
                const multipleOptionsContainer = addOptionButton.previousElementSibling;
                if (multipleOptionsContainer && multipleOptionsContainer.classList.contains("multiple-options")) {
                    const newOption = document.createElement("div");
                    newOption.classList.add("option-item");

                    newOption.innerHTML = `
                        <input type="radio" disabled>
                        <div class="editable-option" contenteditable="true" spellcheck="false">Nueva opción</div>
                        <button type="button" class="delete-option-btn">🗑️</button>
                    `;

                    multipleOptionsContainer.appendChild(newOption);
                }
            }
        });
    }

    // Mostrar/ocultar los botones al hacer clic en "+ Agregar"
    const addFieldToggle = document.getElementById("addFieldToggle");
    const fieldOptions = document.getElementById("fieldOptions");

    if (addFieldToggle && fieldOptions) {
        addFieldToggle.addEventListener("click", () => {
            fieldOptions.classList.toggle("hidden");
        });

        fieldOptions.addEventListener("click", (e) => {
            const fieldOption = e.target.closest(".field-option");
            if (fieldOption) {
                const questionType = fieldOption.getAttribute("data-type");
                const newQuestion = document.createElement("div");
                newQuestion.classList.add("question-block");
                newQuestion.setAttribute("data-type", questionType);

                newQuestion.innerHTML = `
                    <div class="question-header">
                        <div class="editable-question" contenteditable="true" spellcheck="false">Nueva pregunta</div>
                        <span class="question-type">(${questionType})</span>
                        <button type="button" class="delete-question-btn">
                            <span class="delete-text">Eliminar pregunta</span> 🗑️
                        </button>
                    </div>
                    <div class="response-container">
                        ${
                            questionType === "multiple"
                                ? `
                                <div class="multiple-options"></div>
                                <button type="button" class="add-option-btn">+ Agregar opción</button>
                            `
                                : `<input type="${questionType}" class="question-input">`
                        }
                    </div>
                    <hr class="divider-line">
                `;

                formFieldsContainer.appendChild(newQuestion);
            }
        });
    }

    // Guardar el formulario
    const guardarFormularioBtn = document.getElementById("guardarFormularioBtn");
    if (guardarFormularioBtn) {
        guardarFormularioBtn.addEventListener("click", () => {
            const tituloFormulario = document.querySelector(".editable-text").innerText.trim();
            const preguntas = [];

            document.querySelectorAll(".question-block").forEach((questionBlock) => {
                const tipoMap = {
                    text: "Texto",
                    multiple: "Opción Múltiple",
                    number: "Número",
                    date: "Fecha",
                };

                const pregunta = {
                    id: questionBlock.dataset.id || null,
                    pregunta: questionBlock.querySelector(".editable-question").innerText.trim(),
                    tipo: tipoMap[questionBlock.dataset.type] || questionBlock.dataset.type,
                };

                if (pregunta.tipo === "Opción Múltiple") {
                    const opciones = [];
                    questionBlock.querySelectorAll(".editable-option").forEach((option) => {
                        opciones.push(option.innerText.trim());
                    });
                    pregunta.opciones = opciones;
                }

                preguntas.push(pregunta);
            });

            document.getElementById("tituloFormulario").value = tituloFormulario;
            document.getElementById("preguntasJson").value = JSON.stringify(preguntas);

            const formId = document.getElementById("formularioCreate") ? "formularioCreate" : "formularioEdit";
            document.getElementById(formId).submit();
        });
    }

    // Mostrar el overlay al hacer clic en el botón de compartir
    const shareFormBtn = document.getElementById("shareFormBtn");
    const shareOverlay = document.getElementById("shareOverlay");
    if (shareFormBtn && shareOverlay) {
        shareFormBtn.addEventListener("click", () => {
            shareOverlay.classList.remove("hidden");
        });

        // Copiar la URL al portapapeles
        document.getElementById("copyUrlBtn").addEventListener("click", () => {
            const shareUrl = document.getElementById("shareUrl");
            shareUrl.select();
            document.execCommand("copy");
            alert("URL copiada al portapapeles");
        });

        // Copiar el código al portapapeles
        document.getElementById("copyCodeBtn").addEventListener("click", () => {
            const formCode = document.getElementById("formCode").innerText;
            navigator.clipboard.writeText(formCode).then(() => {
                alert("Código copiado al portapapeles");
            });
        });

        // Ocultar el overlay al hacer clic en el botón de cerrar
        document.getElementById("closeShareOverlay").addEventListener("click", () => {
            shareOverlay.classList.add("hidden");
        });
    }

    // Mostrar el overlay al hacer clic en el botón de eliminar
    const deleteFormBtn = document.getElementById("deleteFormBtn");
    const deleteOverlay = document.getElementById("deleteOverlay");
    if (deleteFormBtn && deleteOverlay) {
        deleteFormBtn.addEventListener("click", () => {
            deleteOverlay.classList.remove("hidden");
        });

        document.getElementById("cancelDelete").addEventListener("click", () => {
            deleteOverlay.classList.add("hidden");
        });
    }

    // Ajustar altura de los campos de texto automáticamente
    document.addEventListener("input", (event) => {
        if (event.target.classList.contains("auto-resize")) {
            event.target.style.height = "auto";
            event.target.style.height = `${event.target.scrollHeight}px`;
        }
    });
});
