(function () {
    function getDecimals(element) {
        const decimals = parseInt(element.dataset.decimals || "2", 10);

        return Number.isNaN(decimals) ? 2 : decimals;
    }

    function cleanCurrency(value, decimals = 2) {
        value = String(value || "");

        // Hapus koma dan karakter selain angka/titik
        let cleaned = value.replace(/,/g, "").replace(/[^\d.]/g, "");

        // Cegah titik lebih dari satu
        const firstDotIndex = cleaned.indexOf(".");

        if (firstDotIndex !== -1) {
            cleaned =
                cleaned.substring(0, firstDotIndex + 1) +
                cleaned.substring(firstDotIndex + 1).replace(/\./g, "");
        }

        let parts = cleaned.split(".");
        let integerPart = parts[0] || "";
        let decimalPart = parts[1];

        // Hapus nol di depan, contoh: 00039000 menjadi 39000
        integerPart = integerPart.replace(/^0+(?=\d)/, "");

        if (cleaned.startsWith(".")) {
            integerPart = "0";
        }

        if (decimalPart !== undefined) {
            decimalPart = decimalPart.substring(0, decimals);
            return `${integerPart || "0"}.${decimalPart}`;
        }

        return integerPart;
    }

    function formatCurrency(value, decimals = 2) {
        value = cleanCurrency(value, decimals);

        if (value === "" || value === ".") {
            return "";
        }

        return Number(value).toLocaleString("en-US", {
            minimumFractionDigits: decimals,
            maximumFractionDigits: decimals,
        });
    }

    function formatTyping(value, decimals = 2) {
        value = cleanCurrency(value, decimals);

        if (value === "") {
            return "";
        }

        const hasDot = value.includes(".");
        let parts = value.split(".");

        let integerPart = parts[0] || "0";
        let decimalPart = parts[1];

        let formattedInteger = Number(integerPart || 0).toLocaleString("en-US");

        if (hasDot) {
            decimalPart = decimalPart || "";
            return `${formattedInteger}.${decimalPart}`;
        }

        return formattedInteger;
    }

    function getTargetInput(displayInput) {
        const targetSelector = displayInput.dataset.target;

        if (!targetSelector) {
            return null;
        }

        return document.querySelector(targetSelector);
    }

    function updateCurrencyInput(displayInput) {
        const decimals = getDecimals(displayInput);
        const targetInput = getTargetInput(displayInput);

        const rawValue = cleanCurrency(displayInput.value, decimals);

        displayInput.value = formatTyping(rawValue, decimals);

        if (targetInput) {
            if (rawValue === "") {
                targetInput.value = "";
            } else {
                targetInput.value = Number(rawValue).toFixed(decimals);
            }
        }
    }

    function finalizeCurrencyInput(displayInput) {
        const decimals = getDecimals(displayInput);
        const targetInput = getTargetInput(displayInput);

        let rawValue = "";

        if (targetInput && targetInput.value !== "") {
            rawValue = targetInput.value;
        } else {
            rawValue = cleanCurrency(displayInput.value, decimals);
        }

        if (rawValue === "") {
            displayInput.value = "";

            if (targetInput) {
                targetInput.value = "";
            }

            return;
        }

        const formattedValue = formatCurrency(rawValue, decimals);

        displayInput.value = formattedValue;

        if (targetInput) {
            targetInput.value = Number(
                cleanCurrency(rawValue, decimals),
            ).toFixed(decimals);
        }
    }

    function initializeCurrencyInput(displayInput) {
        const decimals = getDecimals(displayInput);
        const targetInput = getTargetInput(displayInput);

        if (targetInput && targetInput.value !== "") {
            displayInput.value = formatCurrency(targetInput.value, decimals);
            targetInput.value = Number(
                cleanCurrency(targetInput.value, decimals),
            ).toFixed(decimals);
            return;
        }

        if (displayInput.value !== "") {
            updateCurrencyInput(displayInput);
            finalizeCurrencyInput(displayInput);
        }
    }

    // Event global untuk semua input dengan class .currency-input
    document.addEventListener("input", function (event) {
        if (event.target.classList.contains("currency-input")) {
            updateCurrencyInput(event.target);
        }
    });

    // Blur tidak bubble, jadi pakai capture true
    document.addEventListener(
        "blur",
        function (event) {
            if (event.target.classList.contains("currency-input")) {
                finalizeCurrencyInput(event.target);
            }
        },
        true,
    );

    // Auto-format saat halaman pertama kali dibuka
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".currency-input").forEach(function (input) {
            initializeCurrencyInput(input);
        });
    });

    // Optional: supaya bisa dipakai dari script lain
    window.AppCurrency = {
        clean: cleanCurrency,
        format: formatCurrency,
        setValue: function (displaySelector, value) {
            const displayInput = document.querySelector(displaySelector);

            if (!displayInput) {
                return;
            }

            const decimals = getDecimals(displayInput);
            const targetInput = getTargetInput(displayInput);
            const cleanedValue = cleanCurrency(value, decimals);

            displayInput.value = formatCurrency(cleanedValue, decimals);

            if (targetInput) {
                targetInput.value =
                    cleanedValue === ""
                        ? ""
                        : Number(cleanedValue).toFixed(decimals);
            }
        },
    };
})();
