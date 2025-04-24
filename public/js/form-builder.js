document.addEventListener("DOMContentLoaded", () => {
    const formFieldsContainer = document.getElementById("formFieldsContainer");

    // Delegación de eventos para eliminar preguntas
    formFieldsContainer.addEventListener("click", (e) => {
        const deleteButton = e.target.closest(".delete-question-btn");
        if (deleteButton) {
            const questionBlock = deleteButton.closest(".question-block");
            if (questionBlock) {
                // Eliminar la línea punteada asociada
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
            const multipleOptionsContainer = addOptionButton.previousElementSibling; // Contenedor de opciones
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

    // Mostrar/ocultar los botones al hacer clic en "+ Agregar"
    const addFieldToggle = document.getElementById("addFieldToggle");
    const fieldOptions = document.getElementById("fieldOptions");

    if (addFieldToggle && fieldOptions) {
        addFieldToggle.addEventListener("click", () => {
            fieldOptions.classList.toggle("hidden");
        });

        // Delegación de eventos para los 4 botones de agregar preguntas
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
    document.getElementById("guardarFormularioBtn").addEventListener("click", () => {
        const tituloFormulario = document.querySelector(".editable-text").innerText.trim();
        const preguntas = [];

        document.querySelectorAll(".question-block").forEach((questionBlock) => {
            // Mapeo de tipos del frontend a los valores esperados por la base de datos
            const tipoMap = {
                text: "Texto",
                multiple: "Opción Múltiple",
                number: "Número",
                date: "Fecha",
            };

            const pregunta = {
                id: questionBlock.dataset.id || null, // ID de la pregunta (si existe)
                pregunta: questionBlock.querySelector(".editable-question").innerText.trim(),
                tipo: tipoMap[questionBlock.dataset.type] || questionBlock.dataset.type, // Mapear el tipo
            };

            // Si es de tipo "Opción Múltiple", agregar las opciones
            if (pregunta.tipo === "Opción Múltiple") {
                const opciones = [];
                questionBlock.querySelectorAll(".editable-option").forEach((option) => {
                    opciones.push(option.innerText.trim());
                });
                pregunta.opciones = opciones;
            }

            preguntas.push(pregunta);
        });

        // Asignar los valores a los campos ocultos
        document.getElementById("tituloFormulario").value = tituloFormulario;
        document.getElementById("preguntasJson").value = JSON.stringify(preguntas);

        // Enviar el formulario
        document.getElementById("formularioEdit").submit();
    });
});
