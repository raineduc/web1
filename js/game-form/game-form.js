import { isNumber, getNumber, isYCoordInValidRange } from "../validation.js";

const gameForm = document.documentElement.querySelector(".game-form");
const tableWrapper = document.documentElement.querySelector(".game-results");

const coordInput = gameForm.querySelector(".game-form__coord");
const coordSelect = gameForm.querySelector(".game-form__coord-select");
const radiusInput = gameForm.querySelector(".game-form__radius");

const coordSelectWrapper = coordSelect.closest(".game-form__input-wrapper");
const coordInputWrapper = coordInput.closest(".game-form__input-wrapper");
const radiusInputWrapper = radiusInput.closest(".game-form__input-wrapper");

fetch("./server/hit.php", { method: "GET" })
  .then(res => {
    if (res.ok) {
      return res.text();
    }
  })
  .then(data => {
    tableWrapper.innerHTML = data;
  });

gameForm.addEventListener("submit", async (e) => {
  e.preventDefault();

  const checkedRadiusInput = gameForm.querySelector(
    ".game-form__radius:checked"
  );

  const error = [
    validateRadius(
      radiusInputWrapper,
      checkedRadiusInput && checkedRadiusInput.value
    ),
    validateYCoordinate(coordInputWrapper, coordInput.value),
    validateXCoordinate(coordSelectWrapper, coordSelect.value),
  ].some(value => !value);

  if (error) return;

  const response = await fetch("./server/hit.php", {
    method: "POST",
    body: new FormData(gameForm),
  });

  if (response.ok) {
    const html = await response.text();
    tableWrapper.innerHTML = html;
  } else {
    const error = await response.text();
    alert(`Ошибка ${response.status} ${error ? `: ${error}` : ""}`);
  }
});

Array.from(
  document.documentElement.querySelectorAll(".game-form__radius")
).forEach((input) => {
  input.addEventListener("change", (e) => {
    if (input.checked) removeError(input.closest(".game-form__input-wrapper"));
  });
});

coordInput.addEventListener("blur", (e) => {
  if (hasError(coordInputWrapper)) {
    removeError(coordInputWrapper);
    validateYCoordinate(coordInputWrapper, coordInput.value);
  }
});

coordSelect.addEventListener("change", (e) => {
  if (coordSelect.value) {
    removeError(coordInputWrapper);
  }
});

const addError = (wrapper, message) => {
  wrapper.classList.add("game-form__input-wrapper_error");
  const error =
    wrapper.querySelector(".game-form__input-error") ||
    document.createElement("p");
  if (!wrapper.querySelector(".game-form__input-error")) {
    error.className = "game-form__input-error";
    wrapper.appendChild(error);
  }
  error.textContent = message;
};

const removeError = (wrapper) => {
  wrapper.classList.remove("game-form__input-wrapper_error");
  const error = wrapper.querySelector(".game-form__input-error");
  if (error) error.remove();
};

const hasError = (wrapper) => {
  return Boolean(wrapper.querySelector(".game-form__input-error"));
}

const validateYCoordinate = (wrapper, value) => {
  if (isNumber(value)) {
    const num = getNumber(value);
    if (isYCoordInValidRange(num)) {
      removeError(wrapper);
      return true;
    }
    addError(wrapper, "Координата Y должна быть в пределах (-3, 5)");
    return false;
  }
  addError(wrapper, "В поле введено не число");
  return false;
};

const validateXCoordinate = (wrapper, value) => {
  if (value) {
    removeError(wrapper);
    return true;
  }
  addError(wrapper, "Выберите значение X");
  return false;
};

const validateRadius = (wrapper, value) => {
  if (value) {
    removeError(wrapper);
    return true;
  }
  addError(wrapper, "Выберите значение радиуса R");
  return false;
};
