document.addEventListener("DOMContentLoaded", function () {
    function initFourcrownsGalleryButtons(context = document) {
        context.querySelectorAll(".fourcrowns-gallery-button").forEach(button => {
            button.removeEventListener("click", button._fourcrownsHandler || (() => {}));

            const handler = function (e) {
                e.preventDefault();
                const wrapper = button.closest(".fourcrowns-gallery-wrapper");
                const targetInput = wrapper.querySelector(".fourcrowns-gallery-field");
                const preview = wrapper.querySelector(".fourcrowns-gallery-preview");

                const currentIds = targetInput.value ? targetInput.value.split(",").map(id => id.trim()).filter(id => id !== "") : [];

                const frame = wp.media({
                    title: "Vybrat obrázky",
                    multiple: true,
                    library: { type: "image" },
                    button: { text: "Přidat obrázky" }
                });

                frame.on("select", function () {
                    const selection = frame.state().get("selection");

                    selection.each(function(attachment) {
                        const id = attachment.id.toString();
                        if (!currentIds.includes(id)) {
                            currentIds.push(id);
                            const thumbUrl = attachment.attributes.sizes?.thumbnail?.url || attachment.attributes.icon;
                            const span = document.createElement("span");
                            span.dataset.id = id;
                            span.classList.add("fourcrowns-gallery-thumb");
                            span.innerHTML = `
                            <img src="${thumbUrl}" style="height:60px;">
                            <button class="fourcrowns-gallery-remove" title="Odebrat obrázek">×</button>
                        `;
                            preview.appendChild(span);
                        }
                    });

                    if (targetInput) {
                        targetInput.value = currentIds.join(",");
                    }
                });

                frame.open();
            };

            button.addEventListener("click", handler);
            button._fourcrownsHandler = handler;
        });

        // Odebrání jednotlivých obrázků
        context.addEventListener("click", function (e) {
            if (e.target.classList.contains("fourcrowns-gallery-remove")) {
                e.preventDefault();
                const span = e.target.closest("span[data-id]");
                const wrapper = span.closest(".fourcrowns-gallery-wrapper");
                const input = wrapper.querySelector(".fourcrowns-gallery-field");
                const idToRemove = span.dataset.id;
                span.remove();

                const ids = Array.from(wrapper.querySelectorAll(".fourcrowns-gallery-preview span[data-id]"))
                    .map(el => el.dataset.id);
                input.value = ids.join(",");
            }
        });

        // Přetažení a efekt při změně pořadí
        context.querySelectorAll(".fourcrowns-gallery-preview").forEach(preview => {
            if (typeof Sortable !== "undefined") {
                new Sortable(preview, {
                    animation: 150,
                    onStart: function (evt) {
                        evt.item.classList.add("sortable-chosen");
                    },
                    onEnd: function (evt) {
                        evt.item.classList.remove("sortable-chosen");
                    },
                    onSort: function () {
                        const wrapper = preview.closest(".fourcrowns-gallery-wrapper");
                        const input = wrapper.querySelector(".fourcrowns-gallery-field");
                        const ids = Array.from(preview.querySelectorAll("span[data-id]")).map(el => el.dataset.id);
                        input.value = ids.join(",");
                    }
                });
            }
        });
    }


    initFourcrownsGalleryButtons();

    document.querySelectorAll(".fourcrowns-repeater-add").forEach(addBtn => {
        addBtn.addEventListener("click", function () {
            setTimeout(() => {
                initFourcrownsGalleryButtons();
                initTrumbowyg();
            }, 150);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    function initFourcrownsImageButtons(context = document) {
        context.querySelectorAll(".fourcrowns-upload-button").forEach(button => {
            button.removeEventListener("click", button._fourcrownsHandler || (() => {}));

            const handler = function (e) {
                e.preventDefault();
                const wrapper = button.closest(".fourcrowns-image-wrapper");
                const input = wrapper.querySelector(".fourcrowns-image-field");
                const preview = wrapper.querySelector(".fourcrowns-image-preview");

                const frame = wp.media({
                    title: "Vybrat obrázek",
                    multiple: false,
                    library: { type: "image" },
                    button: { text: "Použít obrázek" }
                });

                frame.on("select", function () {
                    const attachmentModel = frame.state().get("selection").first();
                    const attachment = attachmentModel.toJSON();
                    const id = attachmentModel.get('id');

                    if (input) {
                        input.value = JSON.stringify({
                            id: attachment.id,
                            url: attachment.url
                        });
                    }
                    if (preview) {
                        preview.innerHTML = "<img src=\'" + attachment.url + "\' style=\'max-height: 60px; display:block; margin-top:5px;\' />";
                    }
                });

                frame.open();
            };

            button.addEventListener("click", handler);
            button._fourcrownsHandler = handler;
        });
    }

    initFourcrownsImageButtons();

    document.querySelectorAll(".fourcrowns-repeater-add").forEach(addBtn => {
        addBtn.addEventListener("click", function () {
            setTimeout(() => {
                initFourcrownsImageButtons();
                initTrumbowyg();
            }, 150);
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".fourcrowns-multiselect").forEach(select => {
        if (!select.classList.contains("choices-initialized")) {
            new Choices(select, {
                removeItemButton: true,
                placeholderValue: "Vyberte...",
                searchEnabled: true,
                classNames: {
                    containerInner: "choices__inner"
                }
            });
            select.classList.add("choices-initialized");
        }
    });
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".fourcrowns-repeater").forEach(container => {
        const addButton = container.querySelector(".fourcrowns-repeater-add");
        if (!addButton) return;

        const template = container.querySelector(".fourcrowns-repeater-item");
        if (!template) return;

        addButton.addEventListener("click", function (e) {
            e.preventDefault();

            const currentItems = container.querySelectorAll(".fourcrowns-repeater-item");
            const max = parseInt(container.dataset.max || 0);

            if (max && currentItems.length >= max) {
                let msg = container.querySelector(".fourcrowns-repeater-limit-msg");
                if (!msg) {
                    msg = document.createElement("div");
                    msg.className = "fourcrowns-repeater-limit-msg";
                    container.appendChild(msg);
                }
                msg.textContent = "Maximální počet je " + max + ".";
                msg.style.display = "block";
                return;
            } else {
                const msg = container.querySelector(".fourcrowns-repeater-limit-msg");
                if (msg) msg.style.display = "none";
            }

            // před klonováním vyčistit všechny trumbowyg editory v šabloně
            template.querySelectorAll('.fourcrowns-trumbowyg').forEach(el => {
                if (jQuery(el).hasClass('trumbowyg-initialized')) {
                    jQuery(el).trumbowyg('destroy');
                    jQuery(el).removeClass('trumbowyg-initialized');
                }
            });

            const clone = template.cloneNode(true);
            const newIndex = currentItems.length;

            clone.querySelectorAll("[name]").forEach(input => {
                const name = input.getAttribute("name");
                if (name) {
                    input.setAttribute("name", name.replace(/\[\d+\]/, "[" + newIndex + "]"));
                    input.value = "";
                }
            });

            clone.querySelectorAll(".fourcrowns-image-preview, .fourcrowns-gallery-preview").forEach(preview => {
                preview.innerHTML = "";
            });

            container.insertBefore(clone, addButton);
            initTrumbowyg(clone);
            initFourcrownsFlatpickr(clone);
        });

        container.addEventListener("click", function (e) {
            if (e.target.classList.contains("fourcrowns-repeater-remove")) {
                e.preventDefault();
                const item = e.target.closest(".fourcrowns-repeater-item");
                if (item && container.querySelectorAll(".fourcrowns-repeater-item").length > 1) {
                    item.remove();
                }
            }
        });

        if (typeof Sortable !== "undefined") {
            container.classList.add("fourcrowns-repeater-enabled");
            new Sortable(container, {
                animation: 150,
                handle: ".fourcrowns-drag-handle",
                draggable: ".fourcrowns-repeater-item"
            });
        }
    });

    const style = document.createElement("style");
    style.innerHTML = `
        .fourcrowns-repeater-item.sortable-chosen {
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            transform: scale(1.02);
            transition: all 0.2s ease;
            background: #fff;
        }
    `;
    document.head.appendChild(style);
});

document.addEventListener("DOMContentLoaded", function () {
    initTrumbowyg();
});

function initTrumbowyg(context = document) {
    jQuery(context).find('.fourcrowns-trumbowyg').each(function () {
        const $this = jQuery(this);
        if (!$this.hasClass('trumbowyg-initialized')) {
            $this.trumbowyg({
                autogrow: true
            });
            $this.addClass('trumbowyg-initialized');
        }
    });
}

function initFourcrownsFlatpickr(context = document) {
    if (typeof flatpickr !== "undefined") {
        context.querySelectorAll(".fourcrowns-date").forEach(input => {
            flatpickr(input, {
                dateFormat: "Y-m-d"
            });
        });

        context.querySelectorAll(".fourcrowns-datetime").forEach(input => {
            flatpickr(input, {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true
            });
        });
    }
}

// Načtení při načtení stránky
document.addEventListener("DOMContentLoaded", function () {
    initFourcrownsFlatpickr();
});