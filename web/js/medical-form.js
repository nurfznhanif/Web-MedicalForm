/**
 * Medical Form System JavaScript Functions
 * Author: PT BIGS Integrasi Teknologi
 */

// Global variables
let medicalForm = {
  config: {
    bmiCategories: {
      underweight: 18.5,
      normal: 25.0,
      overweight: 27.0,
    },
    riskScoreCategories: {
      low: 24,
      medium: 44,
    },
  },

  // Initialize the medical form
  init: function () {
    this.initBMICalculator();
    this.initRiskAssessment();
    this.initFormValidation();
    this.initDynamicFields();
    this.initPrintFunctionality();
    this.initTooltips();
  },

  // BMI Calculator
  initBMICalculator: function () {
    const beratInput = document.getElementById("berat_badan");
    const tinggiInput = document.getElementById("tinggi_badan");
    const imtInput = document.getElementById("imt");

    if (beratInput && tinggiInput && imtInput) {
      const calculateBMI = () => {
        const berat = parseFloat(beratInput.value);
        const tinggi = parseFloat(tinggiInput.value);

        if (berat && tinggi && tinggi > 0) {
          const tinggiMeter = tinggi / 100;
          const bmi = (berat / (tinggiMeter * tinggiMeter)).toFixed(2);
          imtInput.value = bmi;

          // Update status gizi automatically
          this.updateStatusGizi(parseFloat(bmi));

          // Show BMI category
          this.showBMICategory(parseFloat(bmi));
        } else {
          imtInput.value = "";
          this.clearStatusGizi();
        }
      };

      beratInput.addEventListener("input", calculateBMI);
      tinggiInput.addEventListener("input", calculateBMI);

      // Calculate on page load if values exist
      if (beratInput.value && tinggiInput.value) {
        calculateBMI();
      }
    }
  },

  // Update status gizi based on BMI
  updateStatusGizi: function (bmi) {
    const statusGiziInputs = document.getElementsByName("status_gizi");

    if (statusGiziInputs.length > 0) {
      // Clear all selections
      statusGiziInputs.forEach((input) => (input.checked = false));

      // Select appropriate status
      if (bmi < this.config.bmiCategories.underweight) {
        // Kurang
        if (statusGiziInputs[1]) statusGiziInputs[1].checked = true;
      } else if (
        bmi >= this.config.bmiCategories.underweight &&
        bmi <= this.config.bmiCategories.normal
      ) {
        // Ideal
        if (statusGiziInputs[0]) statusGiziInputs[0].checked = true;
      } else {
        // Obesitas
        if (statusGiziInputs[2]) statusGiziInputs[2].checked = true;
      }
    }
  },

  // Clear status gizi selection
  clearStatusGizi: function () {
    const statusGiziInputs = document.getElementsByName("status_gizi");
    statusGiziInputs.forEach((input) => (input.checked = false));
  },

  // Show BMI category message
  showBMICategory: function (bmi) {
    let category, className;

    if (bmi < this.config.bmiCategories.underweight) {
      category = "Kurang Berat Badan";
      className = "text-warning";
    } else if (bmi <= this.config.bmiCategories.normal) {
      category = "Normal";
      className = "text-success";
    } else if (bmi <= this.config.bmiCategories.overweight) {
      category = "Gemuk";
      className = "text-warning";
    } else {
      category = "Obesitas";
      className = "text-danger";
    }

    // Show category near IMT input
    this.showTooltip("imt", `BMI: ${category}`, className);
  },

  // Risk Assessment Calculator
  initRiskAssessment: function () {
    const riskFactors = document.querySelectorAll(".risk-factor");
    const totalScoreInput = document.getElementById("total_score");

    if (riskFactors.length > 0 && totalScoreInput) {
      const calculateRiskScore = () => {
        let totalScore = 0;

        // Update individual result inputs
        for (let i = 1; i <= 6; i++) {
          const checkedInput = document.querySelector(
            `input[name="risk_${i}"]:checked`
          );
          const resultInput = document.querySelector(
            `input[name="result_${i}"]`
          );

          if (checkedInput && resultInput) {
            const score =
              parseInt(checkedInput.getAttribute("data-score")) || 0;
            resultInput.value = score;
            totalScore += score;
          } else if (resultInput) {
            resultInput.value = 0;
          }
        }

        totalScoreInput.value = totalScore;
        this.updateRiskCategory(totalScore);
      };

      riskFactors.forEach((factor) => {
        factor.addEventListener("change", calculateRiskScore);
      });

      // Calculate on page load
      calculateRiskScore();
    }
  },

  // Update risk category display
  updateRiskCategory: function (totalScore) {
    let category, className, recommendation;

    if (totalScore <= this.config.riskScoreCategories.low) {
      category = "Tidak berisiko (0-24)";
      className = "alert-success";
      recommendation = "Perawatan standar";
    } else if (totalScore <= this.config.riskScoreCategories.medium) {
      category = "Resiko rendah (25-44)";
      className = "alert-warning";
      recommendation = "Lakukan intervensi jatuh standar";
    } else {
      category = "Resiko tinggi (≥45)";
      className = "alert-danger";
      recommendation = "Lakukan intervensi jatuh resiko tinggi";
    }

    // Update or create risk category display
    this.updateRiskCategoryDisplay(category, className, recommendation);
  },

  // Update risk category display element
  updateRiskCategoryDisplay: function (category, className, recommendation) {
    let riskDisplay = document.getElementById("risk-category-display");

    if (!riskDisplay) {
      riskDisplay = document.createElement("div");
      riskDisplay.id = "risk-category-display";
      riskDisplay.className = "alert mt-3";

      const totalScoreInput = document.getElementById("total_score");
      if (totalScoreInput && totalScoreInput.closest(".table-responsive")) {
        totalScoreInput
          .closest(".table-responsive")
          .parentNode.appendChild(riskDisplay);
      }
    }

    riskDisplay.className = `alert mt-3 ${className}`;
    riskDisplay.innerHTML = `
            <h6 class="alert-heading">${category}</h6>
            <p class="mb-0"><strong>Rekomendasi:</strong> ${recommendation}</p>
        `;
  },

  // Dynamic field toggles
  initDynamicFields: function () {
    // Toggle operasi detail
    const operasiInputs = document.getElementsByName("riwayat_operasi");
    if (operasiInputs.length > 0) {
      operasiInputs.forEach((input) => {
        input.addEventListener("change", () => {
          this.toggleOperasiDetail();
        });
      });
    }

    // Toggle dirawat detail
    const dirawatInputs = document.getElementsByName("riwayat_dirawat");
    if (dirawatInputs.length > 0) {
      dirawatInputs.forEach((input) => {
        input.addEventListener("change", () => {
          this.toggleDirawatDetail();
        });
      });
    }
  },

  // Toggle operasi detail fields
  toggleOperasiDetail: function () {
    const operasiYa = document.querySelector(
      'input[name="riwayat_operasi"][value="ya"]'
    );
    const operasiDetail = document.getElementById("operasi_detail");

    if (operasiDetail) {
      if (operasiYa && operasiYa.checked) {
        operasiDetail.style.display = "block";
        operasiDetail.classList.add("fade-in");
      } else {
        operasiDetail.style.display = "none";
        operasiDetail.classList.remove("fade-in");
      }
    }
  },

  // Toggle dirawat detail fields
  toggleDirawatDetail: function () {
    const dirawatYa = document.querySelector(
      'input[name="riwayat_dirawat"][value="ya"]'
    );
    const dirawatDetail = document.getElementById("dirawat_detail");

    if (dirawatDetail) {
      if (dirawatYa && dirawatYa.checked) {
        dirawatDetail.style.display = "block";
        dirawatDetail.classList.add("fade-in");
      } else {
        dirawatDetail.style.display = "none";
        dirawatDetail.classList.remove("fade-in");
      }
    }
  },

  // Form validation
  initFormValidation: function () {
    const forms = document.getElementsByClassName("needs-validation");

    Array.prototype.filter.call(forms, (form) => {
      form.addEventListener(
        "submit",
        (event) => {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
            this.showValidationErrors(form);
          }
          form.classList.add("was-validated");
        },
        false
      );
    });

    // Real-time validation
    this.initRealTimeValidation();
  },

  // Real-time validation
  initRealTimeValidation: function () {
    // NIK validation
    const nikInput = document.querySelector('input[name="Registrasi[nik]"]');
    if (nikInput) {
      nikInput.addEventListener("input", (e) => {
        let value = e.target.value;
        // Remove non-digits
        value = value.replace(/\D/g, "");
        // Limit to 16 digits
        if (value.length > 16) {
          value = value.slice(0, 16);
        }
        e.target.value = value;

        // Validate NIK format
        if (value.length === 16) {
          e.target.setCustomValidity("");
        } else if (value.length > 0) {
          e.target.setCustomValidity("NIK harus 16 digit");
        } else {
          e.target.setCustomValidity("");
        }
      });
    }

    // Name validation (no numbers)
    const nameInput = document.querySelector(
      'input[name="Registrasi[nama_pasien]"]'
    );
    if (nameInput) {
      nameInput.addEventListener("input", (e) => {
        let value = e.target.value;
        // Remove numbers
        value = value.replace(/[0-9]/g, "");
        e.target.value = value;
      });
    }
  },

  // Show validation errors
  showValidationErrors: function (form) {
    const invalidInputs = form.querySelectorAll(":invalid");
    if (invalidInputs.length > 0) {
      invalidInputs[0].focus();
      this.showAlert("Mohon lengkapi semua field yang wajib diisi", "danger");
    }
  },

  // Print functionality
  initPrintFunctionality: function () {
    const printButtons = document.querySelectorAll(".print-btn, .btn-print");

    printButtons.forEach((button) => {
      button.addEventListener("click", (e) => {
        e.preventDefault();
        window.print();
      });
    });

    // Print shortcuts
    document.addEventListener("keydown", (e) => {
      if (e.ctrlKey && e.key === "p") {
        e.preventDefault();
        window.print();
      }
    });
  },

  // Initialize tooltips
  initTooltips: function () {
    // Initialize Bootstrap tooltips if available
    if (typeof bootstrap !== "undefined" && bootstrap.Tooltip) {
      const tooltipTriggerList = [].slice.call(
        document.querySelectorAll('[data-bs-toggle="tooltip"]')
      );
      tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
      });
    }
  },

  // Show custom tooltip
  showTooltip: function (elementId, message, className = "text-info") {
    const element = document.getElementById(elementId);
    if (!element) return;

    // Remove existing tooltip
    let existingTooltip = element.parentNode.querySelector(".custom-tooltip");
    if (existingTooltip) {
      existingTooltip.remove();
    }

    // Create new tooltip
    const tooltip = document.createElement("div");
    tooltip.className = `custom-tooltip small ${className}`;
    tooltip.innerHTML = message;
    tooltip.style.marginTop = "5px";

    element.parentNode.appendChild(tooltip);

    // Auto remove after 3 seconds
    setTimeout(() => {
      if (tooltip.parentNode) {
        tooltip.remove();
      }
    }, 3000);
  },

  // Show alert message
  showAlert: function (message, type = "info", duration = 5000) {
    // Create alert element
    const alertDiv = document.createElement("div");
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

    // Find container or create one
    let container = document.querySelector(".alert-container");
    if (!container) {
      container = document.createElement("div");
      container.className = "alert-container";
      container.style.position = "fixed";
      container.style.top = "20px";
      container.style.right = "20px";
      container.style.zIndex = "9999";
      container.style.maxWidth = "400px";
      document.body.appendChild(container);
    }

    container.appendChild(alertDiv);

    // Auto remove
    setTimeout(() => {
      if (alertDiv.parentNode) {
        alertDiv.classList.remove("show");
        setTimeout(() => {
          if (alertDiv.parentNode) {
            alertDiv.remove();
          }
        }, 150);
      }
    }, duration);
  },

  // Loading state management
  setLoading: function (element, state = true) {
    if (typeof element === "string") {
      element = document.getElementById(element);
    }

    if (!element) return;

    if (state) {
      element.disabled = true;
      element.classList.add("loading");
    } else {
      element.disabled = false;
      element.classList.remove("loading");
    }
  },

  // Format number with thousands separator
  formatNumber: function (num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
  },

  // Format date to Indonesian format
  formatDate: function (date) {
    const options = {
      year: "numeric",
      month: "long",
      day: "numeric",
      timeZone: "Asia/Jakarta",
    };
    return new Date(date).toLocaleDateString("id-ID", options);
  },

  // Auto-save functionality (if needed)
  initAutoSave: function () {
    const form = document.getElementById("medical-form");
    if (!form) return;

    let autoSaveTimer;
    const autoSaveDelay = 30000; // 30 seconds

    const inputs = form.querySelectorAll("input, select, textarea");
    inputs.forEach((input) => {
      input.addEventListener("change", () => {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
          this.saveFormData();
        }, autoSaveDelay);
      });
    });
  },

  // Save form data to localStorage
  saveFormData: function () {
    const form = document.getElementById("medical-form");
    if (!form) return;

    const formData = new FormData(form);
    const data = {};

    for (let [key, value] of formData.entries()) {
      data[key] = value;
    }

    localStorage.setItem("medical-form-autosave", JSON.stringify(data));
    this.showAlert("Data tersimpan otomatis", "success", 2000);
  },

  // Load form data from localStorage
  loadFormData: function () {
    const savedData = localStorage.getItem("medical-form-autosave");
    if (!savedData) return;

    try {
      const data = JSON.parse(savedData);

      Object.keys(data).forEach((key) => {
        const element = document.querySelector(`[name="${key}"]`);
        if (element) {
          if (element.type === "checkbox" || element.type === "radio") {
            element.checked = element.value === data[key];
          } else {
            element.value = data[key];
          }
        }
      });

      this.showAlert("Data sebelumnya dimuat kembali", "info", 3000);
    } catch (e) {
      console.error("Error loading saved data:", e);
    }
  },

  // Clear auto-saved data
  clearAutoSave: function () {
    localStorage.removeItem("medical-form-autosave");
  },
};

// Global functions for backward compatibility
function toggleOperasiDetail() {
  medicalForm.toggleOperasiDetail();
}

function toggleDirawatDetail() {
  medicalForm.toggleDirawatDetail();
}

// Initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  medicalForm.init();

  // Add smooth animations
  document.body.classList.add("fade-in");
});

// Initialize on page load as well (for older browsers)
window.addEventListener("load", function () {
  // Additional initialization if needed
});

// Export for module systems
if (typeof module !== "undefined" && module.exports) {
  module.exports = medicalForm;
}
